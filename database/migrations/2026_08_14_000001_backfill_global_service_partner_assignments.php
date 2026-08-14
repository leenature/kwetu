<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $now = now();
        $propertyIds = DB::table('properties')->pluck('id');

        foreach (DB::table('service_partners')->where('available_to_all_properties', true)->pluck('id') as $partnerId) {
            foreach ($propertyIds as $propertyId) {
                DB::table('property_service_partner')->insertOrIgnore([
                    'property_id' => $propertyId, 'service_partner_id' => $partnerId,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Existing provider assignments are user data and must be retained.
    }
};
