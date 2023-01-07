<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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

        
        User::factory(10)->create();

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

        $user->transactions()->create([
            'amount' => 10,
            'post_balance' => 10,
            'remark' => 'Deposit Money',
        ]);

        $user->planUser()->update([
            'balance' => 10
        ]);
    }
}
