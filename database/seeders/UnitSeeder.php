<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [];

        // Property 1
        for ($i = 1; $i <= 12; $i++) {

            $units[] = [

                'property_id' => 1,

                'unit_number' => 'A' . str_pad($i, 2, '0', STR_PAD_LEFT),

                'unit_type' => '2 Bedroom',

                'monthly_rent' => 25000,

                'deposit' => 25000,

                'floor' => ceil($i / 4),

                'status' => $i <= 9 ? 'Occupied' : 'Vacant',

                'description' => 'Spacious apartment',

                'created_at' => now(),

                'updated_at' => now(),
            ];
        }

        // Property 2
        for ($i = 1; $i <= 10; $i++) {

            $units[] = [

                'property_id' => 2,

                'unit_number' => 'B' . str_pad($i, 2, '0', STR_PAD_LEFT),

                'unit_type' => 'Bedsitter',

                'monthly_rent' => 12000,

                'deposit' => 12000,

                'floor' => ceil($i / 5),

                'status' => $i <= 8 ? 'Occupied' : 'Vacant',

                'description' => 'Affordable bedsitter',

                'created_at' => now(),

                'updated_at' => now(),
            ];
        }

        // Property 3
        for ($i = 1; $i <= 8; $i++) {

            $units[] = [

                'property_id' => 3,

                'unit_number' => 'C' . str_pad($i, 2, '0', STR_PAD_LEFT),

                'unit_type' => 'Studio',

                'monthly_rent' => 18000,

                'deposit' => 18000,

                'floor' => ceil($i / 4),

                'status' => $i <= 6 ? 'Occupied' : 'Vacant',

                'description' => 'Modern studio apartment',

                'created_at' => now(),

                'updated_at' => now(),
            ];
        }

        Unit::insert($units);
    }
}