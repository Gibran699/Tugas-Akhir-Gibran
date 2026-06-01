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
            $table->string('kode_wilayah', 50);

            $categories = ['fisik', 'netra_buta', 'rungu_wicara', 'mental_jiwa', 'fisik_mental', 'lainnya'];
            $ages = ['u4_6th', 'u7_12th', 'u13_15th', 'u16_18th'];

            foreach ($categories as $category) {
                foreach ($ages as $age) {
                    $table->bigInteger("{$category}_{$age}_lk");
                    $table->bigInteger("{$category}_{$age}_pr");
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
