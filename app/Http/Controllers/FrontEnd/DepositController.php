<?php

namespace App\Http\Controllers\FrontEnd;

use Exception;
use App\Enums\Status;
use App\Models\Gateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Notifications\PaymentNotification;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller
{
    public function index()
    {
        $gateways = Gateway::deposit()->get();
        return view('frontend.deposit.index', compact('gateways'));
    }

    public function depositConfirmation(DepositRequest $request)
    {
        $gateway = Gateway::find(request()->method_id);
        $amount = $request->amount;
        Session::put('deposit-amount', $amount);
        return Blade::render('<x-deposit-confirm :amount="$amount" :gateway="$gateway"/>', ['amount' => $amount, 'gateway' => $gateway]);
    }

    public function depositConfirmed(Request $request)
    {
        try{
            $request->validate([
                'method_id' => 'required'
            ]);

            DB::beginTransaction();
            $amount = Session::get('deposit-amount');

            $gateway = Gateway::findOrFail($request->method_id);
            $charge = $gateway->fixed_charge + ($amount  * $gateway->percentage_charge / 100);

            $transation = auth()->user()->transactions()->create([
                'amount'        => $amount,
                'charge'        => $charge,
                'trx_type'      => '+',
                'trx'           => getTrx(),
                'details'       => "Amount deposited via " . $gateway->name,
                'remark'        => 'Amount Deposited',
                'type'          => 'credit',
                'status'        => Status::Pending
            ]);
            $payment = $gateway->payments()->create([
                'user_id'           => auth()->user()->id,
                'transaction_id'    => $transation->id,
                'type'              => 'credit',
                'parameters'        =>  $request->parameters
            ]);

            $payment->load(['transaction', 'gateway']);
            auth()->user()->notify(new PaymentNotification($payment));

            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            dd($e);
        }
    }

}
