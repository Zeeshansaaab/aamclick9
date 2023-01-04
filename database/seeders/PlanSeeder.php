<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
            'name'                  => 'Starter',
            'description'           => 'Invest as entry level',
            'min_price'             => 0,
            'max_price'             => 0,
            'min_profit_percent'    => 6,
            'max_profit_percent'    => 16,
            'amount_return'         => 0,
            'validity'              => '6 Months',
            'type'                  => 'default',
            'status'                => 'active',
            ],
            [
            'name'                  => 'Starter',
            'description'           => 'Invest as entry level',
            'price'                 => 1000,
            'max_price'             => 0,
            'min_profit_percent'    => 6,
            'max_profit_percent'    => 16,
            'amount_return'         => 0,
            'validity'              => '6 Months',
            'type'                  => 'committee',
            'status'                => 'active',
        ]
    ];

        foreach($plans as $plan){
            Plan::create($plan);
        }
    }
}
