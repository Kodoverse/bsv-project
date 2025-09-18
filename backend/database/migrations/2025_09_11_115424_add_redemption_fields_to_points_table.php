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
        Schema::table('points', function (Blueprint $table) {
            $table->string('type')->default('award')->comment('award or redemption');
            $table->foreignId('partner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('redemption_reference')->nullable();
            
            // Make event_id nullable since redemptions won't have an event
            $table->foreignId('event_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->dropColumn(['type', 'redemption_reference']);
            $table->dropForeign(['partner_id']);
            $table->dropColumn('partner_id');
            
            // Make event_id required again
            $table->foreignId('event_id')->change();
        });
    }
};
