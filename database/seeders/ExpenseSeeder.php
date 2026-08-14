<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        Expense::insert([

            [
                'organization_id' => 1,
                'property_id' => 1,
                'unit_id' => null,
                'category' => 'Utilities',
                'title' => 'Water Bill',
                'amount' => 12500,
                'expense_date' => now()->subDays(5),
                'vendor' => 'Nairobi Water',
                'payment_method' => 'Bank Transfer',
                'reference_number' => 'EXP001',
                'status' => 'Paid',
                'notes' => 'Monthly water bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'organization_id' => 1,
                'property_id' => 1,
                'unit_id' => null,
                'category' => 'Security',
                'title' => 'Security Services',
                'amount' => 45000,
                'expense_date' => now()->subDays(3),
                'vendor' => 'Secure Ltd',
                'payment_method' => 'Bank Transfer',
                'reference_number' => 'EXP002',
                'status' => 'Paid',
                'notes' => 'Monthly security services',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'organization_id' => 1,
                'property_id' => 2,
                'unit_id' => 12,
                'category' => 'Maintenance',
                'title' => 'Painting',
                'amount' => 18000,
                'expense_date' => now()->subDays(2),
                'vendor' => 'Painter Pro',
                'payment_method' => 'Cash',
                'reference_number' => 'EXP003',
                'status' => 'Paid',
                'notes' => 'Repainted apartment',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'organization_id' => 1,
                'property_id' => 3,
                'unit_id' => null,
                'category' => 'Electricity',
                'title' => 'Common Area Electricity',
                'amount' => 22000,
                'expense_date' => now()->subDay(),
                'vendor' => 'Kenya Power',
                'payment_method' => 'M-Pesa',
                'reference_number' => 'EXP004',
                'status' => 'Paid',
                'notes' => 'Monthly electricity bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}