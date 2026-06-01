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
        if (Schema::hasColumn('usia_sekolah_penduduk', 'usia_sltu_sederajat')) {
            Schema::table('usia_sekolah_penduduk', function (Blueprint $table) {
                $table->renameColumn('usia_sltu_sederajat', 'usia_sltp_sederajat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('usia_sekolah_penduduk', 'usia_sltp_sederajat')) {
            Schema::table('usia_sekolah_penduduk', function (Blueprint $table) {
                $table->renameColumn('usia_sltp_sederajat', 'usia_sltu_sederajat');
            });
        }
    }
};
