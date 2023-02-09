<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard', [
            'last_login'         => auth()->user()->loginLogs()->latest()->first()->created_at
        ]);
    }

    public function charts()
    {
        $year = Carbon::now()->year;
        $users = auth()->user()->referrals()->select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        // ->whereYear('created_at', date('Y'))
        ->whereYear('created_at', $year)
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('count', 'month_name');
        
        $transactions = auth()->user()->transactions()
        ->select([ 
            DB::raw("SUM(amount) as amount"), 
            DB::raw("MONTHNAME(created_at) as month_name"),
        ])->whereYear('created_at', $year)
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('amount', 'month_name');

        $transactionsLabels = $transactions->keys()->toArray();
        $transactionsData = $transactions->values()->toArray();
        $referralUsersLabels = $users->keys()->toArray();
        $referralUsersdData = $users->values()->toArray();

        return response()->json([
            'status'    => JsonResponse::HTTP_OK,
            'data'      => [
                'transactionsLabels' => $transactionsLabels,
                'transactionsData'   => $transactionsData,
                'referralUsersLabels'=> $referralUsersLabels,
                'referralUsersData'  => $referralUsersdData,
            ]
        ], JsonResponse::HTTP_OK);

    }
}
