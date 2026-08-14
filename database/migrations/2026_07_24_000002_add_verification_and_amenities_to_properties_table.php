<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('properties', function (Blueprint $table) {
            $table->json('amenities')->nullable()->after('description');
            $table->string('verification_status')->default('Pending Review')->after('status');
            $table->text('verification_notes')->nullable()->after('verification_status');
            $table->foreignId('reviewed_by')->nullable()->after('verification_notes')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });
    }
    public function down(): void {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['amenities', 'verification_status', 'verification_notes', 'reviewed_at']);
        });
    }
};
