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
        Schema::create('properties', function (Blueprint $table) {

            $table->id();

            $table->foreignId('organization_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('code')->unique();

            $table->string('name');

            $table->enum('type', [
                'Apartment',
                'Bedsitter',
                'Commercial',
                'Office',
                'Maisonette',
                'Hostel',
                'Mixed Use',
                'Other'
            ]);

            $table->string('county');

            $table->string('town');

            $table->string('address');

            $table->unsignedInteger('floors')->default(1);

            $table->text('description')->nullable();

            $table->enum('status', [
                'Active',
                'Inactive'
            ])->default('Active');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};