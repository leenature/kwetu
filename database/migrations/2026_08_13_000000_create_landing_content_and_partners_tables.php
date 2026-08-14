<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('landing_settings', function (Blueprint $table) {
            $table->id(); $table->string('key')->unique(); $table->text('value')->nullable(); $table->timestamps();
        });
        Schema::create('service_partners', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('website')->nullable(); $table->string('icon')->default('bi-link-45deg'); $table->string('description')->nullable(); $table->boolean('is_active')->default(true); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        DB::table('service_partners')->insert([
            'name' => 'Pima Maji System', 'website' => 'https://pimamajisystem.com/',
            'icon' => 'bi-droplet-fill', 'description' => 'Smart water management',
            'is_active' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now(),
        ]);
    }
    public function down(): void { Schema::dropIfExists('service_partners'); Schema::dropIfExists('landing_settings'); }
};
