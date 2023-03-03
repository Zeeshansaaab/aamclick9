<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // dashboard
            ['group' => 'dashboard', 'name' => 'view_dashboard', 'title' => 'View dashboard', 'guard_name' => 'web'],
            //Plans
            ['group' => 'plans', 'name' => 'view_plans', 'title' => 'View plans', 'guard_name' => 'web'],
            ['group' => 'plans', 'name' => 'create_plans', 'title' => 'create plans', 'guard_name' => 'web'],
            ['group' => 'plans', 'name' => 'edit_plans', 'title' => 'edit plans', 'guard_name' => 'web'],
            ['group' => 'plans', 'name' => 'delete_plans', 'title' => 'delete plans', 'guard_name' => 'web'],
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }
    }
}
