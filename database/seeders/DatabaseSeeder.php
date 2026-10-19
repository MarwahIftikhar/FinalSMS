<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call([
            RoleSeeder::class,
        ]);

        // User::factory(10)->create();

        foreach ([
            'Nursery',
            'Prep',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
        ] as $name) {
            ClassModel::firstOrCreate([
                'branch_id' => 1,
                'name' => $name,
            ], [
                'status' => true,
            ]);
        }

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
            'branch_id' => 1,
        ]);

        // Fresh installs: make the initial user a super admin
        $user->assignRole('super_admin');
    }
}
