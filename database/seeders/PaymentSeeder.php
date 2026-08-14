<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 23; $i++) {

            Payment::create([

                'organization_id' => 1,

                'lease_id' => $i,

                'payment_date' => now()->startOfMonth()->addDays(rand(0,8)),

                'amount_paid' => rand(18000,65000),

                'payment_method' => 'M-Pesa',

                'reference_number' => 'MPESA'.rand(10000000,99999999),

                'receipt_number' => 'RCT'.str_pad($i,5,'0',STR_PAD_LEFT),

                'payment_for' => 'Rent',

                'notes' => 'Monthly rent payment',

            ]);

        }
    }
}