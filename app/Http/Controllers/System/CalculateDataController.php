<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\AgregatDKB\KepalaKeluarga\Agama as KepalaKeluargaAgama;
use App\Models\AgregatDKB\KepalaKeluarga\JenisKelamin as KepalaKeluargaJenisKelamin;
use App\Models\AgregatDKB\KepalaKeluarga\Pekerjaan as KepalaKeluargaPekerjaan;
use App\Models\AgregatDKB\KepalaKeluarga\Pendidikan as KepalaKeluargaPendidikan;
use App\Models\AgregatDKB\KepalaKeluarga\StatusKawin as KepalaKeluargaStatusKawin;
use App\Models\AgregatDKB\Penduduk\Agama as PendudukAgama;
use App\Models\AgregatDKB\Penduduk\GolonganDarah as PendudukGolonganDarah;
use App\Models\AgregatDKB\Penduduk\HubunganKeluarga;
use App\Models\AgregatDKB\Penduduk\JenisKelamin as PendudukJenisKelamin;
use App\Models\AgregatDKB\Penduduk\Pekerjaan as PendudukPekerjaan;
use App\Models\AgregatDKB\StatusKawin\Agama as StatusKawinPendudukAgama;
use App\Models\AgregatDKB\StatusKawin\JenisKelamin as StatusKawinPendudukJenisKelamin;
use App\Models\AgregatDKB\StatusKawin\Pekerjaan as StatusKawinPendudukPekerjaan;
use App\Models\AgregatDKB\Pendidikan\JenisKelamin as PendidikanPendudukJenisKelamin;
use App\Models\AgregatDKB\Pendidikan\GolonganDarah as PendidikanPendudukJGolonganDarah;
use App\Models\AgregatDKB\Pendidikan\Pekerjaan as PendidikanPendudukPekerjaan;
use App\Models\AgregatDKB\Disabilitas\JenisKelamin as DisabilitasPendudukJenisKelamin;
use App\Models\AgregatDKB\Disabilitas\Pekerjaan as DisabilitasPendudukPekerjaan;
use App\Models\AgregatDKB\Disabilitas\Pendidikan as DisabilitasPendudukPendidikan;
use App\Models\Kepemilikan\AktaKelahiran as KepemilikanAktaKelahiran;
use App\Models\Kepemilikan\AktaKawin as KepemilikanAktaKawin;
use App\Models\Kepemilikan\AktaKawinAgama as KepemilikanAktaKawinAgama;
use App\Models\Kepemilikan\AktaCerai as KepemilikanAktaCerai;
use App\Models\Kepemilikan\AktaCeraiAgama as KepemilikanAktaCeraiAgama;
use App\Models\Kepemilikan\KIA as KepemilikanKia;
use App\Models\Kepemilikan\KartuKeluarga as KepemilikanKartuKeluarga;
use App\Models\Kepemilikan\Ktp as KepemilikanKtp;
use App\Models\LaporanKinerjaFormatPdak\Capil;
use App\Models\LaporanKinerjaFormatPdak\Dafduk;
use App\Models\StrukturUmur\Agama\KelompokUmur as KelompokUmurAgama;
use App\Models\StrukturUmur\Disabilitas\KelompokUmur as KelompokUmurDisabilitas;
use App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal as DisabilitasUmurTunggalPendidikan;
use App\Models\StrukturUmur\Disabilitas\UmurTunggal as DisabilitasUmurTunggal;
use App\Models\StrukturUmur\Disabilitas\UsiaSekolahKelompokUmur as DisabilitasUsiaSekolah;
use App\Models\StrukturUmur\GolonganDarah\KelompokUmur as GolonganDarahKelompokUmur;
use App\Models\StrukturUmur\GolonganDarah\UmurTunggal as GolonganDarahUmurTunggal;
use App\Models\StrukturUmur\KepalaKeluarga\KelompokUmur as KepalaKeluargaKelompokUmur;
use App\Models\StrukturUmur\KepalaKeluarga\UmurTunggal as KepalaKeluargaUmurTunggal;
use App\Models\StrukturUmur\KepalaKeluarga\StatusKawinKelompokUmur as KepalaKeluargaStausKawinKelompokUmur;
use App\Models\StrukturUmur\Penduduk\UmurTunggal as PendudukUmurTunggal;
use App\Models\StrukturUmur\Penduduk\StatusKawinUmurTunggal as PendudukStatusKawinUmurTunggal;
use App\Models\StrukturUmur\Penduduk\KelompokUmur as PendudukKelompokUmur;
use App\Models\StrukturUmur\Penduduk\StatusKawinKelompokUmur as PendudukStatusKawinKelompokUmur;
use App\Models\StrukturUmur\Penduduk\UsiaSekolah as PendudukUsiaSekolah;
use App\Models\StrukturUmur\Penduduk\UsiaMudaProduktifTua as PendudukUsiaMudaProduktifTua;
use App\services\ExternalApiService;
use App\services\KtpApiService;
use App\services\perekamanService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CalculateDataController extends Controller
{
    protected $apiService, $ktpApi, $perekamanApi;

    public function __construct(ExternalApiService $apiService, KtpApiService $ktpApi, perekamanService $perekamanApi)
    {
        $this->apiService = $apiService;
        $this->ktpApi = $ktpApi;
        $this->perekamanApi = $perekamanApi;
    }
    //calculate data DKB penduduk
    public function dataPendudukJenisKelamin($request)
    {
        $dataPerkelurahan = PendudukJenisKelamin::select([
            'jenis_kelamin_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_penduduk.semester', $request['semester'])
            ->where('jenis_kelamin_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukJenisKelamin::select(
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukJenisKelamin::select([
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_penduduk.semester', $request['semester'])
            ->where('jenis_kelamin_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPendudukAgama($request)
    {
        $dataPerkelurahan = PendudukAgama::select([
            'agama_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'agama_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('agama_penduduk.semester', $request['semester'])
            ->where('agama_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukAgama::select(
            DB::raw('SUM(islam_lk) as islam_lk'),
            DB::raw('SUM(islam_pr) as islam_pr'),
            DB::raw('SUM(islam_jml) as islam_jml'),
            DB::raw('SUM(katholik_lk) as katholik_lk'),
            DB::raw('SUM(katholik_pr) as katholik_pr'),
            DB::raw('SUM(katholik_jml) as katholik_jml'),
            DB::raw('SUM(kristen_lk) as kristen_lk'),
            DB::raw('SUM(kristen_pr) as kristen_pr'),
            DB::raw('SUM(kristen_jml) as kristen_jml'),
            DB::raw('SUM(hindu_lk) as hindu_lk'),
            DB::raw('SUM(hindu_pr) as hindu_pr'),
            DB::raw('SUM(hindu_jml) as hindu_jml'),
            DB::raw('SUM(budha_lk) as budha_lk'),
            DB::raw('SUM(budha_pr) as budha_pr'),
            DB::raw('SUM(budha_jml) as budha_jml'),
            DB::raw('SUM(konghucu_lk) as konghucu_lk'),
            DB::raw('SUM(konghucu_pr) as konghucu_pr'),
            DB::raw('SUM(konghucu_jml) as konghucu_jml'),
            DB::raw('SUM(kepercayaan_lk) as kepercayaan_lk'),
            DB::raw('SUM(kepercayaan_pr) as kepercayaan_pr'),
            DB::raw('SUM(kepercayaan_jml) as kepercayaan_jml'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukAgama::select([
            DB::raw('SUM(islam_lk) as islam_lk'),
            DB::raw('SUM(islam_pr) as islam_pr'),
            DB::raw('SUM(islam_jml) as islam_jml'),
            DB::raw('SUM(katholik_lk) as katholik_lk'),
            DB::raw('SUM(katholik_pr) as katholik_pr'),
            DB::raw('SUM(katholik_jml) as katholik_jml'),
            DB::raw('SUM(kristen_lk) as kristen_lk'),
            DB::raw('SUM(kristen_pr) as kristen_pr'),
            DB::raw('SUM(kristen_jml) as kristen_jml'),
            DB::raw('SUM(hindu_lk) as hindu_lk'),
            DB::raw('SUM(hindu_pr) as hindu_pr'),
            DB::raw('SUM(hindu_jml) as hindu_jml'),
            DB::raw('SUM(budha_lk) as budha_lk'),
            DB::raw('SUM(budha_pr) as budha_pr'),
            DB::raw('SUM(budha_jml) as budha_jml'),
            DB::raw('SUM(konghucu_lk) as konghucu_lk'),
            DB::raw('SUM(konghucu_pr) as konghucu_pr'),
            DB::raw('SUM(konghucu_jml) as konghucu_jml'),
            DB::raw('SUM(kepercayaan_lk) as kepercayaan_lk'),
            DB::raw('SUM(kepercayaan_pr) as kepercayaan_pr'),
            DB::raw('SUM(kepercayaan_jml) as kepercayaan_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'agama_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('agama_penduduk.semester', $request['semester'])
            ->where('agama_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPendudukGoldar($request)
    {
        $categoryBlood = config('dataArray.categoryBlood');
        $dataPerkelurahan = PendudukGolonganDarah::select([
            'golongan_darah_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'golongan_darah_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('golongan_darah_penduduk.semester', $request['semester'])
            ->where('golongan_darah_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukGolonganDarah::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukGolonganDarah::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'golongan_darah_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('golongan_darah_penduduk.semester', $request['semester'])
            ->where('golongan_darah_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPendudukHubKel($request)
    {
        $categoryRelationshipFamily = config('dataArray.categoryRelationshipFamily');
        $dataPerkelurahan = HubunganKeluarga::select([
            'hubungan_keluarga_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'hubungan_keluarga_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('hubungan_keluarga_penduduk.semester', $request['semester'])
            ->where('hubungan_keluarga_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = HubunganKeluarga::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryRelationshipFamily)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = HubunganKeluarga::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryRelationshipFamily),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'hubungan_keluarga_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('hubungan_keluarga_penduduk.semester', $request['semester'])
            ->where('hubungan_keluarga_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPendudukPekerjaan($request)
    {
        $categoryJob = config('dataArray.categoryJob');
        $dataPerkelurahan = PendudukPekerjaan::select([
            'pekerjaan_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_penduduk.semester', $request['semester'])
            ->where('pekerjaan_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_penduduk.semester', $request['semester'])
            ->where('pekerjaan_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // calculate data DKB kepala keluarga
    public function dataKepalaKeluargaAgama($request)
    {
        $categoryReligious = config('dataArray.categoryReligious');
        $dataPerkelurahan = KepalaKeluargaAgama::select([
            'agama_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'agama_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('agama_kepala_keluarga.semester', $request['semester'])
            ->where('agama_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligious)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligious),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'agama_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('agama_kepala_keluarga.semester', $request['semester'])
            ->where('agama_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepalaKeluargaJenisKelamin($request)
    {
        $dataPerkelurahan = KepalaKeluargaJenisKelamin::select([
            'jenis_kelamin_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_kepala_keluarga.semester', $request['semester'])
            ->where('jenis_kelamin_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaJenisKelamin::select(
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaJenisKelamin::select([
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_kepala_keluarga.semester', $request['semester'])
            ->where('jenis_kelamin_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepalaKeluargaPekerjaan($request)
    {
        $categoryJob = config('dataArray.categoryJob');
        $dataPerkelurahan = KepalaKeluargaPekerjaan::select([
            'pekerjaan_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_kepala_keluarga.semester', $request['semester'])
            ->where('pekerjaan_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_kepala_keluarga.semester', $request['semester'])
            ->where('pekerjaan_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepalaKeluargaPendidikan($request)
    {
        $categoryEducation = config('dataArray.categoryEducation');
        $dataPerkelurahan = KepalaKeluargaPendidikan::select([
            'pendidikan_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_kepala_keluarga.semester', $request['semester'])
            ->where('pendidikan_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducation)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducation),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_kepala_keluarga.semester', $request['semester'])
            ->where('pendidikan_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKelapaKeluargaStatusKawin($request)
    {
        $categoryMarriageStatus = config('dataArray.categoryMarriageStatus');
        $dataPerkelurahan = KepalaKeluargaStatusKawin::select([
            'status_kawin_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kepala_keluarga.semester', $request['semester'])
            ->where('status_kawin_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaStatusKawin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryMarriageStatus)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepalaKeluargaStatusKawin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryMarriageStatus),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kepala_keluarga.semester', $request['semester'])
            ->where('status_kawin_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // calculate data DKB Status Kawin
    public function dataStatusKawinAgama($request)
    {
        $categoryReligious = config('dataArray.categoryReligious');
        $dataPerkelurahan = StatusKawinPendudukAgama::select([
            'status_kawin_penduduk_agama.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_agama.semester', $request['semester'])
            ->where('status_kawin_penduduk_agama.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = StatusKawinPendudukAgama::select(
            array_merge(
                ['keterangan'], // Include 'keterangan'
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligious)
            )
        )
            ->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('keterangan') // Ensure grouping by 'keterangan'
            ->get();
        $dataPerkecamatan = StatusKawinPendudukAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligious),
                [
                    'mstr_kecamatan.nama as kecamatan_nama',
                    'status_kawin_penduduk_agama.keterangan as keterangan'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_agama.semester', $request['semester'])
            ->where('status_kawin_penduduk_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'status_kawin_penduduk_agama.keterangan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStatusKawinJenisKelamin($request)
    {
        $categoryMarriageStatus = config('dataArray.categoryMarriageStatus');
        $dataPerkelurahan = StatusKawinPendudukJenisKelamin::select([
            'status_kawin_penduduk_jenis_kelamin.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_jenis_kelamin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_jenis_kelamin.semester', $request['semester'])
            ->where('status_kawin_penduduk_jenis_kelamin.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = StatusKawinPendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryMarriageStatus)
            )
        )
            ->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = StatusKawinPendudukJenisKelamin::select(array_merge(
            array_map(function ($item) {
                return DB::raw("SUM($item) as $item");
            }, $categoryMarriageStatus),
            [
                'mstr_kecamatan.nama as kecamatan_nama',
            ]
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_jenis_kelamin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_jenis_kelamin.semester', $request['semester'])
            ->where('status_kawin_penduduk_jenis_kelamin.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStatusKawinPekerjaan($request)
    {
        $categoryJob = config('dataArray.categoryJob');
        $dataPerkelurahan = StatusKawinPendudukPekerjaan::select([
            'status_kawin_penduduk_pekerjaan.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_pekerjaan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_pekerjaan.semester', $request['semester'])
            ->where('status_kawin_penduduk_pekerjaan.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = StatusKawinPendudukPekerjaan::select(
            array_merge(
                ['keterangan'], // Include 'keterangan'
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('keterangan') // Ensure grouping by 'keterangan'
            ->get();
        $dataPerkecamatan = StatusKawinPendudukPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob),
                [
                    'mstr_kecamatan.nama as kecamatan_nama',
                    'status_kawin_penduduk_pekerjaan.keterangan as keterangan'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_pekerjaan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_pekerjaan.semester', $request['semester'])
            ->where('status_kawin_penduduk_pekerjaan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'status_kawin_penduduk_pekerjaan.keterangan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // calculate data DKB Pendidikan
    public function dataPendidikanPendudukJenisKelamin($request)
    {
        $categoryEducation = config('dataArray.categoryEducation');
        $dataPerkelurahan = PendidikanPendudukJenisKelamin::select([
            'jenis_kelamin_pendidikan.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_pendidikan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_pendidikan.semester', $request['semester'])
            ->where('jenis_kelamin_pendidikan.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendidikanPendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducation)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendidikanPendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducation),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_pendidikan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_pendidikan.semester', $request['semester'])
            ->where('jenis_kelamin_pendidikan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataPendidikanPekerjaan($request)
    {
        $categoryJob = config('dataArray.categoryJob');
        $dataPerkelurahan = PendidikanPendudukPekerjaan::select([
            'pendidikan_penduduk_pekerjaan.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_penduduk_pekerjaan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_penduduk_pekerjaan.semester', $request['semester'])
            ->where('pendidikan_penduduk_pekerjaan.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendidikanPendudukPekerjaan::select(
            array_merge(
                ['pendidikan'], // Include 'pendidikan'
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('pendidikan') // Ensure grouping by 'pendidikan'
            ->get();
        $dataPerkecamatan = PendidikanPendudukPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob),
                [
                    'pendidikan_penduduk_pekerjaan.pendidikan as pendidikan',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_penduduk_pekerjaan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_penduduk_pekerjaan.semester', $request['semester'])
            ->where('pendidikan_penduduk_pekerjaan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'pendidikan_penduduk_pekerjaan.pendidikan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPendidikanGolonganDarah($request)
    {
        $categoryBlood = config('dataArray.categoryBlood');
        $dataPerkelurahan = PendidikanPendudukJGolonganDarah::select([
            'golongan_darah_pendidikan.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'golongan_darah_pendidikan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('golongan_darah_pendidikan.semester', $request['semester'])
            ->where('golongan_darah_pendidikan.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendidikanPendudukJGolonganDarah::select(
            array_merge(
                ['keterangan'], // Include 'keterangan'
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('keterangan')
            ->get();
        $dataPerkecamatan = PendidikanPendudukJGolonganDarah::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood),
                [
                    'golongan_darah_pendidikan.keterangan as keterangan',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'golongan_darah_pendidikan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('golongan_darah_pendidikan.semester', $request['semester'])
            ->where('golongan_darah_pendidikan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'golongan_darah_pendidikan.keterangan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // calculate data DKB disabilitas
    public function dataDisabilitasJenisKelamin($request)
    {
        $categoryDisabilites = config('dataArray.categoryDisabilities');
        $dataPerkelurahan = DisabilitasPendudukJenisKelamin::select([
            'jenis_kelamin_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_disabilitas.semester', $request['semester'])
            ->where('jenis_kelamin_disabilitas.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasPendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryDisabilites)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = DisabilitasPendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryDisabilites),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_disabilitas.semester', $request['semester'])
            ->where('jenis_kelamin_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataDisabilitasPekerjaan($request)
    {
        $categoryJob = config('dataArray.categoryJob');
        $dataPerkelurahan = DisabilitasPendudukPekerjaan::select([
            'pekerjaan_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_disabilitas.semester', $request['semester'])
            ->where('pekerjaan_disabilitas.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasPendudukPekerjaan::select(
            array_merge(
                ['keterangan'], // Include 'keterangan'
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('keterangan')
            ->get();
        $dataPerkecamatan = DisabilitasPendudukPekerjaan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryJob),
                [
                    'pekerjaan_disabilitas.keterangan as keterangan',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_disabilitas.semester', $request['semester'])
            ->where('pekerjaan_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'pekerjaan_disabilitas.keterangan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataDisabilitasPendidikan($request)
    {
        $categoryEducation = config('dataArray.categoryEducation');
        $dataPerkelurahan = DisabilitasPendudukPendidikan::select([
            'pendidikan_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_disabilitas.semester', $request['semester'])
            ->where('pendidikan_disabilitas.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasPendudukPendidikan::select(
            array_merge(
                ['keterangan'], // Include 'keterangan'
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducation)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('keterangan')
            ->get();
        $dataPerkecamatan = DisabilitasPendudukPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducation),
                [
                    'pendidikan_disabilitas.keterangan as keterangan',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_disabilitas.semester', $request['semester'])
            ->where('pendidikan_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'pendidikan_disabilitas.keterangan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // calculate data DKB kepemilikan akta kelahiran
    public function dataKepemilikanAktaKelahiran($request)
    {
        $categoryAktaKelahiranOwnerShip = config('dataArray.categoryAktaKelahiranOwnerShip');
        $dataPerkelurahan = KepemilikanAktaKelahiran::select(
            array_merge(
                [
                    'mstr_kelurahan.nama as kelurahan_nama',
                    'mstr_kecamatan.nama as kecamatan_nama',
                    DB::raw('COALESCE(SUM(wajib_akta_awal_jml), 0) as total_wajib_awal'),
                    DB::raw('COALESCE(SUM(memiliki_awal_jml), 0) as total_memiliki_awal'),
                    DB::raw('COALESCE(SUM(wajib_akta_dinamis_jml), 0) as total_wajib_dinamis'),
                    DB::raw('COALESCE(SUM(memiliki_dinamis_jml), 0) as total_memiliki_dinamis'),
                    DB::raw('IF(SUM(wajib_akta_awal_jml) = 0, 0, (SUM(memiliki_awal_jml) / SUM(wajib_akta_awal_jml)) * 100) as persen_awal'),
                    DB::raw('IF(SUM(wajib_akta_dinamis_jml) = 0, 0, (SUM(memiliki_dinamis_jml) / SUM(wajib_akta_dinamis_jml)) * 100) as persen_dinamis'),
                    DB::raw("
                        CASE
                            WHEN keterangan = 1 THEN 'Semua Usia'
                            WHEN keterangan = 2 THEN '0-1 Tahun'
                            WHEN keterangan = 3 THEN '0-4 Tahun'
                            WHEN keterangan = 4 THEN '0-5 Tahun'
                            WHEN keterangan = 5 THEN '0-18 Tahun Kurang 1 Hari'
                            ELSE 'Tidak Diketahui'
                        END as keterangan
                    ")
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryAktaKelahiranOwnerShip)
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kelahiran.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kelahiran.semester', $request['semester'])
            ->where('akta_kelahiran.tahun', $request['tahun'])
            ->where('akta_kelahiran.keterangan', $request['keterangan'])
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode', 'keterangan')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();

        $dataKeseluruhan = KepemilikanAktaKelahiran::select(
            array_merge(
                [
                    DB::raw('COALESCE(SUM(wajib_akta_awal_jml), 0) as total_wajib_awal'),
                    DB::raw('COALESCE(SUM(memiliki_awal_jml), 0) as total_memiliki_awal'),
                    DB::raw('COALESCE(SUM(wajib_akta_dinamis_jml), 0) as total_wajib_dinamis'),
                    DB::raw('COALESCE(SUM(memiliki_dinamis_jml), 0) as total_memiliki_dinamis'),
                    DB::raw('IF(SUM(wajib_akta_awal_jml) = 0, 0, (SUM(memiliki_awal_jml) / SUM(wajib_akta_awal_jml)) * 100) as persen_awal'),
                    DB::raw('IF(SUM(wajib_akta_dinamis_jml) = 0, 0, (SUM(memiliki_dinamis_jml) / SUM(wajib_akta_dinamis_jml)) * 100) as persen_dinamis'),
                    DB::raw("
                CASE
                        WHEN keterangan = 1 THEN 'Semua Usia'
                            WHEN keterangan = 2 THEN '0-1 Tahun'
                            WHEN keterangan = 3 THEN '0-4 Tahun'
                            WHEN keterangan = 4 THEN '0-5 Tahun'
                            WHEN keterangan = 5 THEN '0-18 Tahun Kurang 1 Hari'
                    ELSE 'Tidak Diketahui'
                END as keterangan
            ")
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryAktaKelahiranOwnerShip)
            )
        )
            ->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('keterangan', $request['keterangan'])
            ->groupBy('keterangan')
            ->get();
        $dataPerkecamatan = KepemilikanAktaKelahiran::select(
            array_merge(
                [
                    'mstr_kecamatan.nama as kecamatan_nama',
                    DB::raw('COALESCE(SUM(wajib_akta_awal_jml), 0) as total_wajib_awal'),
                    DB::raw('COALESCE(SUM(memiliki_awal_jml), 0) as total_memiliki_awal'),
                    DB::raw('COALESCE(SUM(wajib_akta_dinamis_jml), 0) as total_wajib_dinamis'),
                    DB::raw('COALESCE(SUM(memiliki_dinamis_jml), 0) as total_memiliki_dinamis'),
                    DB::raw('IF(SUM(wajib_akta_awal_jml) = 0, 0, (SUM(memiliki_awal_jml) / SUM(wajib_akta_awal_jml)) * 100) as persen_awal'),
                    DB::raw('IF(SUM(wajib_akta_dinamis_jml) = 0, 0, (SUM(memiliki_dinamis_jml) / SUM(wajib_akta_dinamis_jml)) * 100) as persen_dinamis'),
                    DB::raw("
                            CASE
                                WHEN keterangan = 1 THEN 'Semua Usia'
                            WHEN keterangan = 2 THEN '0-1 Tahun'
                            WHEN keterangan = 3 THEN '0-4 Tahun'
                            WHEN keterangan = 4 THEN '0-5 Tahun'
                            WHEN keterangan = 5 THEN '0-18 Tahun Kurang 1 Hari'
                                ELSE 'Tidak Diketahui'
                            END as keterangan
                        ")
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryAktaKelahiranOwnerShip)
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kelahiran.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kelahiran.semester', $request['semester'])
            ->where('akta_kelahiran.tahun', $request['tahun'])
            ->where('akta_kelahiran.keterangan', $request['keterangan'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'keterangan')
            ->orderBy('mstr_kecamatan.kode', 'ASC')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanAktaPerkawinan($request)
    {
        $attributTable = [
            'wajib_akta_kawin_lk',
            'wajib_akta_kawin_pr',
            'wajib_akta_kawin_jml',
            'memiliki_akta_kawin_lk',
            'memiliki_akta_kawin_pr',
            'memiliki_akta_kawin_jml',
            'belum_memiliki_akta_kawin_lk',
            'belum_memiliki_akta_kawin_pr',
            'belum_memiliki_akta_kawin_jml',
        ];
        $dataPerkelurahan = KepemilikanAktaKawin::select(array_merge(
            [
                'mstr_kelurahan.nama as kelurahan_nama',
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(wajib_akta_kawin_jml) = 0, 0, (SUM(memiliki_akta_kawin_jml) / SUM(wajib_akta_kawin_jml)) * 100) as persen_memiliki'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin.semester', $request['semester'])
            ->where('akta_kawin.tahun', $request['tahun'])
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanAktaKawin::select(
            array_merge(
                [
                    // DB::raw('COALESCE(SUM(wajib_akta_kawin_jml), 0) as wajib_akta_kawin_jml_sys'),
                    // DB::raw('COALESCE(SUM(memiliki_akta_kawin_jml), 0) as memiliki_akta_kawin_jml_sys'),
                    DB::raw('IF(SUM(wajib_akta_kawin_jml) = 0, 0, (SUM(memiliki_akta_kawin_jml) / SUM(wajib_akta_kawin_jml)) * 100) as persen_memiliki'),
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();

        $dataPerkecamatan = KepemilikanAktaKawin::select(array_merge(
            [
                'mstr_kecamatan.nama as kecamatan_nama',
                // DB::raw('COALESCE(SUM(wajib_akta_kawin_jml), 0) as wajib_akta_kawin_jml_sys'),
                // DB::raw('COALESCE(SUM(memiliki_akta_kawin_jml), 0) as memiliki_akta_kawin_jml_sys'),
                DB::raw('IF(SUM(wajib_akta_kawin_jml) = 0, 0, (SUM(memiliki_akta_kawin_jml) / SUM(wajib_akta_kawin_jml)) * 100) as persen_memiliki'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin.semester', $request['semester'])
            ->where('akta_kawin.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanAktaPerkawinanAgama($request)
    {
        $categoryReligiosOwnerShip = config('dataArray.categoryReligiosOwnerShip');
        $dataPerkelurahan = KepemilikanAktaKawinAgama::select([
            'akta_kawin_agama.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin_agama.semester', $request['semester'])
            ->where('akta_kawin_agama.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanAktaKawinAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligiosOwnerShip)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepemilikanAktaKawinAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligiosOwnerShip),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin_agama.semester', $request['semester'])
            ->where('akta_kawin_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanAktaCerai($request)
    {
        $attributTable = [
            'wajib_akta_cerai_lk',
            'wajib_akta_cerai_pr',
            'wajib_akta_cerai_jml',
            'memiliki_akta_cerai_lk',
            'memiliki_akta_cerai_pr',
            'memiliki_akta_cerai_jml',
            'belum_memiliki_akta_cerai_lk',
            'belum_memiliki_akta_cerai_pr',
            'belum_memiliki_akta_cerai_jml',
        ];
        $dataPerkelurahan = KepemilikanAktaCerai::select(array_merge(
            [
                'mstr_kelurahan.nama as kelurahan_nama',
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(wajib_akta_cerai_jml) = 0, 0, (SUM(memiliki_akta_cerai_jml) / SUM(wajib_akta_cerai_jml)) * 100) as persen_memiliki'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_cerai.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_cerai.semester', $request['semester'])
            ->where('akta_cerai.tahun', $request['tahun'])
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanAktaCerai::select(
            array_merge(
                [
                    DB::raw('IF(SUM(wajib_akta_cerai_jml) = 0, 0, (SUM(memiliki_akta_cerai_jml) / SUM(wajib_akta_cerai_jml)) * 100) as persen_memiliki'),
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepemilikanAktaCerai::select(
            array_merge(
                [
                    'mstr_kecamatan.nama as kecamatan_nama',
                    DB::raw('IF(SUM(wajib_akta_cerai_jml) = 0, 0, (SUM(memiliki_akta_cerai_jml) / SUM(wajib_akta_cerai_jml)) * 100) as persen_memiliki'),
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_cerai.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_cerai.semester', $request['semester'])
            ->where('akta_cerai.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanAktaCeraiAgama($request)
    {
        $categoryReligiosOwnerShip = config('dataArray.categoryReligiosOwnerShip');
        $dataPerkelurahan = KepemilikanAktaCeraiAgama::select([
            'akta_cerai_agama.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_cerai_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_cerai_agama.semester', $request['semester'])
            ->where('akta_cerai_agama.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanAktaCeraiAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligiosOwnerShip)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepemilikanAktaCeraiAgama::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryReligiosOwnerShip),
                ['mstr_kecamatan.nama as kecamatan_nama']
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_cerai_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_cerai_agama.semester', $request['semester'])
            ->where('akta_cerai_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanKia($request)
    {
        $categoryKiaOwnerShip = config('dataArray.categoryKiaOwnerShip');
        $dataPerkelurahan = KepemilikanKia::select(array_merge(
            [
                'mstr_kelurahan.nama as kelurahan_nama',
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(jumlah_awal_jml) = 0, 0, (SUM(memiliki_awal_jml) / SUM(jumlah_awal_jml)) * 100) as persen_awal'),
                DB::raw('IF(SUM(jumlah_dinamis_ttl) = 0, 0, (SUM(memiliki_dinamis_jml) / SUM(jumlah_dinamis_ttl)) * 100) as persen_dinamis'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryKiaOwnerShip)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kia.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kia.semester', $request['semester'])
            ->where('kia.tahun', $request['tahun'])
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanKia::select(
            array_merge(
                [
                    DB::raw('IF(SUM(jumlah_awal_jml) = 0, 0, (SUM(memiliki_awal_jml) / SUM(jumlah_awal_jml)) * 100) as persen_awal'),
                    DB::raw('IF(SUM(jumlah_dinamis_ttl) = 0, 0, (SUM(memiliki_dinamis_jml) / SUM(jumlah_dinamis_ttl)) * 100) as persen_dinamis'),
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryKiaOwnerShip)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepemilikanKia::select(array_merge(
            [
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(jumlah_awal_jml) = 0, 0, (SUM(memiliki_awal_jml) / SUM(jumlah_awal_jml)) * 100) as persen_awal'),
                DB::raw('IF(SUM(jumlah_dinamis_ttl) = 0, 0, (SUM(memiliki_dinamis_jml) / SUM(jumlah_dinamis_ttl)) * 100) as persen_dinamis'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryKiaOwnerShip)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kia.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kia.semester', $request['semester'])
            ->where('kia.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanKartuKeluarga($request)
    {
        $attributTable = [
            'kk_lk',
            'kk_pr',
            'kk_jml',
            'memiliki_lk',
            'memiliki_pr',
            'memiliki_jml',
            'belum_memiliki_lk',
            'belum_memiliki_pr',
            'belum_memiliki_jml',
        ];
        $dataPerkelurahan = KepemilikanKartuKeluarga::select(array_merge(
            [
                'mstr_kelurahan.nama as kelurahan_nama',
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(kk_jml) = 0, 0, (SUM(memiliki_jml) / SUM(kk_jml)) * 100) as persen_memiliki'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kartu_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kartu_keluarga.semester', $request['semester'])
            ->where('kartu_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanKartuKeluarga::select(
            array_merge(
                [
                    DB::raw('IF(SUM(kk_jml) = 0, 0, (SUM(memiliki_jml) / SUM(kk_jml)) * 100) as persen_memiliki'),
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepemilikanKartuKeluarga::select(array_merge(
            [
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(kk_jml) = 0, 0, (SUM(memiliki_jml) / SUM(kk_jml)) * 100) as persen_memiliki'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kartu_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kartu_keluarga.semester', $request['semester'])
            ->where('kartu_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataKepemilikanKTP($request)
    {
        $attributTable = [
            'wajib_ktp_lk',
            'wajib_ktp_pr',
            'wajib_ktp_jml',
            'rekam_lk',
            'rekam_pr',
            'rekam_jml',
            'belum_rekam_lk',
            'belum_rekam_pr',
            'belum_rekam_jml',
            'ktp_pr',
            'ktp_lk',
            'ktp_jml',
            'blm_ktp_lk',
            'blm_ktp_pr',
            'blm_ktp_jml',
        ];
        $dataPerkelurahan = KepemilikanKtp::select(array_merge(
            [
                'mstr_kelurahan.nama as kelurahan_nama',
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(rekam_jml) = 0, 0, (SUM(ktp_jml) / SUM(rekam_jml)) * 100) as persen_memiliki_ktp'),
                DB::raw('IF(SUM(wajib_ktp_jml) = 0, 0, (SUM(rekam_jml) / SUM(wajib_ktp_jml)) * 100) as persen_sudah_rekam'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'ktp.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('ktp.semester', $request['semester'])
            ->where('ktp.tahun', $request['tahun'])
            // ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama')
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanKtp::select(
            array_merge(
                [
                    DB::raw('IF(SUM(rekam_jml) = 0, 0, (SUM(ktp_jml) / SUM(rekam_jml)) * 100) as persen_memiliki_ktp'),
                    DB::raw('IF(SUM(wajib_ktp_jml) = 0, 0, (SUM(rekam_jml) / SUM(wajib_ktp_jml)) * 100) as persen_sudah_rekam'),
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepemilikanKtp::select(array_merge(
            [
                'mstr_kecamatan.nama as kecamatan_nama',
                DB::raw('IF(SUM(rekam_jml) = 0, 0, (SUM(ktp_jml) / SUM(rekam_jml)) * 100) as persen_memiliki_ktp'),
                DB::raw('IF(SUM(wajib_ktp_jml) = 0, 0, (SUM(rekam_jml) / SUM(wajib_ktp_jml)) * 100) as persen_sudah_rekam'),
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $attributTable)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'ktp.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('ktp.semester', $request['semester'])
            ->where('ktp.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurAgamaKelompokUmur($request)
    {
        $categoryReligious = config('dataArray.categoryReligious');
        $dataPerkelurahan = KelompokUmurAgama::select([
            'kelompok_umur_agama.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_agama.semester', $request['semester'])
            ->where('kelompok_umur_agama.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KelompokUmurAgama::select(
            array_merge(
                [
                    'kelompok_umur'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryReligious)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('kelompok_umur_agama.kelompok_umur')
            ->get();
        $dataPerkecamatan = KelompokUmurAgama::select(array_merge(
            [
                'kelompok_umur_agama.kelompok_umur',
                'mstr_kecamatan.nama as kecamatan_nama'
            ],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryReligious)
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_agama.semester', $request['semester'])
            ->where('kelompok_umur_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'kelompok_umur_agama.kelompok_umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurDisabilitasKelompokUmur($request)
    {
        $categoryDisabilites = config('dataArray.categoryDisabilities');
        $dataPerkelurahan = KelompokUmurDisabilitas::select([
            'kelompok_umur_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_disabilitas.semester', $request['semester'])
            ->where('kelompok_umur_disabilitas.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KelompokUmurDisabilitas::select(
            array_merge(
                [
                    'kelompok_umur'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryDisabilites)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('kelompok_umur_disabilitas.kelompok_umur')
            ->get();
        $dataPerkecamatan = KelompokUmurDisabilitas::select(
            array_merge(
                [
                    'kelompok_umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryDisabilites)
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_disabilitas.semester', $request['semester'])
            ->where('kelompok_umur_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'kelompok_umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurDisabilitasPendidikan($request)
    {
        $categoryEducationDisabilites = config('dataArray.categoryEducationDisabilites');
        $dataPerkelurahan = DisabilitasUmurTunggalPendidikan::select([
            'pendidikan_umur_tunggal_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_umur_tunggal_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('pendidikan_umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasUmurTunggalPendidikan::select(
            array_merge(
                [
                    'umur'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryEducationDisabilites)
            )
        )
            ->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('umur')
            ->get();
        $dataPerkecamatan = DisabilitasUmurTunggalPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducationDisabilites),
                [
                    'pendidikan_umur_tunggal_disabilitas.umur as umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_umur_tunggal_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('pendidikan_umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataKeseluruhan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // belum set range umur
    public function dataStrukturUmurDisabilitasUmurTunggal($request)
    {
        $categoryDisabilites = config('dataArray.categoryDisabilities');
        $dataPerkelurahan = DisabilitasUmurTunggal::select([
            'umur_tunggal_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasUmurTunggal::select(
            array_merge(
                [
                    'umur'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryDisabilites)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('umur')
            ->get();

        $dataPerkecamatan = DisabilitasUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryDisabilites),
                [
                    'umur_tunggal_disabilitas.umur as umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTilte' => $dataTitle], 200);
    }
    public function dataStrukturUmurDisabilitasUsiaSekolah($request)
    {
        $categoryAgeSchollDisabilities = config('dataArray.categoryAgeSchollDisabilities');
        $dataPerkelurahan = DisabilitasUsiaSekolah::select([
            'usia_sekolah_kelompok_umur_disabilitas.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_sekolah_kelompok_umur_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_sekolah_kelompok_umur_disabilitas.semester', $request['semester'])
            ->where('usia_sekolah_kelompok_umur_disabilitas.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasUsiaSekolah::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeSchollDisabilities)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = DisabilitasUsiaSekolah::select(array_merge(
            array_map(function ($item) {
                return DB::raw("SUM($item) as $item");
            }, $categoryAgeSchollDisabilities),
            [
                'mstr_kecamatan.nama as kecamatan_nama'
            ]
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_sekolah_kelompok_umur_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_sekolah_kelompok_umur_disabilitas.semester', $request['semester'])
            ->where('usia_sekolah_kelompok_umur_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurGolonganDarahKelompokUmur($request)
    {
        $categoryBlood = config('dataArray.categoryBlood');
        $dataPerkelurahan = GolonganDarahKelompokUmur::select([
            'kelompok_umur_golongan_darah.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_golongan_darah.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_golongan_darah.semester', $request['semester'])
            ->where('kelompok_umur_golongan_darah.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = GolonganDarahKelompokUmur::select(
            array_merge(
                [
                    'kelompok_umur_golongan_darah.kelompok_umur as kelompok_umur'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryBlood)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('kelompok_umur')
            ->get();
        $dataPerkecamatan = GolonganDarahKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood),
                [
                    'kelompok_umur_golongan_darah.kelompok_umur as kelompok_umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_golongan_darah.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_golongan_darah.semester', $request['semester'])
            ->where('kelompok_umur_golongan_darah.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'kelompok_umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // belum set range umur
    public function dataStrukturUmurGolonganDarahUmurTunggal($request)
    {
        $categoryBlood = config('dataArray.categoryBlood');
        $dataPerkelurahan = GolonganDarahUmurTunggal::select([
            'umur_tunggal_golongan_darah.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_golongan_darah.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_golongan_darah.semester', $request['semester'])
            ->where('umur_tunggal_golongan_darah.tahun', $request['tahun'])
            ->where('umur_tunggal_golongan_darah.umur', $request['umur'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = GolonganDarahUmurTunggal::select(

            array_merge(
                [
                    'umur'
                ],
                array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryBlood)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('umur_tunggal_golongan_darah.umur', $request['umur'])
            ->groupBy('umur')
            ->get();
        $dataPerkecamatan = GolonganDarahUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood),
                [
                    'umur_tunggal_golongan_darah.umur as umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_golongan_darah.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_golongan_darah.semester', $request['semester'])
            ->where('umur_tunggal_golongan_darah.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurKepalaKeluargaKelompokUmur($request)
    {
        $categoryAgeGroup = config('dataArray.categoryAgeGroup');

        $dataPerkelurahan = KepalaKeluargaKelompokUmur::select([
            'kelompok_umur_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_kepala_keluarga.semester', $request['semester'])
            ->where('kelompok_umur_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroup)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepalaKeluargaKelompokUmur::select(array_merge(
            array_map(function ($item) {
                return DB::raw("SUM($item) as $item");
            }, $categoryAgeGroup),
            [
                'mstr_kecamatan.nama as kecamatan_nama'
            ]
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_kepala_keluarga.semester', $request['semester'])
            ->where('kelompok_umur_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // belum set range umur
    public function dataStrukturUmurKepalaKeluargaUmurTunggal($request)
    {
        $dataPerkelurahan = KepalaKeluargaUmurTunggal::select([
            'umur_tunggal_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_kepala_keluarga.semester', $request['semester'])
            ->where('umur_tunggal_kepala_keluarga.tahun', $request['tahun'])
            ->where('umur_tunggal_kepala_keluarga.umur', $request['umur'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaUmurTunggal::select(
            DB::raw('sum(lk) as lk'),
            DB::raw('sum(pr) as pr'),
            DB::raw('sum(jumlah) as jumlah'),
            'umur'
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('umur')
            ->get();
        $dataPerkecamatan = KepalaKeluargaUmurTunggal::select([
            DB::raw('sum(lk) as lk'),
            DB::raw('sum(pr) as pr'),
            DB::raw('sum(jumlah) as jumlah'),
            'mstr_kecamatan.nama as kecamatan_nama',
            'umur'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_kepala_keluarga.semester', $request['semester'])
            ->where('umur_tunggal_kepala_keluarga.tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurKepalaKeluargaStatusKawin($request)
    {
        $categoryAgeGroupMarriageStatus = config('dataArray.categoryAgeGroupMarriageStatus');
        $dataPerkelurahan = KepalaKeluargaStausKawinKelompokUmur::select([
            'status_kawin_kelompok_umur_kepala_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kelompok_umur_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kelompok_umur_kepala_keluarga.semester', $request['semester'])
            ->where('status_kawin_kelompok_umur_kepala_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaStausKawinKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroupMarriageStatus)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = KepalaKeluargaStausKawinKelompokUmur::select(array_merge(
            array_map(function ($item) {
                return DB::raw("SUM($item) as $item");
            }, $categoryAgeGroupMarriageStatus),
            [
                'mstr_kecamatan.nama as kecamatan_nama'
            ]
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kelompok_umur_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kelompok_umur_kepala_keluarga.semester', $request['semester'])
            ->where('status_kawin_kelompok_umur_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // belum set range umur
    public function dataStrukturUmurPendudukUmurTunggal($request)
    {
        $dataPerkelurahan = PendudukUmurTunggal::select([
            'umur_tunggal_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_penduduk.semester', $request['semester'])
            ->where('umur_tunggal_penduduk.tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukUmurTunggal::select(
            DB::raw('sum(lk) as lk'),
            DB::raw('sum(pr) as pr'),
            DB::raw('sum(jumlah) as jumlah'),
            'umur'
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('umur')
            ->get();
        $dataPerkecamatan = PendudukUmurTunggal::select([
            DB::raw('sum(lk) as lk'),
            DB::raw('sum(pr) as pr'),
            DB::raw('sum(jumlah) as jumlah'),
            'umur',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_penduduk.semester', $request['semester'])
            ->where('umur_tunggal_penduduk.tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    // belum set range umur
    public function dataStrukturUmurPendudukStatuKawinUmurTunggal($request)
    {
        $categoryMarriageStatus = config('dataArray.categoryMarriageStatus');
        $dataPerkelurahan = PendudukStatusKawinUmurTunggal::select([
            'status_kawin_umur_tunggal_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_umur_tunggal_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_umur_tunggal_penduduk.semester', $request['semester'])
            ->where('status_kawin_umur_tunggal_penduduk.tahun', $request['tahun'])
            ->where('status_kawin_umur_tunggal_penduduk.umur', $request['umur'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukStatusKawinUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryMarriageStatus),
                ['status_kawin_umur_tunggal_penduduk.umur']
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->where('umur', $request['umur'])
            ->groupBy('umur')
            ->get();
        $dataPerkecamatan = PendudukStatusKawinUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryMarriageStatus),
                [
                    'umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_umur_tunggal_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_umur_tunggal_penduduk.semester', $request['semester'])
            ->where('status_kawin_umur_tunggal_penduduk.tahun', $request['tahun'])
            ->where('status_kawin_umur_tunggal_penduduk.umur', $request['umur'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'umur')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataSturukUmurPendudukKelompokUmur($request)
    {
        $categoryAgeGroup = config('dataArray.categoryAgeGroup');
        $dataPerkelurahan = PendudukKelompokUmur::select([
            'kelompok_umur_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_penduduk.semester', $request['semester'])
            ->where('kelompok_umur_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroup)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = PendudukKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroup),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_penduduk.semester', $request['semester'])
            ->where('kelompok_umur_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurPendudukStatusKawinKelompokUmur($request)
    {
        $categoryAgeGroupMarriageStatus = config('dataArray.categoryAgeGroupMarriageStatus');
        $dataPerkelurahan = PendudukStatusKawinKelompokUmur::select([
            'status_kawin_kelompok_umur_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kelompok_umur_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kelompok_umur_penduduk.semester', $request['semester'])
            ->where('status_kawin_kelompok_umur_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukStatusKawinKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroupMarriageStatus)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = PendudukStatusKawinKelompokUmur::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroupMarriageStatus),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kelompok_umur_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kelompok_umur_penduduk.semester', $request['semester'])
            ->where('status_kawin_kelompok_umur_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurPendudukUsiaSekolah($request)
    {
        $dataPerkelurahan = PendudukUsiaSekolah::select([
            'usia_sekolah_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_sekolah_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_sekolah_penduduk.semester', $request['semester'])
            ->where('usia_sekolah_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukUsiaSekolah::select(
            DB::raw('sum(usia_sd_sederajat) as usia_sd_sederajat'),
            DB::raw('sum(usia_sltp_sederajat) as usia_sltp_sederajat'),
            DB::raw('sum(usia_slta_sederajat) as usia_slta_sederajat'),
            DB::raw('sum(usia_perguruan_tinggi) as usia_perguruan_tinggi'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = PendudukUsiaSekolah::select([
            DB::raw('sum(usia_sd_sederajat) as usia_sd_sederajat'),
            DB::raw('sum(usia_sltp_sederajat) as usia_sltp_sederajat'),
            DB::raw('sum(usia_slta_sederajat) as usia_slta_sederajat'),
            DB::raw('sum(usia_perguruan_tinggi) as usia_perguruan_tinggi'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_sekolah_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_sekolah_penduduk.semester', $request['semester'])
            ->where('usia_sekolah_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataStrukturUmurPendudukUsiaMudaProduktifTua($request)
    {
        $dataPerkelurahan = PendudukUsiaMudaProduktifTua::select([
            'usia_muda_produktif_tua_penduduk.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_muda_produktif_tua_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_muda_produktif_tua_penduduk.semester', $request['semester'])
            ->where('usia_muda_produktif_tua_penduduk.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukUsiaMudaProduktifTua::select(
            DB::raw('sum(usia_muda) as total_usia_muda'),
            DB::raw('sum(usia_produktif) as total_usia_produktif'),
            DB::raw('sum(usia_tua) as total_usia_tua'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->get();
        $dataPerkecamatan = PendudukUsiaMudaProduktifTua::select([
            DB::raw('sum(usia_muda) as total_usia_muda'),
            DB::raw('sum(usia_produktif) as total_usia_produktif'),
            DB::raw('sum(usia_tua) as total_usia_tua'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_muda_produktif_tua_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_muda_produktif_tua_penduduk.semester', $request['semester'])
            ->where('usia_muda_produktif_tua_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function laporanKinerjaPdakCapil($request)
    {
        // dateTime
        $from = Carbon::parse($request['form'])->addSeconds(0);
        $to = Carbon::parse($request['to'])->addHours(23)->addMinutes(59)->addSeconds(0);
        //atributTable
        $attributTable = [
            'cetak_akta_kelahiran_lk',
            'cetak_akta_kelahiran_pr',
            'cetak_akta_kelahiran_jml',
            'pembatalan_kelahiran',
            'pembetulan_kelahiran',
            'cetak_akta_kematian_lk',
            'cetak_akta_kematian_pr',
            'cetak_akta_kematian_jml',
            'cetak_akta_kawin',
            'pembatalan_akta_kawin',
            'cetak_akta_cerai',
            'pembatalan_akta_cerai',
            'perubahan_wni_wna',
            'perubahan_wna_wni',
            'perubahan_nama',
            'perubahan_jenis_kelamin',
            'pengesahan_anak_lk',
            'pengesahan_anak_pr',
            'pengesahan_anak_jml',
            'pengangkatan_anak_lk',
            'pengangkatan_anak_pr',
            'pengangkatan_anak_jml',
        ];
        $dataPerkelurahan = Capil::select([
            'laporan_kinerja_capil_format_pdak.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'laporan_kinerja_capil_format_pdak.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->whereBetween('tanggal_laporan', [$from, $to])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataPerkecamatan = Capil::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $attributTable),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'laporan_kinerja_capil_format_pdak.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->whereBetween('tanggal_laporan', [$from, $to])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = Capil::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $attributTable)
            )
        )->whereBetween('tanggal_laporan', [$from, $to])

            ->get();
        $dataTitle = [
            'dari' => $request['from'],
            'sampai' => $request['to'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function laporanKinerjaPdakDafduk($request)
    {
        // dateTime
        $from = Carbon::parse($request['form'])->addSeconds(0);
        $to = Carbon::parse($request['to'])->addHours(23)->addMinutes(59)->addSeconds(0);
        //atributTable
        $attributTable = [
            'penerbitan_kk',
            'perubahan_kk',
            'penerbitan_nik_wni_lk',
            'penerbitan_nik_wni_pr',
            'penerbitan_nik_wni_jml',
            'penerbitan_nik_oa_lk',
            'penerbitan_nik_oa_pr',
            'penerbitan_nik_oa_jml',
            'pencetakan_kia_lk',
            'pencetakan_kia_pr',
            'pencetakan_kia_jml',
            'ktp_el_rekam_lk',
            'ktp_el_rekam_pr',
            'ktp_el_rekam_jml',
            'ktp_el_cetak_lk',
            'ktp_el_cetak_pr',
            'ktp_el_cetak_jml',
            'jml_surat_pindah',
            'jml_pindah_lk',
            'jml_pindah_pr',
            'jml_pindah_jml',
            'jml_surat_datang',
            'jml_datang_lk',
            'jml_datang_pr',
            'jml_datang_jml',
        ];
        $dataPerkelurahan = Dafduk::select([
            'laporan_kinerja_dafduk_format_pdak.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'laporan_kinerja_dafduk_format_pdak.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->whereBetween('tanggal_laporan', [$from, $to])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataPerkecamatan = Dafduk::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $attributTable),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'laporan_kinerja_dafduk_format_pdak.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->whereBetween('tanggal_laporan', [$from, $to])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = Dafduk::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $attributTable)
            )
        )->whereBetween('tanggal_laporan', [$from, $to])

            ->get();
        $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPelayananOnline($request)
    {
        $dataTitle = [
            'start' => $request['start'],
            'finish' => $request['finish'],
        ];
        try {
            $data = $this->apiService->post('/api/data_layanan_online', $request->all());
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function dataCetakEktp($request)
    {
        try {
            // Validate request
            $request->validate([
                'start_date' => 'required|date_format:Y-m-d', // Form sends Y-m-d
                'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                'draw' => 'sometimes|integer',
                'detailed' => 'sometimes|boolean'
            ]);

            // Convert dates to d-m-Y for API
            $apiStartDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->format('d-m-Y');
            $apiEndDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->format('d-m-Y');

            // Get data from API with correct date format
            $apiResponse = $this->ktpApi->getKtpData($apiStartDate, $apiEndDate);

            // For detailed view (modal)
            if ($request->input('detailed')) {
                return response()->json([
                    'data' => [
                        'daily_data' => [
                            $request->input('start_date') => [ // Keep Y-m-d in response
                                'users' => $apiResponse['data'],
                                'date_total' => array_sum(array_column($apiResponse['data'], 'JUMLAH'))
                            ]
                        ]
                    ]
                ]);
            }

            // For main DataTable
            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => count($apiResponse['data']),
                'recordsFiltered' => count($apiResponse['data']),
                'data' => $apiResponse['data']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'draw' => $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ], 500);
        }
    }
    public function dataPerekaman($request)
    {
        try {
            // Validate request
            $request->validate([
                'start_date' => 'required|date_format:Y-m-d', // Form sends Y-m-d
                'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                'draw' => 'sometimes|integer',
                'detailed' => 'sometimes|boolean'
            ]);

            // Convert dates to d-m-Y for API
            $apiStartDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->format('d-m-Y');
            $apiEndDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->format('d-m-Y');

            // Get data from API with correct date format
            $apiResponse = $this->perekamanApi->getData($apiStartDate, $apiEndDate);

            // For detailed view (modal)
            if ($request->input('detailed')) {
                return response()->json([
                    'data' => [
                        'daily_data' => [
                            $request->input('start_date') => [ // Keep Y-m-d in response
                                'users' => $apiResponse['data'],
                                'date_total' => array_sum(array_column($apiResponse['data'], 'JUMLAH'))
                            ]
                        ]
                    ]
                ]);
            }

            // For main DataTable
            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => count($apiResponse['data']),
                'recordsFiltered' => count($apiResponse['data']),
                'data' => $apiResponse['data']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'draw' => $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ], 500);
        }
    }

    public function dateRangeAgeDisabilitasPendidikan($request)
    {
        $atributField = config('dataArray.categoryEducationDisabilites');
        $dataPerkelurahan = \App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $atributField),
                [
                    'mstr_kelurahan.nama as kelurahan_nama',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_umur_tunggal_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->whereBetween('umur', [$request->from, $request->to])
            ->where('pendidikan_umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('pendidikan_umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode','mstr_kelurahan.nama', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataPerkecamatan = \App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $atributField),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_umur_tunggal_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->whereBetween('umur', [$request->from, $request->to])
            ->where('pendidikan_umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('pendidikan_umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan =  \App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $atributField)
            )
        )
            ->whereBetween('umur', [$request->from, $request->to])
            ->where('pendidikan_umur_tunggal_disabilitas.semester', $request['semester'])
            ->where('pendidikan_umur_tunggal_disabilitas.tahun', $request['tahun'])
            ->get();
         $dataTitle = [
            'semester' => $request['semester'],
            'tahun' => $request['tahun'],
            'title' => 'Kelompok Umur '. $request['from'].'-'.$request['to']
        ];
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
}
