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
        Schema::table('partner_infos', function (Blueprint $table) {
            $table->enum('business_category', [
                'cafe', 
                'restaurant', 
                'bar', 
                'supermarket', 
                'clothing', 
                'electronics', 
                'pharmacy', 
                'bookstore', 
                'sports', 
                'beauty', 
                'service',
                'other'
            ])->default('other')->after('business_address');
            
            $table->text('business_description')->nullable()->after('business_category');
            $table->string('business_logo')->nullable()->after('business_description');
            $table->string('business_website')->nullable()->after('business_logo');
            $table->json('business_hours')->nullable()->after('business_website');
            $table->string('business_email')->nullable()->after('business_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_infos', function (Blueprint $table) {
            $table->dropColumn([
                'business_category',
                'business_description',
                'business_logo',
                'business_website',
                'business_hours',
                'business_email'
            ]);
        });
    }
};