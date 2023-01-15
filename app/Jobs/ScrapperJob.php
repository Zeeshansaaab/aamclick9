<?php

namespace App\Jobs;

use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Enums\Status;
use App\Models\LoginLog;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ScrapperJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;

    protected $totalRecords = 1;
    protected $limit = 1;
    protected $page = 1;
    protected $totalPages = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::alert("Scraper running");
        while ($this->totalPages >= $this->page) {
            $response = Http::withHeaders([
                // 'Authorization' => 'Bearer 3e28d3d0-bed4-450b-bb38-9c4f2f6415dd'
            ])->get('https://aamclick.com/api/users', [
                'limit' => $this->limit,
                'page' => $this->page
            ]);
            Log::info("Page # " . $this->page);
            $this->totalRecords = $response->object()->total;
            $this->totalPages = ceil($this->totalRecords / $this->limit);
            
            foreach ($response->object()->data as $responseUser) {
                try {
                    DB::beginTransaction();
                    $user = $this->createUser($responseUser);
                    $this->createTransaction($responseUser->transactions);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::error($e);
                }
            }
            $this->page++;

        }
    }

    private function createUser($responseUser){
        $ref = User::find($responseUser->ref_by);
        $user = User::create([
            'id'   => $responseUser->id,
            'uuid' => $responseUser->aam_id,
            'ref_by' => $ref ? $ref->id : 1,
            'name' => $responseUser->firstname . ' ' . $responseUser->lastname,
            'email' => $responseUser->email == 'Sidhushamoon@gmail.com' ? 'user@aamclick.com' : $responseUser->email,
            'country_code' => substr($responseUser->mobile, 0, 4),
            'mobile' => substr($responseUser->mobile, 4, 7),
            'address' => json_encode($responseUser->address),
            'status' => $responseUser->status == 1 ? 'active' : 'inactive',
            'sv' => $responseUser->sv,
            'email_verified_at' => $responseUser->created_at,
            'ban_reason' => $responseUser->ban_reason,
            'password' => $responseUser->email == 'Sidhushamoon@gmail.com' ? Hash::make('12345678') : $responseUser->password,
            'created_at' => $responseUser->created_at,
            'updated_at' => $responseUser->updated_at,
        ]);

        $plan = $this->createPlan($responseUser->plan);
        count($responseUser->committee_member) > 0 ? $this->createCommitteePlan($responseUser->committee_member) : null;

        $user->planUser()->create([
            'plan_id' => $plan->id,
            'daily_limit' => $responseUser->daily_limit,
            'balance' => $responseUser->balance,
            'referral_income' => $responseUser->profit_bonus,
            'profit_bonus' => $responseUser->profit_bonus,
            'referral_deposit' => $responseUser->deposit_commission,
            'last_withdraw' => $responseUser->last_withdraw,
            'expire_date' => $responseUser->expire_date
        ]);

        // LoginLog::insert($responseUser->login_logs);

        $user = $user->load('planUser');

        return $user;
    }

    private function createPlan($plan){
        return Plan::updateOrCreate(['name' => $plan->name], [
            'min_price' => $plan->min_price,
            'max_price' => $plan->max_price,
            'amount_return' => $plan->amount_return,
            'min_profit_percent' => $plan->min_profit_percent,
            'max_profit_percent' => $plan->max_profit_percent,
            'profit_bonus_percent' => $plan->profit_bonus_percent,
            'validity' => $plan->validity,
            'status' => $plan->status == 1 ? 'active' : 'inactive',
        ]);
    }
    private function createCommitteePlan($plans){
        foreach ($plans as $plan) {
            $plan = $plan->committee;
            Plan::updateOrCreate(['name' => $plan->name], [
                'price' => $plan->amount,
                'amount_return' => $plan->amount_return,
                'validity' => $plan->validity,
                'type' => 'committee',
                'status' => $plan->status == 1 ? 'active' : 'inactive',
            ]);
        }
    }

    private function createTransaction($transactions){
        foreach ($transactions as $transaction) {
            Transaction::create([
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                'charge' => $transaction->charge,
                'post_balance' => $transaction->post_balance,
                'trx_type' => $transaction->trx_type,
                'trx' => $transaction->trx,
                'details' => $transaction->details,
                'remark' => $transaction->remark,
                'type' => $transaction->remark == 'withdraw' ? 'debit' : 'credit',
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ]);
        }
    }
}