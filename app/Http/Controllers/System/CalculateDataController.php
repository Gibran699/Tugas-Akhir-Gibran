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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculateDataController extends Controller
{
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
        if ($dataPerkelurahan->sum() === 0) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan, 'dataTitle' => $dataTitle], 200);
    }
    public function dataPendudukPekerjaan($request)
    {
        $categoryJob =  config('dataArray.categoryJob');
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
        $cetegoryEducation = config('dataArray.cetegoryEducation');
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
                }, $cetegoryEducation)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $cetegoryEducation),
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
            ->first();
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
        $cetegoryEducation = config('dataArray.cetegoryEducation');
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
                }, $cetegoryEducation)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendidikanPendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $cetegoryEducation),
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
    public function  dataPendidikanGolonganDarah($request)
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
        $cetegoryEducation = config('dataArray.cetegoryEducation');
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
                }, $cetegoryEducation)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->groupBy('keterangan')
            ->get();
        $dataPerkecamatan = DisabilitasPendudukPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $cetegoryEducation),
                [
                    'pendidikan_disabilitas.keterangan as keterangan_disabilitas',
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
                            WHEN keterangan = 3 THEN '0-5 Tahun'
                            WHEN keterangan = 4 THEN '0-18 Tahun Kurang 1 Hari'
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
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'keterangan')
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
                    WHEN keterangan = 3 THEN '0-5 Tahun'
                    WHEN keterangan = 4 THEN '0-18 Tahun Kurang 1 Hari'
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
                                WHEN keterangan = 3 THEN '0-5 Tahun'
                                WHEN keterangan = 4 THEN '0-18 Tahun Kurang 1 Hari'
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
            ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama')
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
        $dataPerkelurahan = KepemilikanAktaCerai::select([
            'akta_cerai.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_cerai.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_cerai.semester', $request['semester'])
            ->where('akta_cerai.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanAktaCerai::select(
            // Muslim and Non-Muslim
            DB::raw('SUM(muslim_jml) as total_muslim_jml'),
            DB::raw('SUM(non_muslim_jml) as total_non_muslim_jml'),

            // Status Cerai
            DB::raw('SUM(status_cerai_lk) as total_status_cerai_lk'),
            DB::raw('SUM(status_cerai_pr) as total_status_cerai_pr'),
            DB::raw('SUM(status_cerai_jml) as total_status_cerai_jml'),

            // Memiliki Akta Cerai
            DB::raw('SUM(memiliki_akta_cerai_lk) as total_memiliki_akta_cerai_lk'),
            DB::raw('SUM(memiliki_akta_cerai_pr) as total_memiliki_akta_cerai_pr'),
            DB::raw('SUM(memiliki_akta_cerai_jml) as total_memiliki_akta_cerai_jml'),

            // Belum Memiliki Akta Cerai
            DB::raw('SUM(belum_memiliki_akta_cerai_jml) as total_belum_memiliki_akta_cerai_jml'),
            // persen
            DB::raw('IF(SUM(status_cerai_jml) = 0, 0, SUM(memiliki_akta_cerai_jml) / SUM(status_cerai_jml) * 100) as persen_memiliki')

        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepemilikanAktaCerai::select([
            // Muslim and Non-Muslim
            DB::raw('SUM(muslim_jml) as total_muslim_jml'),
            DB::raw('SUM(non_muslim_jml) as total_non_muslim_jml'),

            // Status Cerai
            DB::raw('SUM(status_cerai_lk) as total_status_cerai_lk'),
            DB::raw('SUM(status_cerai_pr) as total_status_cerai_pr'),
            DB::raw('SUM(status_cerai_jml) as total_status_cerai_jml'),

            // Memiliki Akta Cerai
            DB::raw('SUM(memiliki_akta_cerai_lk) as total_memiliki_akta_cerai_lk'),
            DB::raw('SUM(memiliki_akta_cerai_pr) as total_memiliki_akta_cerai_pr'),
            DB::raw('SUM(memiliki_akta_cerai_jml) as total_memiliki_akta_cerai_jml'),

            // Belum Memiliki Akta Cerai
            DB::raw('SUM(belum_memiliki_akta_cerai_jml) as total_belum_memiliki_akta_cerai_jml'),
            // persen
            DB::raw('IF(SUM(status_cerai_jml) = 0, 0, SUM(memiliki_akta_cerai_jml) / SUM(status_cerai_jml) * 100) as persen_memiliki'),

            'mstr_kecamatan.nama as kecamatan_nama'
        ])
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
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepemilikanAktaCeraiAgama($request)
    {
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
            // Islam
            DB::raw('SUM(islam_memiliki_lk) as total_islam_memiliki_lk'),
            DB::raw('SUM(islam_memiliki_pr) as total_islam_memiliki_pr'),
            DB::raw('SUM(islam_memiliki_jml) as total_islam_memiliki_jml'),
            DB::raw('SUM(islam_blm_memiliki_jml) as total_islam_blm_memiliki_jml'),

            // Kristen
            DB::raw('SUM(kristen_memiliki_lk) as total_kristen_memiliki_lk'),
            DB::raw('SUM(kristen_memiliki_pr) as total_kristen_memiliki_pr'),
            DB::raw('SUM(kristen_memiliki_jml) as total_kristen_memiliki_jml'),
            DB::raw('SUM(kristen_blm_memiliki_jml) as total_kristen_blm_memiliki_jml'),

            // Katholik
            DB::raw('SUM(katholik_memiliki_lk) as total_katholik_memiliki_lk'),
            DB::raw('SUM(katholik_memiliki_pr) as total_katholik_memiliki_pr'),
            DB::raw('SUM(katholik_memiliki_jml) as total_katholik_memiliki_jml'),
            DB::raw('SUM(katholik_blm_memiliki_jml) as total_katholik_blm_memiliki_jml'),

            // Hindu
            DB::raw('SUM(hindu_memiliki_lk) as total_hindu_memiliki_lk'),
            DB::raw('SUM(hindu_memiliki_pr) as total_hindu_memiliki_pr'),
            DB::raw('SUM(hindu_memiliki_jml) as total_hindu_memiliki_jml'),
            DB::raw('SUM(hindu_blm_memiliki_jml) as total_hindu_blm_memiliki_jml'),

            // Budha
            DB::raw('SUM(budha_memiliki_lk) as total_budha_memiliki_lk'),
            DB::raw('SUM(budha_memiliki_pr) as total_budha_memiliki_pr'),
            DB::raw('SUM(budha_memiliki_jml) as total_budha_memiliki_jml'),
            DB::raw('SUM(budha_blm_memiliki_jml) as total_budha_blm_memiliki_jml'),

            // Khonghucu
            DB::raw('SUM(khonghucu_memiliki_lk) as total_khonghucu_memiliki_lk'),
            DB::raw('SUM(khonghucu_memiliki_pr) as total_khonghucu_memiliki_pr'),
            DB::raw('SUM(khonghucu_memiliki_jml) as total_khonghucu_memiliki_jml'),
            DB::raw('SUM(khonghucu_blm_memiliki_jml) as total_khonghucu_blm_memiliki_jml'),

            // Kepercayaan
            DB::raw('SUM(kepercayaan_memiliki_lk) as total_kepercayaan_memiliki_lk'),
            DB::raw('SUM(kepercayaan_memiliki_pr) as total_kepercayaan_memiliki_pr'),
            DB::raw('SUM(kepercayaan_memiliki_jml) as total_kepercayaan_memiliki_jml'),
            DB::raw('SUM(kepercayaan_blm_memiliki_jml) as total_kepercayaan_blm_memiliki_jml')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepemilikanAktaCeraiAgama::select([
            // Islam
            DB::raw('SUM(islam_memiliki_lk) as total_islam_memiliki_lk'),
            DB::raw('SUM(islam_memiliki_pr) as total_islam_memiliki_pr'),
            DB::raw('SUM(islam_memiliki_jml) as total_islam_memiliki_jml'),
            DB::raw('SUM(islam_blm_memiliki_jml) as total_islam_blm_memiliki_jml'),

            // Kristen
            DB::raw('SUM(kristen_memiliki_lk) as total_kristen_memiliki_lk'),
            DB::raw('SUM(kristen_memiliki_pr) as total_kristen_memiliki_pr'),
            DB::raw('SUM(kristen_memiliki_jml) as total_kristen_memiliki_jml'),
            DB::raw('SUM(kristen_blm_memiliki_jml) as total_kristen_blm_memiliki_jml'),

            // Katholik
            DB::raw('SUM(katholik_memiliki_lk) as total_katholik_memiliki_lk'),
            DB::raw('SUM(katholik_memiliki_pr) as total_katholik_memiliki_pr'),
            DB::raw('SUM(katholik_memiliki_jml) as total_katholik_memiliki_jml'),
            DB::raw('SUM(katholik_blm_memiliki_jml) as total_katholik_blm_memiliki_jml'),

            // Hindu
            DB::raw('SUM(hindu_memiliki_lk) as total_hindu_memiliki_lk'),
            DB::raw('SUM(hindu_memiliki_pr) as total_hindu_memiliki_pr'),
            DB::raw('SUM(hindu_memiliki_jml) as total_hindu_memiliki_jml'),
            DB::raw('SUM(hindu_blm_memiliki_jml) as total_hindu_blm_memiliki_jml'),

            // Budha
            DB::raw('SUM(budha_memiliki_lk) as total_budha_memiliki_lk'),
            DB::raw('SUM(budha_memiliki_pr) as total_budha_memiliki_pr'),
            DB::raw('SUM(budha_memiliki_jml) as total_budha_memiliki_jml'),
            DB::raw('SUM(budha_blm_memiliki_jml) as total_budha_blm_memiliki_jml'),

            // Khonghucu
            DB::raw('SUM(khonghucu_memiliki_lk) as total_khonghucu_memiliki_lk'),
            DB::raw('SUM(khonghucu_memiliki_pr) as total_khonghucu_memiliki_pr'),
            DB::raw('SUM(khonghucu_memiliki_jml) as total_khonghucu_memiliki_jml'),
            DB::raw('SUM(khonghucu_blm_memiliki_jml) as total_khonghucu_blm_memiliki_jml'),

            // Kepercayaan
            DB::raw('SUM(kepercayaan_memiliki_lk) as total_kepercayaan_memiliki_lk'),
            DB::raw('SUM(kepercayaan_memiliki_pr) as total_kepercayaan_memiliki_pr'),
            DB::raw('SUM(kepercayaan_memiliki_jml) as total_kepercayaan_memiliki_jml'),
            DB::raw('SUM(kepercayaan_blm_memiliki_jml) as total_kepercayaan_blm_memiliki_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_cerai_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_cerai_agama.semester', $request['semester'])
            ->where('akta_cerai_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepemilikanKia($request)
    {
        $dataPerkelurahan = KepemilikanKia::select([
            'kia.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kia.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kia.semester', $request['semester'])
            ->where('kia.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanKia::select(
            // Jumlah awal penduduk
            DB::raw('SUM(jumlah_awal_lk) as total_jumlah_awal_lk'), // Jumlah awal laki-laki
            DB::raw('SUM(jumlah_awal_pr) as total_jumlah_awal_pr'), // Jumlah awal perempuan
            DB::raw('SUM(jumlah_awal_jml) as total_jumlah_awal_jml'), // Total jumlah awal

            // Memiliki dokumen pada awal periode
            DB::raw('SUM(memiliki_awal_lk) as total_memiliki_awal_lk'), // Laki-laki yang memiliki dokumen
            DB::raw('SUM(memiliki_awal_pr) as total_memiliki_awal_pr'), // Perempuan yang memiliki dokumen
            DB::raw('SUM(memiliki_awal_jml) as total_memiliki_awal_jml'), // Total yang memiliki dokumen

            // Belum memiliki dokumen pada awal periode
            DB::raw('SUM(belum_memiliki_awal_lk) as total_belum_memiliki_awal_lk'), // Laki-laki yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_awal_pr) as total_belum_memiliki_awal_pr'), // Perempuan yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_awal_jml) as total_belum_memiliki_awal_jml'), // Total yang belum memiliki dokumen

            // Persentase kepemilikan awal
            DB::raw('IF(SUM(jumlah_awal_jml) = 0, 0, SUM(memiliki_awal_jml) / SUM(jumlah_awal_jml) * 100) as persen_memiliki_awal'), // Persentase penduduk yang memiliki dokumen

            // Penduduk yang sudah melewati usia target
            DB::raw('SUM(usia_lebih_target_lk) as total_usia_lebih_target_lk'), // Laki-laki yang melebihi usia target
            DB::raw('SUM(usia_lebih_target_pr) as total_usia_lebih_target_pr'), // Perempuan yang melebihi usia target
            DB::raw('SUM(usia_lebih_target_jml) as total_usia_lebih_target_jml'), // Total yang melebihi usia target

            // Penduduk yang meninggal
            DB::raw('SUM(meninggal_lk) as total_meninggal_lk'), // Laki-laki yang meninggal
            DB::raw('SUM(meninggal_pr) as total_meninggal_pr'), // Perempuan yang meninggal
            DB::raw('SUM(meninggal_jml) as total_meninggal_jml'), // Total yang meninggal

            // Penduduk yang dinonaktifkan
            DB::raw('SUM(nonaktif_lk) as total_nonaktif_lk'), // Laki-laki yang dinonaktifkan
            DB::raw('SUM(nonaktif_pr) as total_nonaktif_pr'), // Perempuan yang dinonaktifkan
            DB::raw('SUM(nonaktif_jml) as total_nonaktif_jml'), // Total yang dinonaktifkan

            // Memiliki dokumen dalam Data Kependudukan Berbasis Wilayah (DKB)
            DB::raw('SUM(memiliki_dalam_dkb_lk) as total_memiliki_dalam_dkb_lk'), // Laki-laki dalam DKB
            DB::raw('SUM(memiliki_dalam_dkb_pr) as total_memiliki_dalam_dkb_pr'), // Perempuan dalam DKB
            DB::raw('SUM(memiliki_dalam_dkb_jml) as total_memiliki_dalam_dkb_jml'), // Total dalam DKB

            // Memiliki dokumen di luar DKB
            DB::raw('SUM(memiliki_luar_dkb_lk) as total_memiliki_luar_dkb_lk'), // Laki-laki di luar DKB
            DB::raw('SUM(memiliki_luar_dkb_pr) as total_memiliki_luar_dkb_pr'), // Perempuan di luar DKB
            DB::raw('SUM(memiliki_luar_dkb_jml) as total_memiliki_luar_dkb_jml'), // Total di luar DKB

            // Jumlah penduduk yang mengalami perubahan dinamis
            DB::raw('SUM(jumlah_dinamis_lk) as total_jumlah_dinamis_lk'), // Laki-laki yang berubah statusnya
            DB::raw('SUM(jumlah_dinamis_pr) as total_jumlah_dinamis_pr'), // Perempuan yang berubah statusnya
            DB::raw('SUM(jumlah_dinamis_ttl) as total_jumlah_dinamis_ttl'), // Total perubahan status

            // Memiliki dokumen dalam perubahan dinamis
            DB::raw('SUM(memiliki_dinamis_lk) as total_memiliki_dinamis_lk'), // Laki-laki yang memiliki dokumen setelah perubahan
            DB::raw('SUM(memiliki_dinamis_pr) as total_memiliki_dinamis_pr'), // Perempuan yang memiliki dokumen setelah perubahan
            DB::raw('SUM(memiliki_dinamis_jml) as total_memiliki_dinamis_jml'), // Total yang memiliki dokumen setelah perubahan

            // Belum memiliki dokumen dalam perubahan dinamis
            DB::raw('SUM(belum_memiliki_dinamis_lk) as total_belum_memiliki_dinamis_lk'), // Laki-laki yang belum memiliki dokumen setelah perubahan
            DB::raw('SUM(belum_memiliki_dinamis_pr) as total_belum_memiliki_dinamis_pr'), // Perempuan yang belum memiliki dokumen setelah perubahan
            DB::raw('SUM(belum_memiliki_dinamis_jml) as total_belum_memiliki_dinamis_jml'), // Total yang belum memiliki dokumen setelah perubahan

            // Persentase kepemilikan dokumen setelah perubahan dinamis
            DB::raw('IF(SUM(jumlah_dinamis_ttl) = 0, 0, SUM(memiliki_dinamis_jml) / SUM(jumlah_dinamis_ttl) * 100) as persen_memiliki_dinamis'), // Persentase kepemilikan setelah perubahan

            // Penambahan penduduk baru
            DB::raw('SUM(penambahan_lk) as total_penambahan_lk'), // Penambahan laki-laki
            DB::raw('SUM(penambahan_pr) as total_penambahan_pr'), // Penambahan perempuan
            DB::raw('SUM(penambahan_jml) as total_penambahan_jml'), // Penambahan total
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukJenisKelamin::select([
            // Jumlah awal penduduk
            DB::raw('SUM(jumlah_awal_lk) as total_jumlah_awal_lk'), // Jumlah awal laki-laki
            DB::raw('SUM(jumlah_awal_pr) as total_jumlah_awal_pr'), // Jumlah awal perempuan
            DB::raw('SUM(jumlah_awal_jml) as total_jumlah_awal_jml'), // Total jumlah awal

            // Memiliki dokumen pada awal periode
            DB::raw('SUM(memiliki_awal_lk) as total_memiliki_awal_lk'), // Laki-laki yang memiliki dokumen
            DB::raw('SUM(memiliki_awal_pr) as total_memiliki_awal_pr'), // Perempuan yang memiliki dokumen
            DB::raw('SUM(memiliki_awal_jml) as total_memiliki_awal_jml'), // Total yang memiliki dokumen

            // Belum memiliki dokumen pada awal periode
            DB::raw('SUM(belum_memiliki_awal_lk) as total_belum_memiliki_awal_lk'), // Laki-laki yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_awal_pr) as total_belum_memiliki_awal_pr'), // Perempuan yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_awal_jml) as total_belum_memiliki_awal_jml'), // Total yang belum memiliki dokumen

            // Persentase kepemilikan awal
            DB::raw('IF(SUM(jumlah_awal_jml) = 0, 0, SUM(memiliki_awal_jml) / SUM(jumlah_awal_jml) * 100) as persen_memiliki_awal'), // Persentase penduduk yang memiliki dokumen

            // Penduduk yang sudah melewati usia target
            DB::raw('SUM(usia_lebih_target_lk) as total_usia_lebih_target_lk'), // Laki-laki yang melebihi usia target
            DB::raw('SUM(usia_lebih_target_pr) as total_usia_lebih_target_pr'), // Perempuan yang melebihi usia target
            DB::raw('SUM(usia_lebih_target_jml) as total_usia_lebih_target_jml'), // Total yang melebihi usia target

            // Penduduk yang meninggal
            DB::raw('SUM(meninggal_lk) as total_meninggal_lk'), // Laki-laki yang meninggal
            DB::raw('SUM(meninggal_pr) as total_meninggal_pr'), // Perempuan yang meninggal
            DB::raw('SUM(meninggal_jml) as total_meninggal_jml'), // Total yang meninggal

            // Penduduk yang dinonaktifkan
            DB::raw('SUM(nonaktif_lk) as total_nonaktif_lk'), // Laki-laki yang dinonaktifkan
            DB::raw('SUM(nonaktif_pr) as total_nonaktif_pr'), // Perempuan yang dinonaktifkan
            DB::raw('SUM(nonaktif_jml) as total_nonaktif_jml'), // Total yang dinonaktifkan

            // Memiliki dokumen dalam Data Kependudukan Berbasis Wilayah (DKB)
            DB::raw('SUM(memiliki_dalam_dkb_lk) as total_memiliki_dalam_dkb_lk'), // Laki-laki dalam DKB
            DB::raw('SUM(memiliki_dalam_dkb_pr) as total_memiliki_dalam_dkb_pr'), // Perempuan dalam DKB
            DB::raw('SUM(memiliki_dalam_dkb_jml) as total_memiliki_dalam_dkb_jml'), // Total dalam DKB

            // Memiliki dokumen di luar DKB
            DB::raw('SUM(memiliki_luar_dkb_lk) as total_memiliki_luar_dkb_lk'), // Laki-laki di luar DKB
            DB::raw('SUM(memiliki_luar_dkb_pr) as total_memiliki_luar_dkb_pr'), // Perempuan di luar DKB
            DB::raw('SUM(memiliki_luar_dkb_jml) as total_memiliki_luar_dkb_jml'), // Total di luar DKB

            // Jumlah penduduk yang mengalami perubahan dinamis
            DB::raw('SUM(jumlah_dinamis_lk) as total_jumlah_dinamis_lk'), // Laki-laki yang berubah statusnya
            DB::raw('SUM(jumlah_dinamis_pr) as total_jumlah_dinamis_pr'), // Perempuan yang berubah statusnya
            DB::raw('SUM(jumlah_dinamis_ttl) as total_jumlah_dinamis_ttl'), // Total perubahan status

            // Memiliki dokumen dalam perubahan dinamis
            DB::raw('SUM(memiliki_dinamis_lk) as total_memiliki_dinamis_lk'), // Laki-laki yang memiliki dokumen setelah perubahan
            DB::raw('SUM(memiliki_dinamis_pr) as total_memiliki_dinamis_pr'), // Perempuan yang memiliki dokumen setelah perubahan
            DB::raw('SUM(memiliki_dinamis_jml) as total_memiliki_dinamis_jml'), // Total yang memiliki dokumen setelah perubahan

            // Belum memiliki dokumen dalam perubahan dinamis
            DB::raw('SUM(belum_memiliki_dinamis_lk) as total_belum_memiliki_dinamis_lk'), // Laki-laki yang belum memiliki dokumen setelah perubahan
            DB::raw('SUM(belum_memiliki_dinamis_pr) as total_belum_memiliki_dinamis_pr'), // Perempuan yang belum memiliki dokumen setelah perubahan
            DB::raw('SUM(belum_memiliki_dinamis_jml) as total_belum_memiliki_dinamis_jml'), // Total yang belum memiliki dokumen setelah perubahan

            // Persentase kepemilikan dokumen setelah perubahan dinamis
            DB::raw('IF(SUM(jumlah_dinamis_ttl) = 0, 0, SUM(memiliki_dinamis_jml) / SUM(jumlah_dinamis_ttl) * 100) as persen_memiliki_dinamis'), // Persentase kepemilikan setelah perubahan

            // Penambahan penduduk baru
            DB::raw('SUM(penambahan_lk) as total_penambahan_lk'), // Penambahan laki-laki
            DB::raw('SUM(penambahan_pr) as total_penambahan_pr'), // Penambahan perempuan
            DB::raw('SUM(penambahan_jml) as total_penambahan_jml'), // Penambahan total
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kia.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kia.semester', $request['semester'])
            ->where('kia.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepemilikanKartuKeluarga($request)
    {
        $dataPerkelurahan = KepemilikanKartuKeluarga::select([
            'kartu_keluarga.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kartu_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kartu_keluarga.semester', $request['semester'])
            ->where('kartu_keluarga.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanKartuKeluarga::select(
            // Kepala Keluarga (KK)
            DB::raw('SUM(kk_lk) as total_kk_lk'), // Jumlah kepala keluarga laki-laki
            DB::raw('SUM(kk_pr) as total_kk_pr'), // Jumlah kepala keluarga perempuan
            DB::raw('SUM(kk_jml) as total_kk_jml'), // Total kepala keluarga

            // Penduduk yang memiliki dokumen
            DB::raw('SUM(memiliki_lk) as total_memiliki_lk'), // Laki-laki yang memiliki dokumen
            DB::raw('SUM(memiliki_pr) as total_memiliki_pr'), // Perempuan yang memiliki dokumen
            DB::raw('SUM(memiliki_jml) as total_memiliki_jml'), // Total penduduk yang memiliki dokumen

            // Penduduk yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_lk) as total_belum_memiliki_lk'), // Laki-laki yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_pr) as total_belum_memiliki_pr'), // Perempuan yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_jml) as total_belum_memiliki_jml') // Total penduduk yang belum memiliki dokumen
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = DisabilitasPendudukPendidikan::select([
            // Kepala Keluarga (KK)
            DB::raw('SUM(kk_lk) as total_kk_lk'), // Jumlah kepala keluarga laki-laki
            DB::raw('SUM(kk_pr) as total_kk_pr'), // Jumlah kepala keluarga perempuan
            DB::raw('SUM(kk_jml) as total_kk_jml'), // Total kepala keluarga

            // Penduduk yang memiliki dokumen
            DB::raw('SUM(memiliki_lk) as total_memiliki_lk'), // Laki-laki yang memiliki dokumen
            DB::raw('SUM(memiliki_pr) as total_memiliki_pr'), // Perempuan yang memiliki dokumen
            DB::raw('SUM(memiliki_jml) as total_memiliki_jml'), // Total penduduk yang memiliki dokumen

            // Penduduk yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_lk) as total_belum_memiliki_lk'), // Laki-laki yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_pr) as total_belum_memiliki_pr'), // Perempuan yang belum memiliki dokumen
            DB::raw('SUM(belum_memiliki_jml) as total_belum_memiliki_jml'), // Total penduduk yang belum memiliki dokumen
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kartu_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kartu_keluarga.semester', $request['semester'])
            ->where('kartu_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepemilikanKTP($request)
    {
        $dataPerkelurahan = KepemilikanKtp::select([
            'ktp.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'ktp.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('ktp.semester', $request['semester'])
            ->where('ktp.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanKtp::select(
            // Wajib KTP
            DB::raw('SUM(wajib_ktp_lk) as total_wajib_ktp_lk'),
            DB::raw('SUM(wajib_ktp_pr) as total_wajib_ktp_pr'),
            DB::raw('SUM(wajib_ktp_jml) as total_wajib_ktp_jml'),

            // Rekam KTP
            DB::raw('SUM(rekam_lk) as total_rekam_lk'),
            DB::raw('SUM(rekam_pr) as total_rekam_pr'),
            DB::raw('SUM(rekam_jml) as total_rekam_jml'),

            // Belum Rekam KTP
            DB::raw('SUM(belum_rekam_lk) as total_belum_rekam_lk'),
            DB::raw('SUM(belum_rekam_pr) as total_belum_rekam_pr'),
            DB::raw('SUM(belum_rekam_jml) as total_belum_rekam_jml'),

            // KTP
            DB::raw('SUM(ktp_lk) as total_ktp_lk'),
            DB::raw('SUM(ktp_pr) as total_ktp_pr'),
            DB::raw('SUM(ktp_jml) as total_ktp_jml'),

            // Belum KTP
            DB::raw('SUM(blm_ktp_lk) as total_blm_ktp_lk'),
            DB::raw('SUM(blm_ktp_pr) as total_blm_ktp_pr'),
            DB::raw('SUM(blm_ktp_jml) as total_blm_ktp_jml')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepemilikanKtp::select([
            // Wajib KTP
            DB::raw('SUM(wajib_ktp_lk) as total_wajib_ktp_lk'),
            DB::raw('SUM(wajib_ktp_pr) as total_wajib_ktp_pr'),
            DB::raw('SUM(wajib_ktp_jml) as total_wajib_ktp_jml'),

            // Rekam KTP
            DB::raw('SUM(rekam_lk) as total_rekam_lk'),
            DB::raw('SUM(rekam_pr) as total_rekam_pr'),
            DB::raw('SUM(rekam_jml) as total_rekam_jml'),

            // Belum Rekam KTP
            DB::raw('SUM(belum_rekam_lk) as total_belum_rekam_lk'),
            DB::raw('SUM(belum_rekam_pr) as total_belum_rekam_pr'),
            DB::raw('SUM(belum_rekam_jml) as total_belum_rekam_jml'),

            // KTP
            DB::raw('SUM(ktp_lk) as total_ktp_lk'),
            DB::raw('SUM(ktp_pr) as total_ktp_pr'),
            DB::raw('SUM(ktp_jml) as total_ktp_jml'),

            // Belum KTP
            DB::raw('SUM(blm_ktp_lk) as total_blm_ktp_lk'),
            DB::raw('SUM(blm_ktp_pr) as total_blm_ktp_pr'),
            DB::raw('SUM(blm_ktp_jml) as total_blm_ktp_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'ktp.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('ktp.semester', $request['semester'])
            ->where('ktp.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataStrukturUmurAgamaKelompokUmur($request)
    {
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
            // Islam
            DB::raw('SUM(islam_lk) as total_islam_lk'),
            DB::raw('SUM(islam_pr) as total_islam_pr'),
            DB::raw('SUM(islam_jml) as total_islam_jml'),

            // Katholik
            DB::raw('SUM(katholik_lk) as total_katholik_lk'),
            DB::raw('SUM(katholik_pr) as total_katholik_pr'),
            DB::raw('SUM(katholik_jml) as total_katholik_jml'),

            // Kristen
            DB::raw('SUM(kristen_lk) as total_kristen_lk'),
            DB::raw('SUM(kristen_pr) as total_kristen_pr'),
            DB::raw('SUM(kristen_jml) as total_kristen_jml'),

            // Hindu
            DB::raw('SUM(hindu_lk) as total_hindu_lk'),
            DB::raw('SUM(hindu_pr) as total_hindu_pr'),
            DB::raw('SUM(hindu_jml) as total_hindu_jml'),

            // Budha
            DB::raw('SUM(budha_lk) as total_budha_lk'),
            DB::raw('SUM(budha_pr) as total_budha_pr'),
            DB::raw('SUM(budha_jml) as total_budha_jml'),

            // Konghucu
            DB::raw('SUM(konghucu_lk) as total_konghucu_lk'),
            DB::raw('SUM(konghucu_pr) as total_konghucu_pr'),
            DB::raw('SUM(konghucu_jml) as total_konghucu_jml'),

            // Kepercayaan
            DB::raw('SUM(kepercayaan_lk) as total_kepercayaan_lk'),
            DB::raw('SUM(kepercayaan_pr) as total_kepercayaan_pr'),
            DB::raw('SUM(kepercayaan_jml) as total_kepercayaan_jml'),
            'kelompok_umur_agama.kelompok_umur',
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KelompokUmurAgama::select([
            // Islam
            DB::raw('SUM(islam_lk) as total_islam_lk'),
            DB::raw('SUM(islam_pr) as total_islam_pr'),
            DB::raw('SUM(islam_jml) as total_islam_jml'),

            // Katholik
            DB::raw('SUM(katholik_lk) as total_katholik_lk'),
            DB::raw('SUM(katholik_pr) as total_katholik_pr'),
            DB::raw('SUM(katholik_jml) as total_katholik_jml'),

            // Kristen
            DB::raw('SUM(kristen_lk) as total_kristen_lk'),
            DB::raw('SUM(kristen_pr) as total_kristen_pr'),
            DB::raw('SUM(kristen_jml) as total_kristen_jml'),

            // Hindu
            DB::raw('SUM(hindu_lk) as total_hindu_lk'),
            DB::raw('SUM(hindu_pr) as total_hindu_pr'),
            DB::raw('SUM(hindu_jml) as total_hindu_jml'),

            // Budha
            DB::raw('SUM(budha_lk) as total_budha_lk'),
            DB::raw('SUM(budha_pr) as total_budha_pr'),
            DB::raw('SUM(budha_jml) as total_budha_jml'),

            // Konghucu
            DB::raw('SUM(konghucu_lk) as total_konghucu_lk'),
            DB::raw('SUM(konghucu_pr) as total_konghucu_pr'),
            DB::raw('SUM(konghucu_jml) as total_konghucu_jml'),

            // Kepercayaan
            DB::raw('SUM(kepercayaan_lk) as total_kepercayaan_lk'),
            DB::raw('SUM(kepercayaan_pr) as total_kepercayaan_pr'),
            DB::raw('SUM(kepercayaan_jml) as total_kepercayaan_jml'),
            'kelompok_umur_agama.kelompok_umur',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_agama.semester', $request['semester'])
            ->where('kelompok_umur_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataStrukturUmurDisabilitasKelompokUmur($request)
    {
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
            // Disabilitas Fisik
            DB::raw('SUM(disabilitas_fisik_lk) as total_disabilitas_fisik_lk'),
            DB::raw('SUM(disabilitas_fisik_pr) as total_disabilitas_fisik_pr'),
            DB::raw('SUM(disabilitas_fisik_jml) as total_disabilitas_fisik_jml'),

            // Disabilitas Netra/Buta
            DB::raw('SUM(disabilitas_netra_buta_lk) as total_disabilitas_netra_buta_lk'),
            DB::raw('SUM(disabilitas_netra_buta_pr) as total_disabilitas_netra_buta_pr'),
            DB::raw('SUM(disabilitas_netra_buta_jml) as total_disabilitas_netra_buta_jml'),

            // Disabilitas Rungu/Wicara
            DB::raw('SUM(disabilitas_rungu_wicara_lk) as total_disabilitas_rungu_wicara_lk'),
            DB::raw('SUM(disabilitas_rungu_wicara_pr) as total_disabilitas_rungu_wicara_pr'),
            DB::raw('SUM(disabilitas_rungu_wicara_jml) as total_disabilitas_rungu_wicara_jml'),

            // Disabilitas Mental/Jiwa
            DB::raw('SUM(disabilitas_mental_jiwa_lk) as total_disabilitas_mental_jiwa_lk'),
            DB::raw('SUM(disabilitas_mental_jiwa_pr) as total_disabilitas_mental_jiwa_pr'),
            DB::raw('SUM(disabilitas_mental_jiwa_jml) as total_disabilitas_mental_jiwa_jml'),

            // Disabilitas Fisik & Mental
            DB::raw('SUM(disabilitas_fisik_mental_lk) as total_disabilitas_fisik_mental_lk'),
            DB::raw('SUM(disabilitas_fisik_mental_pr) as total_disabilitas_fisik_mental_pr'),
            DB::raw('SUM(disabilitas_fisik_mental_jml) as total_disabilitas_fisik_mental_jml'),

            // Disabilitas Lainnya
            DB::raw('SUM(disabilitas_lainnya_lk) as total_disabilitas_lainnya_lk'),
            DB::raw('SUM(disabilitas_lainnya_pr) as total_disabilitas_lainnya_pr'),
            DB::raw('SUM(disabilitas_lainnya_jml) as total_disabilitas_lainnya_jml'),
            'kelompok_umur_disabilitas.kelompok_umur as kelompok_umur'
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KelompokUmurDisabilitas::select([
            // Disabilitas Fisik
            DB::raw('SUM(disabilitas_fisik_lk) as total_disabilitas_fisik_lk'),
            DB::raw('SUM(disabilitas_fisik_pr) as total_disabilitas_fisik_pr'),
            DB::raw('SUM(disabilitas_fisik_jml) as total_disabilitas_fisik_jml'),

            // Disabilitas Netra/Buta
            DB::raw('SUM(disabilitas_netra_buta_lk) as total_disabilitas_netra_buta_lk'),
            DB::raw('SUM(disabilitas_netra_buta_pr) as total_disabilitas_netra_buta_pr'),
            DB::raw('SUM(disabilitas_netra_buta_jml) as total_disabilitas_netra_buta_jml'),

            // Disabilitas Rungu/Wicara
            DB::raw('SUM(disabilitas_rungu_wicara_lk) as total_disabilitas_rungu_wicara_lk'),
            DB::raw('SUM(disabilitas_rungu_wicara_pr) as total_disabilitas_rungu_wicara_pr'),
            DB::raw('SUM(disabilitas_rungu_wicara_jml) as total_disabilitas_rungu_wicara_jml'),

            // Disabilitas Mental/Jiwa
            DB::raw('SUM(disabilitas_mental_jiwa_lk) as total_disabilitas_mental_jiwa_lk'),
            DB::raw('SUM(disabilitas_mental_jiwa_pr) as total_disabilitas_mental_jiwa_pr'),
            DB::raw('SUM(disabilitas_mental_jiwa_jml) as total_disabilitas_mental_jiwa_jml'),

            // Disabilitas Fisik & Mental
            DB::raw('SUM(disabilitas_fisik_mental_lk) as total_disabilitas_fisik_mental_lk'),
            DB::raw('SUM(disabilitas_fisik_mental_pr) as total_disabilitas_fisik_mental_pr'),
            DB::raw('SUM(disabilitas_fisik_mental_jml) as total_disabilitas_fisik_mental_jml'),

            // Disabilitas Lainnya
            DB::raw('SUM(disabilitas_lainnya_lk) as total_disabilitas_lainnya_lk'),
            DB::raw('SUM(disabilitas_lainnya_pr) as total_disabilitas_lainnya_pr'),
            DB::raw('SUM(disabilitas_lainnya_jml) as total_disabilitas_lainnya_jml'),
            'kelompok_umur_disabilitas.kelompok_umur as kelompok_umur',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_disabilitas.semester', $request['semester'])
            ->where('kelompok_umur_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasUmurTunggalPendidikan::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryEducationDisabilites),
                ['pendidikan_umur_tunggal_disabilitas.umur as umur']
            )
        )
            ->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
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
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = DisabilitasUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryDisabilites),
                [
                    'umur_tunggal_disabilitas.umur as umur'
                ]
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();

        $dataPerkecamatan = PendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryDisabilites),
                [
                    'umur_tunggal_disabilitas.umur as umur',
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_penduduk.semester', $request['semester'])
            ->where('jenis_kelamin_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
        $dataPerkecamatan = PendudukJenisKelamin::select(array_merge(
            array_map(function ($item) {
                return DB::raw("SUM($item) as $item");
            }, $categoryAgeSchollDisabilities),
            [
                'mstr_kecamatan.nama as kecamatan_nama'
            ]
        ))
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_penduduk.semester', $request['semester'])
            ->where('jenis_kelamin_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood),
                [
                    'kelompok_umur_golongan_darah.kelompok_umur as kelompok_umur'
                ]
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
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
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = GolonganDarahUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryBlood),
                [
                    'umur_tunggal_golongan_darah.umur as umur'
                ]
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
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
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
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
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepalaKeluargaUmurTunggal::select(
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaUmurTunggal::select([
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_kepala_keluarga.semester', $request['semester'])
            ->where('umur_tunggal_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
        $dataPerkecamatan = PendudukJenisKelamin::select(array_merge(
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
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukUmurTunggal::select(
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukUmurTunggal::select([
            DB::raw('sum(lk) as total_lk'),
            DB::raw('sum(pr) as total_pr'),
            DB::raw('sum(jumlah) as total_jumlah'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('umur_tunggal_penduduk.semester', $request['semester'])
            ->where('umur_tunggal_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
        $dataPerkecamatan = PendudukJenisKelamin::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryMarriageStatus),
                [
                    'mstr_kecamatan.nama as kecamatan_nama'
                ]
            )
        )
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_umur_tunggal_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_umur_tunggal_penduduk.semester', $request['semester'])
            ->where('status_kawin_umur_tunggal_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
        $dataKeseluruhan = PendudukStatusKawinUmurTunggal::select(
            array_merge(
                array_map(function ($item) {
                    return DB::raw("SUM($item) as $item");
                }, $categoryAgeGroup)
            )
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendudukStatusKawinUmurTunggal::select(
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
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
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
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('kelompok_umur_penduduk.semester', $request['semester'])
            ->where('kelompok_umur_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
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
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
        $dataPerkecamatan = PendudukUsiaMudaProduktifTua::select([
            DB::raw('sum(usia_muda) as total_usia_muda'),
            DB::raw('sum(usia_produktif) as total_usia_produktif'),
            DB::raw('sum(usia_tua) as total_usia_tua'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'usia_sekolah_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('usia_sekolah_penduduk.semester', $request['semester'])
            ->where('usia_sekolah_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
}
