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
        Schema::table('users', function (Blueprint $table) {
            // Add check constraint to ensure user_role is one of the allowed values
            DB::statement("ALTER TABLE users ADD CONSTRAINT chk_user_role CHECK (user_role IN ('user', 'admin', 'librarian', 'partner'))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users DROP CONSTRAINT chk_user_role");
        });
    }
};
