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
        Schema::create('pekerjaan_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);

            $pekerjaan = [
                'BELUM_TIDAK_BEKERJA', 'MENGURUS_RUMAH_TANGGA', 'PELAJAR_MAHASISWA', 'PENSIUNAN',
                'PEGAWAI_NEGERI_SIPIL_PNS', 'TENTARA_NASIONAL_INDONESIA_TNI', 'KEPOLISIAN_RI_POLRI',
                'PERDAGANGAN', 'PETANI_PEKEBUN', 'PETERNAK', 'NELAYAN_PERIKANAN', 'INDUSTRI', 'KONSTRUKSI',
                'TRANSPORTASI', 'KARYAWAN_SWASTA', 'KARYAWAN_BUMN', 'KARYAWAN_BUMD', 'KARYAWAN_HONORER',
                'BURUH_HARIAN_LEPAS', 'BURUH_TANI_PERKEBUNAN', 'BURUH_NELAYAN_PERIKANAN', 'BURUH_PETERNAKAN',
                'PEMBANTU_RUMAH_TANGGA', 'TUKANG_CUKUR', 'TUKANG_LISTRIK', 'TUKANG_BATU', 'TUKANG_KAYU',
                'TUKANG_SOL_SEPATU', 'TUKANG_LAS_PANDAI_BESI', 'TUKANG_JAHIT', 'TUKANG_GIGI',
                'PENATA_RIAS', 'PENATA_BUSANA', 'PENATA_RAMBUT', 'MEKANIK', 'SENIMAN', 'TABIB',
                'PARAJI', 'PERANCANG_BUSANA', 'PENTERJEMAH', 'IMAM_MASJID', 'PENDETA', 'PASTOR',
                'WARTAWAN', 'USTADZ_MUBALIGH', 'JURU_MASAK', 'PROMOTOR_ACARA', 'ANGGOTA_DPR_RI',
                'ANGGOTA_DPD_RI', 'ANGGOTA_BPK', 'PRESIDEN', 'WAKIL_PRESIDEN', 'ANGGOTA_MAHKAMAH_KONSTITUSI',
                'ANGGOTA_KABINET_KEMENTERIAN', 'DUTA_BESAR', 'GUBERNUR', 'WAKIL_GUBERNUR', 'BUPATI',
                'WAKIL_BUPATI', 'WALIKOTA', 'WAKIL_WALIKOTA', 'ANGGOTA_DPRD_PROP', 'ANGGOTA_DPRD_KAB_KOTA',
                'DOSEN', 'GURU', 'PILOT', 'PENGACARA', 'NOTARIS', 'ARSITEK', 'AKUNTAN', 'KONSULTAN',
                'DOKTER', 'BIDAN', 'PERAWAT', 'APOTEKER', 'PSIKIATER_PSIKOLOG', 'PENYIAR_TELEVISI',
                'PENYIAR_RADIO', 'PELAUT', 'PENELITI', 'SOPIR', 'PIALANG', 'PARANORMAL', 'PEDAGANG',
                'PERANGKAT_DESA', 'KEPALA_DESA', 'BIARAWAN_BIARAWATI', 'WIRASWASTA',
                'ANGGOTA_LEMBAGA_TINGGI_LAINNYA', 'ARTIS', 'ATLIT', 'CHEF', 'MANAJER',
                'TENAGA_TATA_USAHA', 'OPERATOR', 'PEKERJA_PENGOLAHAN_KERAJINAN', 'TEKNISI',
                'ASISTEN_AHLI', 'PEKERJAAN_LAINNYA'
            ];

            foreach ($pekerjaan as $job) {
                $table->integer($job . '_L')->default(0); // Laki-laki
                $table->integer($job . '_P')->default(0); // Perempuan
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
        Schema::dropIfExists('pekerjaan_disabilitas');
    }
};
