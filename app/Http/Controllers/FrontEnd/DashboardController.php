<?php

namespace App\Http\Controllers\FrontEnd;

use App\Enums\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['planUser.plan', 'referrals']);
        $transactions = auth()->user()->transactions()->where('remark', 'profit_bonus')->orderByDesc('id')->limit(4)->get();

        $rewardPlan = Cache::remember('reward_plan', 3600 *24, function (){
            return Plan::reward()->first();
        });

        return view('frontend.dashboard', [
            'last_login'            => auth()->user()->loginLogs()->latest()->first()->updated_at,
            'user'                  => $user,
            'transactions'          => $transactions,
            'rewardPlan'            => $rewardPlan,
            'rewardBonus'           => auth()->user()->rewardBalance()
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

    public function claimReward(Request $request){
        $plan = Plan::reward()->first();
        $request->validate([
            'amount' => 'numeric|min:' . $plan->price
        ]);
        try{
            DB::beginTransaction();
            createTransaction(auth()->user(), $request->amount, "Reward amount debitted", "reward", route('reports.transactions', ['reward=1&remark=reward']),"debit");
            DB::commit();
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Reward Calimed',
            ], JsonResponse::HTTP_OK);
        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
