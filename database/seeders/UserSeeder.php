<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "User",
            'email' => 'user@aamclick.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'country_code'   => '0300',
            'mobile'   => '8090100',
            'status'   => 'active',
            'uuid'     => 'AAM100000'
        ]);

        User::factory(50)->create();

        $users = User::all();
        foreach($users as $user){
            $balance = 1000;
            $user->load('planUser');
            $month = 1;
            $totalRecords = 10;
            for ($i = 0; $i < $totalRecords; $i++){

                $amount = mt_rand(10, 100);
                $type = Arr::random(['credit', 'debit']);
                $balance = $type == 'credit' ? $balance + $amount : $balance - $amount ;
        
                if($month > 12){
                    $month = 1;
                }

                $randomNum = mt_rand(strtotime('2022-' . $month .'-1'), strtotime('2023-1-1'));
                $date = date("Y-m-d", $randomNum);
    
                $user->transactions()->create([
                    'amount'        => $amount,
                    'post_balance'  => $balance,
                    'remark'        => $type == 'credit' ? 'Money Deposited' : 'Money Withdarawned',
                    'trx'           => getTrx(),
                    'trx_type'      => $type == 'credit' ? '+' : '-',
                    'type'          => $type,
                    'created_at'    => $date,
                    'updated_at'    => $date
                ]);
    
                $user->planUser()->update([
                    'balance'    => $balance
                ]);

                // if($totalRecords/12 == $user->id){
                    $month++;
                // }
            }
        }
    }
}
