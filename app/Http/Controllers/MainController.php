<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AgregatDKB\Penduduk\JenisKelamin;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    function index($codeView)
    {
        $redirectView = [
            "MupFCfSa6a" => "agregat_dkb.penduduk.agama_index",
            "aPH7zF09S1" => "agregat_dkb.penduduk.golongan_darah_index",
            "CV8V59hUCF" => "agregat_dkb.penduduk.jenis_kelamin_index",
            "fFKZKP7AnA" => "agregat_dkb.penduduk.pekerjaan_index",
            "bfl4aaeCTi" => "agregat_dkb.penduduk.hubungan_keluarga_index",
            "nYtZCUxdr6" => "agregat_dkb.kepala_keluarga.agama_index",
            "MNJiVyMrxR" => "agregat_dkb.kepala_keluarga.jenis_kelamin_index",
            "gblPf8pfSp" => "agregat_dkb.kepala_keluarga.pendidikan_index",
            "aQIpF1uiEO" => "agregat_dkb.kepala_keluarga.pekerjaan_index",
            "ZvGL0vPJLC" => "agregat_dkb.kepala_keluarga.status_kawin_index",
            "2XSDKgCQJH" => "agregat_dkb.status_kawin.agama_index",
            "oqhOV9WfkB" => "agregat_dkb.status_kawin.jenis_kelamin_index",
            "AWn2KmOLao" => "agregat_dkb.status_kawin.pekerjaan_index",
            "XYPtrXHZkf" => "agregat_dkb.pendidikan.jenis_kelamin_index",
            "XYPt22HZkf" => "agregat_dkb.pendidikan.golongan_darah_index",
            "eRPt22HZkf" => "agregat_dkb.pendidikan.pekerjaan_index",
            "trg1Xxialt" => "agregat_dkb.disabilitas.jenis_kelamin_index",
            "iXnbXnoUnq" => "agregat_dkb.disabilitas.pekerjaan_index",
            "8sfHKi6GHS" => "agregat_dkb.disabilitas.pendidikan_index",
            "6D6A18O1Hm" => "kepemilikan.akta_kelahiran",
            "CJY6qXue82" => "kepemilikan.akta_kawin",
            "PKf3FqywDa" => "kepemilikan.akta_kawin_agama",
            "goKsHUTCOG" => "kepemilikan.akta_cerai",
            "eCnoaOxtiS" => "kepemilikan.akta_cerai_agama",
            "2ovlKZBzGU" => "kepemilikan.kia",
            "6DFxmctALZ" => "kepemilikan.kartu_keluarga",
            "hsdtkgPeS5" => "kepemilikan.ktp",
            "OqF8P0knI7" => "struktur_umur.agama.kelompok_umur_index",
            "VtDkcpu8FN" => "struktur_umur.disabilitas.kelompok_umur_index",
            "nx8eUW4TWq" => "struktur_umur.disabilitas.pendidikan_umur_tunggal_index",
            "3WjgN9m6aS" => "struktur_umur.disabilitas.umur_tunggal_index",
            "FIZKE9hOxo" => "struktur_umur.disabilitas.usia_sekolah_kelompok_umur_index",
            "dRgHdz0S5A" => "struktur_umur.golongan_darah.kelompok_umur_index",
            "eRkbPisQHv" => "struktur_umur.golongan_darah.umur_tunggal_index",
            "svFaBJRBLQ" => "struktur_umur.kepala_keluarga.kelompok_umur_index",
            "EJpy2qXC3z" => "struktur_umur.kepala_keluarga.status_kawin_kelompok_umur_index",
            "lo4z2cDrRC" => "struktur_umur.kepala_keluarga.umur_tunggal_index",
            "gWNOWEQuYC" => "struktur_umur.penduduk.kelompok_umur_index",
            "RIvQj7G1XZ" => "struktur_umur.penduduk.status_kawin_kelompok_umur_index",
            "4riLDLsE6q" => "struktur_umur.penduduk.status_kawin_umur_tunggal_index",
            "Byxp2PxZK2" => "struktur_umur.penduduk.umur_tunggal_index",
            "7fKa0gsKtH" => "struktur_umur.penduduk.usia_muda_produkif_tua_index",
            "ObqRhsP78G" => "struktur_umur.penduduk.usia_sekolah_index",
            "IxmdS85aaN" => "pengaturan.wilayah_kelurahan.create_index",
            'aB3x9LpQrT' =>  "laporan_pelayanan.layanan_capil_index",
            '7yZk8WvNmD' =>  "laporan_pelayanan.layanan_dafduk_index",
            'kP9mY2qR7s' =>  "laporan_pelayanan.online.index",
            "7fK97qB2ax" =>  "laporan_pelayanan.layanan_ektp_index",
            "7x9Fk2pQ8R" => "laporan_pelayanan.layanan_perekaman_index"
        ];
        // Check if the $codeView exists in the $redirectView array
        if (isset($redirectView[$codeView])) {
            // Return the corresponding view
            return view($redirectView[$codeView]);
        }

        // Fallback for invalid $codeView (e.g., show a 404 page or redirect)
        return abort(404, 'View not found');
    }

    public function dataDashBoard()
    {
        $tahunSemester = config('dataArray.dataDashboard');
        //data
        $jumlahPenduduk = $this->penduduk($tahunSemester);
        $jumlahKepalaKeluarga = $this->kepalaKeluarga($tahunSemester);
        $jumlahPenduduk017 = $this->penduduk017($tahunSemester);
        $wajibKtp = $this->wajibKtp($tahunSemester);

        $top10Pekejaan = $this->top10Pekerjaan($tahunSemester);
        $pendidikan = $this->pendidikan($tahunSemester);
        $statusKawin = $this->statusKawin($tahunSemester);

        $kepemilikanKtp = $this->kepemilikanKtp($tahunSemester);
        $kepemilikanKk = $this->kepemilikanKk($tahunSemester);
        $kepemilikanAktaLahir = $this->kepemilikanAktaLahir($tahunSemester);
        $kepemilikanKia = $this->kepemilikanKia($tahunSemester);
        $kepemilikanKawin = $this->kepemilikanKawin($tahunSemester);
        $kepemilikanCerai = $this->kepemilikanCerai($tahunSemester);

        $pendudukKelompokUmur = $this->pendudukKelompokUmur($tahunSemester);
        $kepalaKeluargaKelompokUmur = $this->kepalaKeluargaKelompokUmur($tahunSemester);

        $dataResponse = [
            'penduduk' => $jumlahPenduduk,
            'kepala_keluarga' => $jumlahKepalaKeluarga,
            'penduduk_017' => $jumlahPenduduk017,
            'wajib_ktp' => $wajibKtp,
            'top10_pekerjaan' => $top10Pekejaan,
            'pendidikan' => $pendidikan,
            'status_kawin' => $statusKawin,
            'kepemilikan_ktp' => $kepemilikanKtp,
            'kepemilikan_kk' => $kepemilikanKk,
            'kepemilikan_akta_lahir' => $kepemilikanAktaLahir,
            'kepemilikan_kia' => $kepemilikanKia,
            'kepemilikan_kawin' => $kepemilikanKawin,
            'kepemilikan_cerai' => $kepemilikanCerai,
            'penduduk_kelompok_umur' => $pendudukKelompokUmur,
            'kepala_keluarga_kelompok_umur' => $kepalaKeluargaKelompokUmur
        ];
        return response()->json($dataResponse, 200);
    }

    // private function data dashboard
    private function penduduk($tahunSemester)
    {
        return JenisKelamin::where('tahun', $tahunSemester['tahun'])
            ->where('semester', $tahunSemester['semester'])->sum('jumlah');
    }
    private function kepalaKeluarga($tahunSemester)
    {
        return \App\Models\AgregatDKB\KepalaKeluarga\JenisKelamin::where('tahun', $tahunSemester['tahun'])
            ->where('semester', $tahunSemester['semester'])->sum('jumlah');
    }
    private function penduduk017($tahunSemester)
    {
        return \App\Models\Kepemilikan\KIA::where('tahun', $tahunSemester['tahun'])
            ->where('semester', $tahunSemester['semester'])->sum('jumlah_awal_jml');
    }
    private function wajibKtp($tahunSemester)
    {
        return \App\Models\Kepemilikan\Ktp::where('tahun', $tahunSemester['tahun'])
            ->where('semester', $tahunSemester['semester'])->sum('wajib_ktp_jml');
    }
    private function top10Pekerjaan($tahunSemester)
    {
        $fillable = config('dataArray.categoryJob');
        // Ekstrak kategori pekerjaan unik
        $categories = [];
        foreach ($fillable as $field) {
            $category = preg_replace('/(_l|_p)$/', '', $field);
            $categories[$category] = $category;
        }
        $categories = array_values($categories);

        // Buat query untuk setiap kategori
        $queries = [];
        foreach ($categories as $category) {
            $queries[] = DB::table('pekerjaan_penduduk')
                ->selectRaw("'{$category}' as pekerjaan")
                ->selectRaw("SUM(COALESCE({$category}_l, 0) + COALESCE({$category}_p, 0)) as total")
                ->where('tahun', $tahunSemester['tahun'])
                ->where('semester', $tahunSemester['semester']);
        }

        // Gabungkan semua query dengan UNION ALL
        $unionQuery = array_shift($queries);
        foreach ($queries as $query) {
            $unionQuery->unionAll($query);
        }

        // Ambil 5 teratas
        $topFive = DB::query()
            ->fromSub($unionQuery, 'sub')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        // Format nama pekerjaan agar lebih readable
        $topFive->transform(function ($item) {
            $item->pekerjaan = str_replace('_', ' ', ucwords($item->pekerjaan, '_'));
            return $item;
        });

        return $topFive;
    }
    private function pendidikan($tahunSemester)
    {
        return \App\Models\AgregatDKB\Pendidikan\JenisKelamin::select(
            DB::raw('SUM(tidak_blm_sekolah_jml) as tidak_blm_sekolah_jml'),
            DB::raw('SUM(belum_tamat_sd_sederajat_jml) as belum_tamat_sd_sederajat_jml'),
            DB::raw('SUM(tamat_sd_sederajat_jml) as tamat_sd_sederajat_jml'),
            DB::raw('SUM(sltp_sederajat_jml) as sltp_sederajat_jml'),
            DB::raw('SUM(slta_sederajat_jml) as slta_sederajat_jml'),
            DB::raw('SUM(diploma_i_ii_jml) as diploma_i_ii_jml'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_jml) as akademi_dipl_iii_s_muda_jml'),
            DB::raw('SUM(diploma_iv_strata_i_jml) as diploma_iv_strata_i_jml'),
            DB::raw('SUM(strata_ii_jml) as strata_ii_jml'),
            DB::raw('SUM(strata_iii_jml) as strata_iii_jml'),
        )
            ->where('semester', $tahunSemester['semester'])
            ->where('tahun', $tahunSemester['tahun'])
            ->first();
    }
    private function statusKawin($tahunSemester)
    {
        return \App\Models\AgregatDKB\StatusKawin\JenisKelamin::select(
            DB::raw('SUM(COALESCE(belum_kawin_lk, 0) + COALESCE(belum_kawin_pr, 0)) as belum_kawin'),
            DB::raw('SUM(COALESCE(kawin_lk, 0) + COALESCE(kawin_pr, 0)) as sudah_kawin'),
            DB::raw('SUM(COALESCE(cerai_hidup_lk, 0) + COALESCE(cerai_hidup_pr, 0)) as cerai_hidup'),
            DB::raw('SUM(COALESCE(cerai_mati_lk, 0) + COALESCE(cerai_mati_pr, 0)) as cerai_mati')

        )
            ->where('tahun', $tahunSemester['tahun'])
            ->where('semester', $tahunSemester['semester'])
            ->first();
    }
    private function kepemilikanKtp($tahunSemester)  {
        return \App\Models\Kepemilikan\Ktp::where('semester',$tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->sum('ktp_jml');
    }
    private function kepemilikanKk($tahunSemester) {
        return \App\Models\Kepemilikan\KartuKeluarga::where('semester',$tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->sum('memiliki_jml');
    }
    private function kepemilikanAktaLahir($tahunSemester) {
        return \App\Models\Kepemilikan\AktaKelahiran::where('semester',$tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->sum('memiliki_awal_jml');
    }
    private function kepemilikanKia($tahunSemester) {
        return \App\Models\Kepemilikan\KIA::where('semester',$tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->sum('memiliki_awal_jml');
    }
    private function kepemilikanKawin($tahunSemester) {
        return \App\Models\Kepemilikan\AktaKawin::where('semester',$tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->sum('memiliki_akta_kawin_jml');
    }
    private function kepemilikanCerai($tahunSemester) {
        return \App\Models\Kepemilikan\AktaCerai::where('semester',$tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->sum('memiliki_akta_cerai_jml');
    }

    //kelompok umur
    private function pendudukKelompokUmur($tahunSemester) {
        return \App\Models\StrukturUmur\Penduduk\KelompokUmur::select(
            DB::raw('SUM(00_04_tahun_jml) as 00_04_tahun_jml'),
            DB::raw('SUM(05_09_tahun_jml) as 05_09_tahun_jml'),
            DB::raw('SUM(10_14_tahun_jml) as 10_14_tahun_jml'),
            DB::raw('SUM(15_19_tahun_jml) as 15_19_tahun_jml'),
            DB::raw('SUM(20_24_tahun_jml) as 20_24_tahun_jml'),
            DB::raw('SUM(25_29_tahun_jml) as 25_29_tahun_jml'),
            DB::raw('SUM(30_34_tahun_jml) as 30_34_tahun_jml'),
            DB::raw('SUM(35_39_tahun_jml) as 35_39_tahun_jml'),
            DB::raw('SUM(40_44_tahun_jml) as 40_44_tahun_jml'),
            DB::raw('SUM(45_49_tahun_jml) as 45_49_tahun_jml'),
            DB::raw('SUM(50_54_tahun_jml) as 50_54_tahun_jml'),
            DB::raw('SUM(55_59_tahun_jml) as 55_59_tahun_jml'),
            DB::raw('SUM(60_64_tahun_jml) as 60_64_tahun_jml'),
            DB::raw('SUM(65_69_tahun_jml) as 65_69_tahun_jml'),
            DB::raw('SUM(70_74_tahun_jml) as 70_74_tahun_jml'),
            DB::raw('SUM(lebih_75_tahun_jml) as lebih_75_tahun_jml'),
        )
        ->where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->first();
    }
    private function kepalaKeluargaKelompokUmur($tahunSemester) {
        return \App\Models\StrukturUmur\KepalaKeluarga\KelompokUmur::select(
            DB::raw('SUM(00_04_tahun_jml) as 00_04_tahun_jml'),
            DB::raw('SUM(05_09_tahun_jml) as 05_09_tahun_jml'),
            DB::raw('SUM(10_14_tahun_jml) as 10_14_tahun_jml'),
            DB::raw('SUM(15_19_tahun_jml) as 15_19_tahun_jml'),
            DB::raw('SUM(20_24_tahun_jml) as 20_24_tahun_jml'),
            DB::raw('SUM(25_29_tahun_jml) as 25_29_tahun_jml'),
            DB::raw('SUM(30_34_tahun_jml) as 30_34_tahun_jml'),
            DB::raw('SUM(35_39_tahun_jml) as 35_39_tahun_jml'),
            DB::raw('SUM(40_44_tahun_jml) as 40_44_tahun_jml'),
            DB::raw('SUM(45_49_tahun_jml) as 45_49_tahun_jml'),
            DB::raw('SUM(50_54_tahun_jml) as 50_54_tahun_jml'),
            DB::raw('SUM(55_59_tahun_jml) as 55_59_tahun_jml'),
            DB::raw('SUM(60_64_tahun_jml) as 60_64_tahun_jml'),
            DB::raw('SUM(65_69_tahun_jml) as 65_69_tahun_jml'),
            DB::raw('SUM(70_74_tahun_jml) as 70_74_tahun_jml'),
            DB::raw('SUM(lebih_75_tahun_jml) as lebih_75_tahun_jml'),
        )
        ->where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])
        ->first();
    }

}
