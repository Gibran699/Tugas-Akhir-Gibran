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
        Schema::create('data_pengguna', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nik', 18);
            $table->string('nama', 100);
            $table->string('contact', 16);
            $table->integer('instansi');
            $table->string('nama_instansi',100);
            $table->uuid('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pengguna');
    }
};
