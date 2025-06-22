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
        Schema::table('users_infos', function (Blueprint $table) {
            $table->string('username')->unique()->after('lastname');
            $table->boolean('show_username')->default(true)->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_infos', function (Blueprint $table) {
            $table->dropColumn(['username', 'show_username']);
        });
    }
};
