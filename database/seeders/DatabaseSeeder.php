<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrganizationSeeder::class,
            PropertySeeder::class,
            UnitSeeder::class,
            TenantSeeder::class,
            LeaseSeeder::class,
            PaymentSeeder::class,
            ExpenseSeeder::class,
        ]);

        User::create([
            'organization_id' => 1,
            'name' => 'Mathenge Lee',
            'email' => 'admin@kwetu.test',
            'password' => Hash::make('password'),
            'role' => 'Super Admin',
        ]);
    }
}