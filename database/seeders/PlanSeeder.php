<?php

namespace Database\Seeders;

use App\Models\Plan;
use Carbon\Carbon;
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
        if(env('APP_SEED') == 'TRUE'){
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
                ], [
                    'name'                  => '100 dollar',
                    'price'                 => 100,
                    'type'                  => 'committee',
                    'status'                => 'active',
                ], [
                    'name'                  => '100 dollar',
                    'description'           => 'Invest as entry level',
                    'price'                 => 100,
                    'max_price'             => 0,
                    'min_profit_percent'    => 0,
                    'max_profit_percent'    => 0,
                    'amount_return'         => 10,
                    'validity'              => '10 Months',
                    'parent_id'             => 2,
                    'type'                  => 'committee',
                    'total_members'         => 10,
                    'starting_date'         => Carbon::now()->addMonth(1),
                    'status'                => 'active',
                ]
            ];
        }

        $plans [] = [
            'name'                  => 'Umrah Package',
            'description'           => 'Umrah Package',
            'price'                 => 130000,
            'max_price'             => 0,
            'min_profit_percent'    => 0,
            'max_profit_percent'    => 0,
            'amount_return'         => 0,
            'validity'              => '',
            'parent_id'             => null,
            'type'                  => 'umrah',
            'total_members'         => 0,
            'starting_date'         => Carbon::now()->addMonth(1),
            'status'                => 'active',
        ];
        $plans[] = [
            'name'                  => '2000 dollar',
            'description'           => 'Invest as entry level',
            'price'                 => 2000,
            'max_price'             => 0,
            'min_profit_percent'    => 0,
            'max_profit_percent'    => 0,
            'amount_return'         => 0,
            'validity'              => '',
            'parent_id'             => null,
            'type'                  => 'reward',
            'total_members'         => 0,
            'starting_date'         => null,
            'status'                => 'active',
        ];
        foreach($plans as $plan){
            Plan::create($plan);
        }
    }
}
