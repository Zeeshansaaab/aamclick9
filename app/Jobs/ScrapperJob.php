<?php

namespace App\Jobs;

use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Enums\Status;
use App\Models\Gateway;
use App\Models\LoginLog;
use App\Models\PlanLevel;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ScrapperJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;

    protected $totalRecords = 1473;
    protected $limit = 50;
    protected $page = 1;
    protected $totalPages = 1;
    protected $URL = 'http://127.0.0.1:8000/api/users'; //http://127.0.0.1/api/users

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
        // Artisan::call('migrate:fresh --seed');
        while ($this->totalPages >= $this->page) {
            $response = Http::withHeaders([
                // 'Authorization' => 'Bearer 3e28d3d0-bed4-450b-bb38-9c4f2f6415dd'
            ])->get('http://127.0.0.1:8000/api/users', [
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
                    $this->loginLogs($responseUser->login_logs, $user);
                    $this->deposits($responseUser->deposits, $user);
                    $this->withdrawals($responseUser->withdrawals, $user);
                    $this->createTransaction($responseUser->transactions, $user);
                    $this->commissions($responseUser->commissions, $user);
                    $this->profitTracker($responseUser->profit_trackers, $user);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::error($e);
                }
            }
            $this->page++;
        }
        
        $users[] = User::updateOrCreate(['email'             =>'Sidhushamoon@gmail.com'],[
            'uuid'              => "AAM00001",
            'name'              => 'Shamoon Sidhu',
            'country_code'      => '92',
            'mobile'            => '3024457478',
            'address'           => [
                "address" => "Bhamba kilan Teh-Kot Ratha Kishan Kasur",
                "state" => "Punjab",
                "zip"=>"55000",
                "country"=>"Afghanistan",
                "city"=>"Kabul"],
            'sv'                => 1,
            'email_verified_at' => '2022-05-23 04:19:24',
            'password'          => 'Xg4l249g51dPYTJEnXz5sCIppdpBtikbvwIR4Fg2mM6KwNCp2E6gNevzezpG',
            'status'            => Status::Active,
            'created_at'        => '2022-05-23 04:19:24',
            'updated_at'        => '2023-02-25 19:44:29',
        ]);

        $users [] = User::where('email', 'user@aamclick.com')->first();
        $gateway = Gateway::where('type',  'deposit')->first();
        foreach($users as $user){

            $transaction = $user->transactions()->create([
                'amount'        => 2500,
                'charge'        => 0,
                'post_balance'  => ($user->transactions()->where('remark', 'deposited')->sum('amount') + 200),
                'trx_type'      => '+',
                'trx'           =>  getTrx(),
                'details'       => "Amount deposited via " . $gateway->name,
                'remark'        => "deposited",
                'type'          => 'debit',
                'status'        => Status::Active,
            ]);

            $user->payments()->create([
                'gateway_id'        => $gateway->id,
                'transaction_id'    => $transaction->id,
                'type'              => 'debit',
                'parameters'        => [],
                'deposit_type'      => 'default',  //$trx_type == '-' ? 'default' : $depositType ,
            ]);
        }
    }

    private function createUser($responseUser){
        $ref = $responseUser->ref_by;
        if($ref){
            $ref = User::whereUuid($ref->aam_id)->first();
        }
        $user = User::withoutEvents(function () use ($responseUser, $ref) {
                return User::create([
                    'uuid'              => $responseUser->aam_id,
                    'ref_by'            => $ref ? $ref->id : null,
                    'name'              => $responseUser->firstname . ' ' . $responseUser->lastname,
                    'email'             => $responseUser->email == 'Sidhushamoon@gmail.com' ? 'user@aamclick.com' : $responseUser->email,
                    'country_code'      => substr($responseUser->mobile, 0, 4),
                    'mobile'            => substr($responseUser->mobile, 4, 7),
                    'address'           => $responseUser->address,
                    'status'            => $responseUser->status == 1 ? 'active' : 'inactive',
                    'sv'                => $responseUser->sv,
                    'email_verified_at' => $responseUser->created_at,
                    'ban_reason'        => $responseUser->ban_reason,
                    'password'          => $responseUser->email == 'Sidhushamoon@gmail.com' ? Hash::make('12345678') : $responseUser->password,
                    'status'            => $responseUser->status == 1 ? Status::Active : Status::InActive,
                    'created_at'        => $responseUser->created_at,
                    'updated_at'        => $responseUser->updated_at,
                ]);
        });
        $plan = $this->createPlan($responseUser->plan);
        if(count($responseUser->committee_members) > 0){
            $this->createCommitteePlan($responseUser->committee_members, $user);

        }

        $user->planUser()->create([
            'plan_id' =>            $plan->id,
            'daily_limit' =>        $responseUser->daily_limit,
            
            'referral_income'    => $responseUser->profit_bonus,
            'balance'            => $responseUser->balance, //deposit
            'profit_bonus'       => $responseUser->user_profit_bonus, 
            'referral_deposit'   => $responseUser->deposit_commission,

            'last_withdraw' =>      $responseUser->last_withdraw,
            'expire_date' => $responseUser->expire_date,
            'created_at' => $responseUser->created_at,
            'updated_at' => $responseUser->updated_at,
        ]);

        $user = $user->load('planUser');

        return $user;
    }

    private function loginLogs($loginLogs, $user){
        
        foreach($loginLogs as $loginLog){
            $user->loginLogs()->create([
                'ip'            => $loginLog->user_ip,
                'city'          => $loginLog->city,
                'country'       => $loginLog->country,
                'country_code'  => $loginLog->country_code,
                'longitude'     => $loginLog->longitude,
                'latitude'      => $loginLog->latitude,
                'browser'       => $loginLog->browser,
                'os'            => $loginLog->os,
                'created_at'    => $loginLog->created_at,
                'updated_at'    => $loginLog->updated_at,
            ]);
        }
    }

    private function createPlan($plan){
        $dbPlan = Plan::updateOrCreate(['name' => $plan->name], [
            'min_price' => $plan->min_price,
            'max_price' => $plan->max_price,
            'amount_return' => $plan->amount_return,
            'min_profit_percent' => $plan->min_profit_percent,
            'max_profit_percent' => $plan->max_profit_percent,
            'profit_bonus_percent' => $plan->profit_bonus_percent,
            'validity' => $plan->validity,
            'status' => $plan->status == 1 ? 'active' : 'inactive',
            'created_at' => $plan->created_at,
            'updated_at' => $plan->updated_at,
        ]);
        $this->planLevel($plan->referrlas, $dbPlan); 
        return $dbPlan;
    }

    private function planLevel($levels, $plan){
        foreach($levels as $level){
            $level->percent > 0 ? PlanLevel::updateOrCreate(['plan_id' => $plan->id, 'type'=> $level->commission_type,'level'      => $level->level,], [
                'percentage' => $level->percent,
                'status'     => $level->status == 0 ? Status::InActive : Status::Active,
                'created_at' => $level->created_at,
                'updated_at' => $level->updated_at,
            ]): null;
        }
    }
    private function createCommitteePlan($committee_members, $user){
        foreach ($committee_members as $committee_member) {
            $committee = $committee_member->committee;
            $parentCommittee = Plan::updateOrCreate(['name' => $committee->committee_plan->name], [
                'price' => $committee->committee_plan->amount,
                'type' => 'committee',
                'status' => $committee->committee_plan->status == 1 ? 'active' : 'inactive',
                'created_at' => $committee->committee_plan->created_at,
                'updated_at' => $committee->committee_plan->updated_at,
            ]);
            $committee = Plan::updateOrCreate(['name' => $committee->name, 'parent_id' => $parentCommittee->id], [
                'price'         => $committee->amount,
                'validity'      => $committee->validity,
                'total_members' => $committee->validity,
                'amount_return' => $committee->amount_return,
                'starting_date' => $committee->committee_open_time,
                'type'          => 'committee',
                'status'        => $committee->status == 1 ? 'active' : 'inactive',
                'created_at'    => $committee->created_at,
                'updated_at'    => $committee->updated_at,
            ]);
            $user->committees()->create([
                'plan_id'   => $committee->id,
                'committee_number' => $committee_member->committee_number,
                'status'           => $committee_member->status,
                'created_at'       => $committee_member->created_at,
                'updated_at'       => $committee_member->updated_at,
            ]);
        }
    }

    private function createTransaction($transactions, $user){
        foreach ($transactions as $transaction) {
            Transaction::create([
                'user_id' => $user->id,
                'amount' => $transaction->amount,
                'charge' => $transaction->charge,
                'post_balance' => $user->transactions()->where('remark', $transaction->remark)->sum('amount') + $transaction->amount,
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

    private function withdrawals($withdrawals, $user){
        foreach($withdrawals as $withdrawal)
            if($withdrawal->method && $withdrawal->amount > 0){
                $gateway = Gateway::updateOrCreate(['name' => $withdrawal->method->name, 'type' => 'withdrawal'],[
                    'min_amount' => $withdrawal->method->min_limit,
                    'max_amount' => $withdrawal->method->max_limit,
                    'fixed_charge' => $withdrawal->method->fixed_charge,
                    'percentage_charge' => $withdrawal->method->percent_charge,
                    'currency' => $withdrawal->method->currency,
                    'currency_value' => $withdrawal->method->rate,
                    'gateway_parameters' => $withdrawal->method->form->form_data,
                    'type'               => 'withdrawal',
                    'description'        => $withdrawal->method->description,
                    'status'             => $withdrawal->method->status == 1 ? 'active' : 'inactive',
                    'created_at'         => $withdrawal->method->created_at,
                    'updated_at'         => $withdrawal->method->updated_at
                ]);
                $transaction = $user->transactions()->orderBy('id', 'desc')->first();
                $transaction = $user->transactions()->create([
                    'amount'        => $withdrawal->amount,
                    'charge'        => $withdrawal->charge,
                    'post_balance'  => $transaction ? ($user->transactions()->where('remark', 'withdrawal')->sum('amount') + $withdrawal->amount) : 0,
                    'trx_type'      => '-',
                    'trx'           => $withdrawal->trx,
                    'details'       => "Amount withdrawal via " . $gateway->name,
                    'remark'        => $withdrawal->type  == 'profit_bonus' ? 'referral_income' : ($withdrawal->type == 'user_profit_bonus' ? 'profit_bonus' : $withdrawal->type),
                    'type'          => 'debit',
                    'status'        => $withdrawal->status == 1 ? Status::Active : ($withdrawal->status == 0 ? Status::Pending : Status::InActive),
                    'created_at'    => $withdrawal->created_at,
                    'updated_at'    => $withdrawal->updated_at
                ]);

                $user->payments()->create([
                    'gateway_id'        => $gateway->id,
                    'transaction_id'    => $transaction->id,
                    'type'              => 'debit',
                    'parameters'        => $withdrawal->withdraw_information,
                    'deposit_type'      => $withdrawal->type  == 'profit_bonus' ? 'referral_income' : ($withdrawal->type == 'user_profit_bonus' ? 'profit_bonus' : $withdrawal->type),  //$trx_type == '-' ? 'default' : $depositType ,
                    'created_at'        => $withdrawal->created_at,
                    'updated_at'        => $withdrawal->updated_at
                ]);
            }
    }

    private function deposits($deposits, $user){
        foreach($deposits as $deposit){
            if($deposit->gateway && $deposit->final_amo > 0){
                $gateway = Gateway::updateOrCreate(['name' => $deposit->gateway->name, 'type' => 'deposit'],[
                    'min_amount' => 10,
                    'max_amount' => 100,
                    'image'      => $deposit->gateway->image,
                    'crypto'     => $deposit->gateway->crypto,
                    'extra'      => $deposit->gateway->extra,
                    'currency' => $deposit->method_currency,
                    'currency_value' => $deposit->rate,
                    'gateway_parameters' => $deposit->gateway->gateway_parameters,
                    'type'               => 'deposit',
                    'description'        => $deposit->gateway->description,
                    'status'             => $deposit->gateway->status ? 'active' : 'inactive',
                    'created_at'         => $deposit->gateway->created_at,
                    'updated_at'         => $deposit->gateway->updated_at
                ]);

                $transaction = $user->transactions()->create([
                    'amount'        => $deposit->final_amo,
                    'charge'        => $deposit->charge,
                    'post_balance'  => ($user->transactions()->where('remark', 'deposited')->sum('amount') + $deposit->final_amo),
                    'trx_type'      => '+',
                    'trx'           =>  $deposit->trx,
                    'details'       => "Amount deposited via " . $gateway->name,
                    'remark'        => "deposited",
                    'type'          => 'credit',
                    'status'        => $deposit->status == 1 ? Status::Active : ($deposit->status == 0 ? Status::Pending : Status::InActive),
                    'created_at'    => $deposit->created_at,
                    'updated_at'    => $deposit->updated_at
                ]);

                $user->payments()->create([
                    'gateway_id'        => $gateway->id,
                    'transaction_id'    => $transaction->id,
                    'type'              => 'debit',
                    'parameters'        => $deposit->detail,
                    'deposit_type'      => 'default',  //$trx_type == '-' ? 'default' : $depositType ,
                    'created_at'    => $deposit->created_at,
                    'updated_at'    => $deposit->updated_at
                ]);
            }
        }
    }

    private function commissions($commissions, $user){
        try{
            Schema::disableForeignKeyConstraints();
            foreach($commissions as $commission){
                $to   = User::whereUuid($commission->user_to->aam_id)->first();

                $transaction = $to->transactions()->create([
                    'amount'        => $commission->amount,
                    'charge'        => 0,
                    'trx_type'      => '+',
                    'post_balance'  => $to->transactions()->where('remark', $commission->type)->sum('amount') + $commission->amount,
                    'trx'           => getTrx(),
                    'details'       => $commission->details,
                    'remark'        => $commission->type == 'profit_bonus' ? 'referral_income' : $commission->type,
                    'type'          => 'credit',
                    'status'        => Status::Active,
                    'created_at'    => $commission->created_at,
                    'updated_at'    => $commission->updated_at
                ]);
                $commission = $to->commissions()->create([
                    'from_id'   => Str::replace('AAM0', '', $commission->user_from->aam_id),
                    'level'     => $commission->level,
                    'transaction_id' => $transaction->id,
                    'created_at'    => $commission->created_at,
                ]);
            }
            Schema::enableForeignKeyConstraints();
        } catch(Exception $e){
            DB::rollBack();
        }
    }
    private function profitTracker($profitTrackers, $user){
        try{
            Schema::disableForeignKeyConstraints();
            foreach($profitTrackers as $profitTracker){
                $user->transactions()->create([
                    'amount'        => $profitTracker->amount,
                    'charge'        => 0,
                    'trx_type'      => '+',
                    'post_balance'  => $user->transactions()->where('remark', 'profit_bonus')->sum('amount') + $profitTracker->amount,
                    'trx'           => getTrx(),
                    'details'       => "% profit bonus added",
                    'remark'        => 'profit_bonus',
                    'type'          => 'credit',
                    'status'        => Status::Active,
                    'created_at'    => $profitTracker->created_at,
                    'updated_at'    => $profitTracker->updated_at
                ]);
            }
            Schema::enableForeignKeyConstraints();
        } catch(Exception $e){
            DB::rollBack();
        }
    }
}