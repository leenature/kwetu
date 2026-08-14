<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {

            $table->id();

            $table->foreignId('organization_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('full_name');

            $table->string('id_number')->unique();

            $table->string('phone');

            $table->string('email')->nullable();

            $table->enum('gender', [
                'Male',
                'Female',
                'Other'
            ]);

            $table->date('date_of_birth')->nullable();

            $table->string('occupation')->nullable();

            $table->string('employer')->nullable();

            $table->string('emergency_contact_name')->nullable();

            $table->string('emergency_contact_phone')->nullable();

            $table->string('relationship')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};