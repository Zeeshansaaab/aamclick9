<?php

namespace App\Http\Controllers\FrontEnd;

use Exception;
use App\Enums\Status;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Models\CommitteeUser;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use App\Notifications\PaymentNotification;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function index($type)
    {
        $gateways = Gateway::query();
        $gateways = $type == 'deposit' ? $gateways->deposit() : $gateways->withdrawal();
        $gateways = $gateways->get();
        return view('frontend.deposit.index', compact('gateways', 'type'));
    }

    public function depositConfirmation(DepositRequest $request)
    {
        $gateway = Gateway::find(request()->method_id);
        $amount = $request->amount;
        Session::put('deposit-amount', $amount);
        Session::put('deposit_type', $request->deposit_type);
        $committees = [];
        if($request->deposit_type == 'committee'){
            $committees = CommitteeUser::whereHas('plan', function ($query) {
                $query->where('starting_date', '>=', now());
            })->where('user_id', auth()->user()->id)->get();
            if(count($committees) == 0) {
                return response()->json([
                    'status' => JsonResponse::HTTP_FORBIDDEN,
                    'message' => "You are not enrolled in any commitee or commitee starting date is not reached"
                ], JsonResponse::HTTP_FORBIDDEN);
            }
        }
        $type = $request->type;        
        return Blade::render('<x-deposit-confirm :amount="$amount" :gateway="$gateway" :committees="$committees" :type="$type"/>', ['amount' => $amount, 'gateway' => $gateway, 'committees' => $committees, 'type' => $type]);
    }
    public function depositConfirmed(Request $request)
    {
        $depositType = Session::get('deposit_type');

        $request->validate([
            'method_id' => 'required',
            'committee_id' => Rule::requiredIf(function () use($depositType){
                $depositType == 'committee';
            })
        ]);
        try{

            DB::beginTransaction();

            $gateway = Gateway::findOrFail($request->method_id);
            $this->createPayment($request, $gateway, '+', Session::get('deposit-amount'));

            DB::commit();
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => "Deposited successfully"
            ], JsonResponse::HTTP_OK);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function withdrawConfirmation(Request $request)
    {
        $gateway = Gateway::find(request()->method_id);
        $request->validate([
            'amount' => 'numeric|min:' . $gateway->min_amount . ', max:' . $gateway->max_amount 
        ]);
        try {
            $user = auth()->user()->load('planUser');
            $type = $request->deposit_type;
            if ($user->planUser->$type < $request->amount) {
                return response()->json([
                    'status' => JsonResponse::HTTP_FORBIDDEN,
                    'message' => "You dont have sufficient balance"
                ], JsonResponse::HTTP_FORBIDDEN);
            }
            Session::put('deposit_type', $request->deposit_type);
            Session::put('withdraw-amount', $request->amount);

            return Blade::render('<x-deposit-confirm :amount="$amount" :gateway="$gateway" :committees="$committees" :type="$type"/>', ['amount' => $request->amount, 'gateway' => $gateway, 'committees' => [], 'type' => $type]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function withdrawConfirmed(Request $request)
    {
        try{
            $depositType = Session::get('deposit_type');
            $request->validate([
                'method_id' => 'required',
            ]);

            DB::beginTransaction();
            $gateway = Gateway::findOrFail($request->method_id);
            $amount = Session::get('withdraw-amount');

            $payment = $this->createPayment($request, $gateway, '-', $amount);
            
            $user = auth()->user()->load('planUser');
            $user->planUser->$depositType -= $payment->transaction->amount;
            $user->planUser->save();
            DB::commit();
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => "Withdraw successfully"
            ], JsonResponse::HTTP_OK);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'line'   => $e->getLine(),
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createPayment($request, $gateway, $trx_type, $amount)
    {
        try{
            DB::beginTransaction();
            $depositType =  Session::get('deposit_type');
            $amount = floatval($amount);
            $charge = $gateway->fixed_charge + ($amount * $gateway->percent_charge / 100);
            $afterCharge = ($amount) - $charge;
            $finalAmount = $afterCharge * $gateway->currency_value;
            $transation = auth()->user()->transactions()->create([
                'amount'        => $finalAmount,
                'charge'        => $charge,
                'trx_type'      => $trx_type,
                'trx'           => getTrx(),
                'details'       => "Amount " . $trx_type == '-' ? "withdrawal" : 'deposited' . " via " . $gateway->name,
                'remark'        => $trx_type == '-' ? "withdrawal" : 'deposited',
                'type'          => $trx_type == '-' ? 'debit' : 'credit',
                'status'        => Status::Pending
            ]);
            
            $payment = $gateway->payments()->create([
                'user_id'           => auth()->user()->id,
                'transaction_id'    => $transation->id,
                'type'              => $trx_type == '-' ? 'debit' : 'credit',
                'parameters'        => $request->parameters,
                'deposit_type'      => $trx_type == '-' ? 'default' : $depositType ,
                'plan_id'           => $request->committee_id,
            ]);

            $payment->load(['transaction', 'gateway']);
            auth()->user()->notify(new PaymentNotification($payment));
            DB::commit();
            return $payment;
        } catch(Exception $e){
            DB::rollBack(); 
            return response()->json([
                'status'   => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message'  => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
