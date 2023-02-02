<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallmentRequest;
use App\Models\Installment;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.installment.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstallmentRequest $request)
    {
        try{
            DB::beginTransaction();
            $committees = auth()->user()->committees()->whereHas('plan.payments', function ($query) {
                $query->select(DB::raw('count(*) as total_installments'));
                $query->where('plans.total_members', '>', 'total_installments');
            })->withSum('plan','price')->pluck('plan_sum_price');
            //getting 60 percent of the balance
            $totalBalanceForInstallments = (auth()->user()->planUser->balance - $committees->sum()) * 0.6;
            if($totalBalanceForInstallments < $request->amount){
                return response()->json([
                    'status' => JsonResponse::HTTP_OK,
                    'message' => "Your balance is not enough for installments"
                ], JsonResponse::HTTP_OK);
            }
            auth()->user()->installments()->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'amount' => $request->amount,
                'image' => uploadImage($request->image, 'installments/'),
            ]);
            DB::commit();
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => "Applied for installment"
            ], JsonResponse::HTTP_OK);
        } catch(Exception $e){
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstallmentRequest $request, $id)
    {
        // try{
        //     DB::beginTransaction();
        //     $committees = auth()->user()->committees()->whereHas('plan.payments', function ($query) {
        //         $query->select(DB::raw('count(*) as total_installments'));
        //         $query->where('plans.total_members', '>', 'total_installments');
        //     })->withSum('plan','price')->pluck('plan_sum_price');
        //     //getting 60 percent of the balance
        //     $totalBalanceForInstallments = (auth()->user()->planUser->balance - $committees->sum()) * 0.6;
        //     if($totalBalanceForInstallments < $request->amount){
        //         return response()->json([
        //             'status' => JsonResponse::HTTP_OK,
        //             'message' => "Your balance is not enough for installments"
        //         ], JsonResponse::HTTP_OK);
        //     }
        //     auth()->user()->installments()->create([
        //         'name' => $request->name,
        //         'phone' => $request->phone,
        //         'email' => $request->email,
        //         'address' => $request->address,
        //         'amount' => $request->amount,
        //         'image' => uploadImage($request->image, 'installments/'),
        //     ]);
        //     DB::commit();
        //     return response()->json([
        //         'status' => JsonResponse::HTTP_OK,
        //         'message' => "Applied for installment"
        //     ], JsonResponse::HTTP_OK);
        // } catch(Exception $e){
        //     return response()->json([
        //         'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
        //         'message' => $e->getMessage()
        //     ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
