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
        Schema::create('status_kawin_kelompok_umur_kepala_keluarga', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);

            $ageGroups = [
                '00_04', '05_09', '10_14', '15_19', '20_24', '25_29',
                '30_34', '35_39', '40_44', '45_49', '50_54', '55_59',
                '60_64', '65_69', '70_74', 'lebih_75'
            ];

            $statuses = ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati'];

            foreach ($ageGroups as $age) {
                foreach ($statuses as $status) {
                    $table->bigInteger("{$age}_{$status}_lk");
                    $table->bigInteger("{$age}_{$status}_pr");
                }
            }
            $table->integer('semester');
            $table->integer('tahun');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_kawin_kelompok_umur_kepala_keluarga');
    }
};
