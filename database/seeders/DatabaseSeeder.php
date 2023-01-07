<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        $this->call([
            SettingSeeder::class,
            PlanSeeder::class,
        ]);

        
        
        $user = User::create([
            'name' => "User",
            'email' => 'user@aamclick.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'country_code'   => '0300',
            'mobile'   => '8090100',
            'status'   => 'active',
        ]);

        $user->load('planUser');
        $balance = $user->planUser->balance;
        for ($i = 0; $i < 2000; $i++){
            $amount = mt_rand(10, 100);
            $balance += $amount;
            $type = Arr::random(['credit', 'debit']);
            
            $randomNum = mt_rand(strtotime('2022-1-1'), strtotime('2023-1-1'));
            $date = date("Y-m-d", $randomNum);

            $user->transactions()->create([
                'amount'        => $amount,
                'post_balance'  => $balance,
                'remark'        => $type == 'credit' ? 'Money Deposited' : 'Money Withdarawned',
                'trx'           => getTrx(),
                'trx_type'      => $type == 'credit' ? '+' : '-',
                'post_balance'  => $balance,
                'type'          => $type,
                'created_at'    => $date,
                'updated_at'    => $date
            ]);

            $user->planUser()->update([
                'balance'    => $balance
            ]);
        }

        User::factory(1000)->create();
    }
}
