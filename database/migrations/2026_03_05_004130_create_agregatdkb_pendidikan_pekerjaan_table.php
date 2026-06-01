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
        Schema::create('pendidikan_penduduk_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->string('pendidikan', 50);
            $pekerjaan = [
                'belum_tidak_bekerja', 'mengurus_rumah_tangga', 'pelajar_mahasiswa', 'pensiunan',
                'pegawai_negeri_sipil_pns', 'tentara_nasional_indonesia_tni', 'kepolisian_ri_polri',
                'perdagangan', 'petani_pekebun', 'peternak', 'nelayan_perikanan', 'industri', 'konstruksi',
                'transportasi', 'karyawan_swasta', 'karyawan_bumn', 'karyawan_bumd', 'karyawan_honorer',
                'buruh_harian_lepas', 'buruh_tani_perkebunan', 'buruh_nelayan_perikanan', 'buruh_peternakan',
                'pembantu_rumah_tangga', 'tukang_cukur', 'tukang_listrik', 'tukang_batu', 'tukang_kayu',
                'tukang_sol_sepatu', 'tukang_las_pandai_besi', 'tukang_jahit', 'tukang_gigi',
                'penata_rias', 'penata_busana', 'penata_rambut', 'mekanik', 'seniman', 'tabib',
                'paraji', 'perancang_busana', 'penterjemah', 'imam_masjid', 'pendeta', 'pastor',
                'wartawan', 'ustadz_mubaligh', 'juru_masak', 'promotor_acara', 'anggota_dpr_ri',
                'anggota_dpd_ri', 'anggota_bpk', 'presiden', 'wakil_presiden', 'anggota_mahkamah_konstitusi',
                'anggota_kabinet_kementerian', 'duta_besar', 'gubernur', 'wakil_gubernur', 'bupati',
                'wakil_bupati', 'walikota', 'wakil_walikota', 'anggota_dprd_prop', 'anggota_dprd_kab_kota',
                'dosen', 'guru', 'pilot', 'pengacara', 'notaris', 'arsitek', 'akuntan', 'konsultan',
                'dokter', 'bidan', 'perawat', 'apoteker', 'psikiater_psikolog', 'penyiar_televisi',
                'penyiar_radio', 'pelaut', 'peneliti', 'sopir', 'pialang', 'paranormal', 'pedagang',
                'perangkat_desa', 'kepala_desa', 'biarawan_biarawati', 'wiraswasta',
                'anggota_lembaga_tinggi_lainnya', 'artis', 'atlit', 'chef', 'manajer',
                'tenaga_tata_usaha', 'operator', 'pekerja_pengolahan_kerajinan', 'teknisi',
                'asisten_ahli', 'pekerjaan_lainnya'
            ];

            foreach ($pekerjaan as $job) {
                $table->bigInteger($job . '_l')->default(0); // Laki-laki
                $table->bigInteger($job . '_p')->default(0); // Perempuan
            }

            $table->bigInteger('semester');
            $table->bigInteger('tahun');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agregatdkb_pendidikan_pekerjaan');
    }
};
