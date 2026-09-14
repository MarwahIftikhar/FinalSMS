<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Convert existing old role names to snake_case
        Role::where('name', 'Super Admin')
            ->update(['name' => 'super_admin']);

        Role::where('name', 'Supervisor')
            ->update(['name' => 'supervisor']);

        Role::where('name', 'Administrator')
            ->update(['name' => 'administrator']);

        // Create roles using snake_case names
        Role::firstOrCreate(
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            [
                'name' => 'supervisor',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            [
                'name' => 'administrator',
                'guard_name' => 'web',
            ]
        );
    }
}