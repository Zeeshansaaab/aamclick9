<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Enums\Status;
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
        User::create([
            'name' => "User",
            'email' => 'user@aamclick.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'country_code'   => '0300',
            'mobile'   => '8090100',
            'status'   => Status::Active,
        ]);
        
        $this->call([
            SettingSeeder::class,
            PlanSeeder::class,
        ]);

        User::factory(50)->create();
    }
}
