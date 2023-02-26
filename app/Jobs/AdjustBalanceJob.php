<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use App\Enums\Status;
use App\Models\Gateway;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AdjustBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        try{
            DB::beginTransaction();
            
            foreach(User::with('planUser')->get() as $user){
                Log::info($user->uuid);
                if($user->planUser->balance != $user->depositAmount()){
                    // $user->transactions()->where([
                    //     'details' => 'Update Adjustment',
                    //     'referral_income' => 'deposited'
                    // ])->delete();
                    $amount = $user->planUser->balance - $user->depositAmount();
                    $gateway = $amount > 0 ? Gateway::deposit()->first() : Gateway::withdrawal()->first();
                    $transaction = $user->transactions()->create([
                        'amount'        =>  $amount < 0 ? (-1 * $amount) : $amount,
                        'charge'        => 0,
                        'post_balance'  => ($user->depositAmount() + $amount),
                        'trx_type'      => $amount > 0 ? '+' : '-',
                        'trx'           =>  getTrx(),
                        'details'       => "Update Adjustment",
                        'remark'        => $amount > 0 ? 'deposited' : 'withdrawal',
                        'type'          => $amount > 0 ? 'credit' : 'debit',
                        'status'        => Status::Active,
                    ]);

                    $user->payments()->create([
                        'gateway_id'        => $gateway->id,
                        'transaction_id'    => $transaction->id,
                        'type'              => $amount > 0 ? 'credit' : 'debit',
                        'parameters'        => [],
                        'deposit_type'      => 'default',  //$trx_type == '-' ? 'default' : $depositType
                    ]);
                }
                if($user->planUser->referral_income != $user->referralIncome()){
                    // $user->transactions()->where([
                    //     'details' => 'Update Adjustment',
                    //     'referral_income' => 'referral_income'
                    // ])->delete();
                    $amount = $user->planUser->referral_income - $user->referralIncome();
                    // $amount = $amount < 0 ? (-1 * $amount) : $amount;
                    $transaction = $user->transactions()->create([
                        'amount'        => $amount < 0 ? (-1 * $amount) : $amount,
                        'charge'        => 0,
                        'trx_type'      => $amount > 0 ? '+' : '-',
                        'post_balance'  => $user->referralIncome() + $amount,
                        'trx'           => getTrx(),
                        'details'       => "Update Adjustment",
                        'remark'        => 'referral_income',
                        'type'          => $amount > 0 ? 'credit' : 'debit',
                        'status'        => Status::Active,
                    ]);

                    $user->commissions()->create([
                        'from_id'   => 1,
                        'level'     => 1,
                        'transaction_id' => $transaction->id,
                    ]);
                }
                if($user->planUser->profit_bonus != $user->profitBonus()){
                    $amount = $user->planUser->profit_bonus - $user->profitBonus();
                    // $user->transactions()->where([
                    //     'details' => 'Update Adjustment',
                    //     'referral_income' => 'profit_bonus'
                    // ])->delete();
                    $user->transactions()->create([
                        'amount'        =>  $amount < 0 ? (-1 * $amount) : $amount,
                        'charge'        => 0,
                        'trx_type'      => $amount > 0 ? '+' : '-',
                        'post_balance'  => $user->profitBonus() + $amount,
                        'trx'           => getTrx(),
                        'details'       => "Update Adjustment",
                        'remark'        => 'profit_bonus',
                        'type'          => $amount > 0 ? 'credit' : 'debit',
                        'status'        => Status::Active,
                    ]);
                }
                if($user->planUser->referral_deposit != $user->depositCommission()){
                    $amount = $user->planUser->referral_deposit - $user->depositCommission();
                    // $user->transactions()->where([
                    //     'details' => 'Update Adjustment',
                    //     'referral_income' => 'deposit_commission'
                    // ])->delete();
                    $user->transactions()->create([
                        'amount'        =>  $amount < 0 ? (-1 * $amount) : $amount,
                        'charge'        => 0,
                        'trx_type'      => $amount > 0 ? '+' : '-',
                        'post_balance'  => $user->depositCommission() + $amount,
                        'trx'           => getTrx(),
                        'details'       => "Update Adjustment",
                        'remark'        => 'deposit_commission',
                        'type'          => $amount > 0 ? 'credit' : 'debit',
                        'status'        => Status::Active,
                    ]);
                }
            }
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }
    }
}
