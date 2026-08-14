<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('service_partners', function (Blueprint $table) {
            $table->boolean('available_to_all_properties')->default(true)->after('is_active');
        });

        Schema::create('property_service_partner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_partner_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['property_id', 'service_partner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_service_partner');
        Schema::table('service_partners', fn (Blueprint $table) => $table->dropColumn('available_to_all_properties'));
    }
};
