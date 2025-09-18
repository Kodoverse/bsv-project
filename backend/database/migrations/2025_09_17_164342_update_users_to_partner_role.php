<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update users with IDs 5 and 7 to have partner role
        // These users have partner_infos records but don't have partner role
        DB::table('users')
            ->whereIn('id', [5, 7])
            ->update(['user_role' => 'partner']);
            
        echo "Updated users 5 and 7 to partner role\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert users back to their original roles
        DB::table('users')
            ->whereIn('id', [5, 7])
            ->update(['user_role' => 'user']);
    }
};