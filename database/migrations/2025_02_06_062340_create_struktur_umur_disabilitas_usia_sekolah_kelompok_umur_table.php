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
        Schema::create('usia_sekolah_kelompok_umur_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');

            $categories = ['FISIK', 'NETRA_BUTA', 'RUNGU_WICARA', 'MENTAL_JIWA', 'FISIK_MENTAL', 'LAINNYA'];
            $ages = ['U4_6TH', 'U7_12TH', 'U13_15TH', 'U16_18TH'];

            foreach ($categories as $category) {
                foreach ($ages as $age) {
                    $table->integer("{$category}_{$age}_LK");
                    $table->integer("{$category}_{$age}_PR");
                }
            }

            $table->integer('semester');
            $table->integer('tahun');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usia_sekolah_kelompok_umur_disabilitas');
    }
};
