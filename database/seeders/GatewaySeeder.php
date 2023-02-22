<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gateways = [
            [
                'name'                      => 'Easypaisa',
                // 'slug'                   => Str::slug('Easypaisa'),
                'image'                     => '',
                'min_amount'                => 10,
                'max_amount'                => 20000,
                'currency'                  => "PKR",
                'currency_value'            => 180,
                'description'               => '<b>Name:</b> Hafiz Abdul Malik<br/><b>Account Number</b>: 03041450855' ,
                'gateway_parameters'    => json_encode([
                    [
                        'label' => 'Account Holder Name',
                        'type' => 'text',
                        'name' => 'account_holder_name',
                    ],
                    [
                        'label' => 'Account Holder Number',
                        'type' => 'text',
                        'name' => 'account_holder_number',
                    ]
                ]),
                'type'                  => 'both',
                'crypto'                => false,
                'status'                => 'active'
            ],
            [
                'name'                       => 'Jazzcash',
                // 'slug'                    => Str::slug('Jazzcash'),
                'image'                      => '/images/gateways/jazz.png',
                'min_amount'                 => 10,
                'max_amount'                 => 20000,
                'currency'                   => "PKR",
                'currency_value'             => 180,
                'gateway_parameters'    => json_encode([
                    [
                        'label' => 'Account Holder Name',
                        'type' => 'text',
                        'name' => 'account_holder_name',
                    ],
                    [
                        'label' => 'Account Holder Number',
                        'type' => 'text',
                        'name' => 'account_holder_number',
                    ]
                ]),
                'type'                  => 'both',
                'description'               => '<b>Name:</b> Hafiz Abdul Malik<br/><b>Account Number</b>: 03041450855' ,
                'crypto'                => false,
                'status'                => 'active'
            ]
        ];

        foreach($gateways as $gateway){
            Gateway::create($gateway);
        }
    }
}
