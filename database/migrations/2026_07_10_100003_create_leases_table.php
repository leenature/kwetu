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
        Schema::create('leases', function (Blueprint $table) {

            $table->id();

            $table->foreignId('tenant_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('unit_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->decimal('rent_amount', 12, 2);

            $table->decimal('deposit_amount', 12, 2)->default(0);

            $table->enum('payment_frequency', [
                'Monthly',
                'Quarterly',
                'Yearly'
            ])->default('Monthly');

            $table->enum('status', [
                'Active',
                'Expired',
                'Terminated'
            ])->default('Active');

            $table->text('notes')->nullable();

            $table->timestamps();

            // Prevent duplicate active lease for the same tenant and unit
            $table->unique([
                'tenant_id',
                'unit_id',
                'start_date'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};