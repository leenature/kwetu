<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        Property::insert([

            [

                'organization_id' => 1,

                'name'=>'Green Valley Apartments',

                'code'=>'GVA001',

                'type'=>'Apartment',

                'county'=>'Nairobi',

                'town'=>'Westlands',

                'address'=>'Westlands Road',

                'floors'=>6,

                'status'=>'Active',

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

            [

                'organization_id' => 1,

                'name'=>'Sunrise Residency',

                'code'=>'SR002',

                'type'=>'Apartment',

                'county'=>'Kiambu',

                'town'=>'Ruiru',

                'address'=>'Eastern Bypass',

                'floors'=>4,

                'status'=>'Active',

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

            [

                'organization_id' => 1,

                'name'=>'West Heights Suites',

                'code'=>'WHS003',

                'type'=>'Apartment',

                'county'=>'Nairobi',

                'town'=>'Kilimani',

                'address'=>'Argwings Kodhek Road',

                'floors'=>8,

                'status'=>'Active',

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

        ]);
    }
}