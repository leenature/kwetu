<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::create([

            'name' => 'Kwetu Property Management Ltd',

            'registration_number' => 'CPR/2026/001',

            'kra_pin' => 'P123456789A',

            'phone' => '0725469654',

            'email' => 'admin@kwetu.co.ke',

            'website' => 'https://kwetu.co.ke',

            'address' => 'Westlands',

            'city' => 'Nairobi',

            'country' => 'Kenya',

            'status' => 'Active',

        ]);
    }
}