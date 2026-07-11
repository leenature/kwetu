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
        Schema::create('expenses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('property_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('unit_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->string('category');

            $table->string('title');

            $table->decimal('amount', 12, 2);

            $table->date('expense_date');

            $table->string('vendor')->nullable();

            $table->string('payment_method')->nullable();

            $table->string('reference_number')->nullable();

            $table->enum('status', [
                'Pending',
                'Paid',
                'Cancelled'
            ])->default('Paid');

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};