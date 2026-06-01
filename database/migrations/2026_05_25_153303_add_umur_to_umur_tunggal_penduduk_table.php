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
        Schema::table('umur_tunggal_penduduk', function (Blueprint $table) {
            $table->string('umur', 50)->after('kode_wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umur_tunggal_penduduk', function (Blueprint $table) {
            $table->dropColumn('umur');
        });
    }
};
