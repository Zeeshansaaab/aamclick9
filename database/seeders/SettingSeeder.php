<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        
        Setting::insert(
        [
            // Site info settings
            ['group' => 'site_info', 'type' => 'text', 'name' => 'Site name', 'key' => 'site_name', 'value' => 'AAM Earning', 'is_required' => null, 'created_at' => Carbon::now()],
            ['group' => 'site_info', 'type' => 'text', 'name' => 'Site phone', 'key' => 'site_phone', 'value' => '+923001309060', 'is_required' => null, 'created_at' => Carbon::now()],
            ['group' => 'site_info', 'type' => 'email', 'name' => 'Site email', 'key' => 'site_email', 'value' => 'Contact@aamclick.com', 'is_required' => null, 'created_at' => Carbon::now()],
            ['group' => 'site_info', 'type' => 'text', 'name' => 'System info', 'key' => 'system_info', 'value' => '[]', 'is_required' => null, 'created_at' => Carbon::now()],

            [
                'group' => 'currency_setting',
                'type' => 'text',
                'key' => 'cur_text',
                'name' => 'Currency Text',
                'value' => 'USD',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'currency_setting',
                'type' => 'text',
                'name' => 'Currency symbol',
                'key' => 'cur_sym',
                'value' => '$',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'color',
                'type' => 'text',
                'name' => 'Base Color',
                'key' => 'base_color',
                'value' => '0099ff',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'color',
                'type' => 'text',
                'name' => 'Secondary color',
                'key' => 'secondary_color',
                'value' => '001d4a',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'force_ssl',
                'type' => 'checkbox',
                'name' => 'force SSL',
                'key' => 'force_ssl',
                'is_required' => null,
                'value' => '1',
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'maintainance_mode',
                'type' => 'checkbox',
                'name' => 'Maintanance mode',
                'key' => 'maintainance_mode',
                'value' => '0',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'auth',
                'type' => 'text',
                'name' => 'Registration',
                'key' => 'registration',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'template',
                'type' => 'text',
                'name' => 'Active template',
                'key' => 'active_template',
                'is_required' => null,
                'value' => 'coinjet',
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'commission',
                'type' => 'number',
                'name' => 'Deposit commission',
                'key' => 'deposit_commission',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'commission',
                'type' => 'number',
                'name' => 'Plan subscribe commission',
                'key' => 'plan_subscribe_commission',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'bonus',
                'type' => 'number',
                'name' => 'Registration bonus',
                'key' => 'registration_bonus',
                'value' => '50',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'bonus',
                'type' => 'checkbox',
                'name' => 'Profit bonus',
                'key' => 'profit_bonus',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'bonus',
                'type' => 'number',
                'name' => 'Profit bonus percentage',
                'key' => 'profit_bonus_percentage',
                'value' => '50',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'bonus',
                'type' => 'number',
                'name' => 'Profit bonus days',
                'key' => 'profit_bonus_days',
                'value' => '50',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'transfer',
                'type' => 'number',
                'name' => 'Balance transfer fixed charge',
                'key' => 'balance_transfer_fixed_charge',
                'value' => '2',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'transfer',
                'type' => 'number',
                'name' => 'Balance transfer fixed percentage',
                'key' => 'balance_transfer_fixed_percentage',
                'value' => '30',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'transfer',
                'type' => 'number',
                'name' => 'Balance transfer',
                'key' => 'balance_transfer',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'plan',
                'type' => 'select',
                'name' => 'Default plan',
                'key' => 'default_plan',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'ads',
                'type' => 'text',
                'name' => 'Ads auto approve',
                'key' => 'ad_auto_approve',
                'value' => 'middle_name',
                'is_required' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'ads',
                'type' => 'text',
                'name' => 'User ads post',
                'key' => 'user_ads_post',
                'value' => '0',
                'is_required' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'ads',
                'type' => 'textarea',
                'name' => 'Ads setting',
                'key' => 'ads_setting',
                'value' => '{"ad_price":{"script":"0.25","image":"0.25","url":"0.25","youtube":"0.25"},"amount_for_user":{"script":"0.15","image":"0.15","url":"0.15","youtube":"0.15"}}',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'verification',
                'type' => 'checkbox',
                'name' => 'Email verification',
                'key' => 'email_verification',
                'value' => '1',
                'is_required' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'verification',
                'type' => 'checkbox',
                'name' => 'SMS verification',
                'key' => 'sms_verification',
                'value' => '0',
                'is_required' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'group' => 'email_notification',
                'type' => 'checkbox',
                'name' => 'Active',
                'key' => 'active',
                'value' => '1',
                'is_required' => null,
                'created_at' => Carbon::now()
            ],
            
        ]);

        // email settings and Push Notifications
        $groups = [
            'email_notification',
            'push_notification'
        ];
        $types = [
            'General',
        ];

        $generalForEmail = [
                [
                    'key' => 'email_from_name',
                    'name' => 'Email From Name',
                    'value' => 'Aamearning',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'reply_to_name',
                    'name' => 'Reply to Name',
                    'value' => 'Aamearning',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'reply_to_email',
                    'name' => 'Reply to Email',
                    'value' => 'admin@aamearning.com',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'mail_mailer',
                    'name' => 'Mail Mailer',
                    'value' => 'smtp',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'mail_host',
                    'name' => 'Mail Host',
                    'value' => 'smtp.mailtrap.io',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'mail_port',
                    'name' => 'Mail Port',
                    'value' => '2525',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'mail_username',
                    'name' => 'Mail Username',
                    'value' => '',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'mail_password',
                    'name' => 'Mail Password',
                    'value' => '',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
                [
                    'key' => 'encryption_type',
                    'name' => 'Encryption Type',
                    'value' => 'tls',
                    'is_required' => null,
                    'created_at' => Carbon::now()
                ],
            ];
            
        foreach($groups as $group){   
            foreach($types as $type){
                if($type == 'General'){
                    // general data stored
                    if($group == 'email_notification'){
                        
                        foreach ($generalForEmail as $setting) {
                            $setting = array_merge($setting,['type' => $type, 'group' => $group]);
                            Setting::create($setting);
                        } 
                    }
                }
            }
        }
    }
}

