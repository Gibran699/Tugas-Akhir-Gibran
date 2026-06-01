<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('mstr_kecamatan')) {
            Schema::create('mstr_kecamatan', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')->nullable();
                $table->integer('kode')->nullable();
                $table->string('nama')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('mstr_kelurahan')) {
            Schema::create('mstr_kelurahan', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')->nullable();
                $table->bigInteger('kode')->nullable();
                $table->string('nama')->nullable();
                $table->bigInteger('kec_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('mstr_kelurahan');
        Schema::dropIfExists('mstr_kecamatan');
    }
};
