<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('organization_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('lease_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->date('payment_date');

            $table->decimal('amount_paid', 12, 2);

            $table->enum('payment_method', [
                'Cash',
                'M-Pesa',
                'Bank Transfer',
                'Cheque',
                'Card',
                'Other'
            ]);

            $table->string('reference_number')->nullable();

            $table->string('receipt_number')->unique();

            $table->string('payment_for')->default('Rent');

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};