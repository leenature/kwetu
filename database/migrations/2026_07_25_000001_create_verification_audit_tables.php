<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('property_verification_items', function (Blueprint $table) {
            $table->id(); $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('check_key'); $table->string('label'); $table->string('status')->default('Pending');
            $table->text('notes')->nullable(); $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamp('reviewed_at')->nullable(); $table->timestamps();
            $table->unique(['property_id', 'check_key']);
        });
        Schema::create('property_verification_audits', function (Blueprint $table) {
            $table->id(); $table->foreignId('property_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action'); $table->json('details')->nullable(); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('property_verification_audits'); Schema::dropIfExists('property_verification_items'); }
};
