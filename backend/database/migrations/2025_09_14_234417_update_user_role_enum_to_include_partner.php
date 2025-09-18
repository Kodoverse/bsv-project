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
        // For MySQL, we need to modify the enum by altering the column
        DB::statement("ALTER TABLE users MODIFY COLUMN user_role ENUM('user', 'editor', 'admin', 'librarian', 'partner') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove partner from enum and set any partner users back to user
        DB::statement("UPDATE users SET user_role = 'user' WHERE user_role = 'partner'");
        DB::statement("ALTER TABLE users MODIFY COLUMN user_role ENUM('user', 'editor', 'admin', 'librarian') DEFAULT 'user'");
    }
};