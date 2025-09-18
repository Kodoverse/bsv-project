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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->integer('points_price'); // Price in points
            $table->decimal('cash_equivalent', 8, 2)->nullable(); // Optional cash equivalent for reference
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_available')->default(true);
            $table->enum('category', ['food', 'beverage', 'merchandise', 'service', 'discount', 'other'])->default('other');
            $table->json('metadata')->nullable(); // For additional product details
            $table->timestamps();
            
            // Indexes
            $table->index(['partner_id', 'is_available']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};