<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if partner already exists
        $existingPartner = DB::table('users')->where('email', 'testpartner@example.com')->first();
        
        if (!$existingPartner) {
            // Create a test partner user
            $userId = DB::table('users')->insertGetId([
                'name' => 'Test Partner',
                'email' => 'testpartner@example.com',
                'password' => Hash::make('12345678'),
                'user_role' => 'partner',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create partner info for the test partner
            DB::table('partner_infos')->insert([
                'user_id' => $userId,
                'business_name' => 'Test Partner Business',
                'business_category' => 'cafe',
                'business_address' => '123 Main Street, Test City',
                'business_description' => 'A test partner business for demonstration purposes',
                'contact_phone' => '+1234567890',
                'business_email' => 'business@testpartner.com',
                'is_active' => true,
                'redemption_rules' => 'Standard redemption rules apply.',
                'min_points_per_redemption' => 10,
                'max_points_per_redemption' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "Created test partner with ID: " . $userId . "\n";
        } else {
            echo "Partner already exists with ID: " . $existingPartner->id . "\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the test partner
        $userId = DB::table('users')->where('email', 'testpartner@example.com')->value('id');
        if ($userId) {
            DB::table('partner_infos')->where('user_id', $userId)->delete();
            DB::table('users')->where('id', $userId)->delete();
        }
    }
};