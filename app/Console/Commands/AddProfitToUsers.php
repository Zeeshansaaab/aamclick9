<?php

namespace App\Console\Commands;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\NotificationManager;

class AddProfitToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will add profit to users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = Setting::whereIn('key', ['profit_bonus', 'profit_bonus_percentage', 'profit_bonus_days'])->get();
        $isProfitBonusEnalbed = (bool)$settings->where('key', 'profit_bonus')->first()->value;
        $count = 0;
        if($isProfitBonusEnalbed){
            $profitBonusDays = $settings->where('key', 'profit_bonus_days')->first()->value;
            $profitBonusPercentage = $settings->where('key', 'profit_bonus_percentage')->first()->value;
            $users = User::with(['planUser.plan.levels', 'refBy.planUser.plan'])
            ->where('status', Status::Active)
            ->whereHas('planUser', function($query) use($profitBonusDays){
                $query->whereDate('last_withdraw', '<=', Carbon::now()->subDays($profitBonusDays));
                $query->where('balance', '>', 0);
            })
            ->get();
            $count = $users->count();
            foreach($users as $user)
            {
                try{
                    DB::beginTransaction();
                    $amount = ($user->planUser->balance * $profitBonusPercentage) / 100;
                    $user->planUser->profit_bonus += $amount;
                    $user->planUser->last_withdraw = Carbon::now();
                    $user->planUser->save();

                    $user->transactions()->create([
                        'amount'        => $amount,
                        'charge'        => 0,
                        'trx_type'      => '+',
                        'trx'           => getTrx(),
                        'post_balance'  => $user->planUser->profit_bonus,
                        'details'       => $profitBonusPercentage . "% profit bonus added",
                        'remark'        => 'profit_bonus',
                        'type'          => 'credit',
                        'status'        => Status::Active
                    ]);
                    $user->notify(new NotificationManager([
                        'title'         => 'PROFIT BONUS',
                        'description'   => currency($amount) .  " amount is added",
                        'redirect_url'  => route('reports.commissions')
                    ]));

                    levelCommission($user,  $amount , 'profit_bonus');
                    DB::commit();
                } catch(Exception $e){
                    DB::rollBack();
                    Log::info($e->getMessage());
                    Log::info($e->getTrace());
                    return Command::FAILURE;
                }
            }
        }
        //Send this notification to admin
        Log::info($count . ' Users Profit bonus is added');
        return Command::SUCCESS;
    }
}
