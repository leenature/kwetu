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
    Schema::table('organizations', function (Blueprint $table) {
        $table->string('plan')->default('starter')->after('status');
        $table->string('subscription_status')->default('trialing')->after('plan');
        $table->timestamp('trial_ends_at')->nullable()->after('subscription_status');
    });
}

public function down(): void
{
    Schema::table('organizations', function (Blueprint $table) {
        $table->dropColumn([
            'plan',
            'subscription_status',
            'trial_ends_at',
        ]);
    });
}
};
