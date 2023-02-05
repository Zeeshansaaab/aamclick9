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

    protected $totalRecords = 1375;
    protected $limit = 1;
    protected $page = 1;
    protected $totalPages = 1;
    protected $URL = 'https://aamclick.com/api/users'; //http://127.0.0.1/api/users

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
            ])->get($this->URL, [
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
                    DB::commit();
                    DB::beginTransaction();
                    $this->loginLogs($responseUser->login_logs, $user);
                    DB::commit();
                    DB::beginTransaction();
                    $this->deposits($responseUser->deposits, $user);
                    DB::commit();
                    DB::beginTransaction();
                    $this->withdrawals($responseUser->withdrawals, $user);
                    DB::commit();
                    DB::beginTransaction();
                    $this->createTransaction($responseUser->transactions, $user);
                    DB::commit();
                    DB::beginTransaction();
                    $this->commissions($responseUser->commissions, $user);
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
        $ref = $responseUser->ref_by;
        if($ref){
            $ref = User::whereUuid($ref->aam_id)->first();
        }
        $user = User::withoutEvents(function () use ($responseUser, $ref) {
                return User::create([
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
        });
        $plan = $this->createPlan($responseUser->plan);
        if(count($responseUser->committee_members) > 0){
            $this->createCommitteePlan($responseUser->committee_members, $user);

        }

        $user->planUser()->create([
            'plan_id' =>            $plan->id,
            'daily_limit' =>        $responseUser->daily_limit,
            'balance' =>            $responseUser->balance,
            'referral_income' =>    $responseUser->profit_bonus,
            'profit_bonus' =>       $responseUser->user_profit_bonus,
            'referral_deposit' =>   $responseUser->deposit_commission,
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

    private function withdrawals($withdrawals, $user){
        foreach($withdrawals as $withdrawal)
            if($withdrawal->method){
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
                    'post_balance'  => $transaction ? ($transaction->post_balance - $withdrawal->amount) : 0,
                    'trx_type'      => '-',
                    'trx'           => $withdrawal->trx,
                    'details'       => "Amount withdrawal via " . $gateway->name,
                    'remark'        => "withdrawal",
                    'type'          =>'debit',
                    'status'        => $withdrawal->status == 1 ? Status::Active : ($withdrawal->status == 0 ? Status::Pending : Status::InActive),
                    'created_at'    => $withdrawal->created_at,
                    'updated_at'    => $withdrawal->updated_at
                ]);

                $user->payments()->create([
                    'gateway_id'        => $gateway->id,
                    'transaction_id'    => $transaction->id,
                    'type'              => 'debit',
                    'parameters'        => $withdrawal->withdraw_information,
                    'deposit_type'      => 'default',  //$trx_type == '-' ? 'default' : $depositType ,
                    'created_at'    => $withdrawal->created_at,
                    'updated_at'    => $withdrawal->updated_at
                ]);
            }
    }

    private function deposits($deposits, $user){
        foreach($deposits as $deposit){
            if($deposit->gateway){
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
                $transaction = $user->transactions()->orderBy('id', 'desc')->first();

                $transaction = $user->transactions()->create([
                    'amount'        => $deposit->final_amo,
                    'charge'        => $deposit->charge,
                    'post_balance'  => $transaction ? ($transaction->post_balance + $deposit->final_amo) : 0,
                    'trx_type'      => '+',
                    'trx'           =>  $deposit->trx,
                    'details'       => "Amount deposited via " . $gateway->name,
                    'remark'        => "deposited",
                    'type'          => 'debit',
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
                    DB::beginTransaction();
                    $to   = User::whereUuid($commission->user_to->aam_id)->first();
                    $transaction = $to->transactions()->orderBy('id', 'desc')->first();

                    $transaction = $to->transactions()->create([
                        'amount'        => $commission->amount,
                        'charge'        => 0,
                        'trx_type'      => '+',
                        'post_balance'  => $transaction->post_balance + $commission->amount,
                        'trx'           => getTrx(),
                        'details'       => $commission->details,
                        'remark'        => $commission->type,
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
                    DB::commit();
                }
                Schema::enableForeignKeyConstraints();
            // }
        } catch(Exception $e){
            DB::rollBack();
        }
    }
}