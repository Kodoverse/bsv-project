<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partner_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->onDelete('set null');
            $table->string('business_name');
            $table->string('business_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('redemption_rules')->nullable();
            $table->integer('min_points_per_redemption')->default(0);
            $table->integer('max_points_per_redemption')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Ensure one partner info per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_infos');
        
    }
};
