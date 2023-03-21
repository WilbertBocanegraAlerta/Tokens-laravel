<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        $super_admin = Role::create(['guard_name' => 'api', 'name' => 'super_admin']);
        $admin = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        $user = Role::create(['guard_name' => 'api', 'name' => 'user']);
    }
}
