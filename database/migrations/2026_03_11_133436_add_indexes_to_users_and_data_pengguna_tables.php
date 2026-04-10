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
        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
        });

        // Add indexes to data_pengguna table
        Schema::table('data_pengguna', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('nik');
            $table->index('nama');
            $table->index('contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });

        // Drop indexes from data_pengguna table
        Schema::table('data_pengguna', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['nik']);
            $table->dropIndex(['nama']);
            $table->dropIndex(['contact']);
        });
    }
};
