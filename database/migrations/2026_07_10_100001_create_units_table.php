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
        Schema::create('units', function (Blueprint $table) {

            $table->id();

            $table->foreignId('property_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('unit_number');

            $table->string('unit_type');

            $table->unsignedTinyInteger('bedrooms')->default(0);

            $table->unsignedTinyInteger('bathrooms')->default(1);

            $table->unsignedInteger('floor')->default(1);

            $table->decimal('monthly_rent', 12, 2);

            $table->decimal('deposit', 12, 2)->default(0);

            $table->enum('status', [
                'Vacant',
                'Occupied',
                'Reserved',
                'Maintenance'
            ])->default('Vacant');

            $table->text('description')->nullable();

            $table->timestamps();

            // Prevent duplicate unit numbers within the same property
            $table->unique(['property_id', 'unit_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};