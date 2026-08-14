<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('property_clients', function (Blueprint $table) {
            $table->id(); $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name'); $table->string('phone', 30); $table->string('email')->nullable();
            $table->string('id_number')->nullable(); $table->text('address')->nullable(); $table->timestamps();
        });
        Schema::create('management_agreements', function (Blueprint $table) {
            $table->id(); $table->foreignId('property_client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->nullable(); $table->date('starts_on')->nullable(); $table->date('ends_on')->nullable();
            $table->decimal('management_fee', 12, 2)->nullable(); $table->string('document_path')->nullable(); $table->string('status')->default('Active'); $table->timestamps();
        });
        Schema::table('properties', fn (Blueprint $table) => $table->foreignId('property_client_id')->nullable()->after('organization_id')->constrained()->nullOnDelete());
    }
    public function down(): void { Schema::table('properties', fn (Blueprint $table) => $table->dropConstrainedForeignId('property_client_id')); Schema::dropIfExists('management_agreements'); Schema::dropIfExists('property_clients'); }
};
