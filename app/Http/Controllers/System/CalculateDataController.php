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
                }, $categoryJob),['mstr_kecamatan.nama as kecamatan_nama']
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
        $dataPerkecamatan = KepalaKeluargaAgama::select([
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
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'agama_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('agama_kepala_keluarga.semester', $request['semester'])
            ->where('agama_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepalaKeluargaPekerjaan($request)
    {
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
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaPekerjaan::select([
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_kepala_keluarga.semester', $request['semester'])
            ->where('pekerjaan_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepalaKeluargaPendidikan($request)
    {
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
            DB::raw('sum(tidak_blm_sekolah_l) as total_tidak_blm_sekolah_l'),
            DB::raw('sum(tidak_blm_sekolah_p) as total_tidak_blm_sekolah_p'),
            DB::raw('sum(tidak_blm_sekolah_jml) as total_tidak_blm_sekolah_jml'),
            DB::raw('sum(belum_tamat_sd_sederajat_l) as total_belum_tamat_sd_sederajat_l'),
            DB::raw('sum(belum_tamat_sd_sederajat_p) as total_belum_tamat_sd_sederajat_p'),
            DB::raw('sum(belum_tamat_sd_sederajat_jml) as total_belum_tamat_sd_sederajat_jml'),
            DB::raw('sum(tamat_sd_sederajat_l) as total_tamat_sd_sederajat_l'),
            DB::raw('sum(tamat_sd_sederajat_p) as total_tamat_sd_sederajat_p'),
            DB::raw('sum(tamat_sd_sederajat_jml) as total_tamat_sd_sederajat_jml'),
            DB::raw('sum(sltp_sederajat_l) as total_sltp_sederajat_l'),
            DB::raw('sum(sltp_sederajat_p) as total_sltp_sederajat_p'),
            DB::raw('sum(sltp_sederajat_jml) as total_sltp_sederajat_jml'),
            DB::raw('sum(slta_sederajat_l) as total_slta_sederajat_l'),
            DB::raw('sum(slta_sederajat_p) as total_slta_sederajat_p'),
            DB::raw('sum(slta_sederajat_jml) as total_slta_sederajat_jml'),
            DB::raw('sum(diploma_i_ii_l) as total_diploma_i_ii_l'),
            DB::raw('sum(diploma_i_ii_p) as total_diploma_i_ii_p'),
            DB::raw('sum(diploma_i_ii_jml) as total_diploma_i_ii_jml'),
            DB::raw('sum(akademi_dipl_iii_s_muda_l) as total_akademi_dipl_iii_s_muda_l'),
            DB::raw('sum(akademi_dipl_iii_s_muda_p) as total_akademi_dipl_iii_s_muda_p'),
            DB::raw('sum(akademi_dipl_iii_s_muda_jml) as total_akademi_dipl_iii_s_muda_jml'),
            DB::raw('sum(diploma_iv_strata_i_l) as total_diploma_iv_strata_i_l'),
            DB::raw('sum(diploma_iv_strata_i_p) as total_diploma_iv_strata_i_p'),
            DB::raw('sum(diploma_iv_strata_i_jml) as total_diploma_iv_strata_i_jml'),
            DB::raw('sum(strata_ii_l) as total_strata_ii_l'),
            DB::raw('sum(strata_ii_p) as total_strata_ii_p'),
            DB::raw('sum(strata_ii_jml) as total_strata_ii_jml'),
            DB::raw('sum(strata_iii_l) as total_strata_iii_l'),
            DB::raw('sum(strata_iii_p) as total_strata_iii_p'),
            DB::raw('sum(strata_iii_jml) as total_strata_iii_jml')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaPendidikan::select([
            DB::raw('sum(tidak_blm_sekolah_l) as total_tidak_blm_sekolah_l'),
            DB::raw('sum(tidak_blm_sekolah_p) as total_tidak_blm_sekolah_p'),
            DB::raw('sum(tidak_blm_sekolah_jml) as total_tidak_blm_sekolah_jml'),
            DB::raw('sum(belum_tamat_sd_sederajat_l) as total_belum_tamat_sd_sederajat_l'),
            DB::raw('sum(belum_tamat_sd_sederajat_p) as total_belum_tamat_sd_sederajat_p'),
            DB::raw('sum(belum_tamat_sd_sederajat_jml) as total_belum_tamat_sd_sederajat_jml'),
            DB::raw('sum(tamat_sd_sederajat_l) as total_tamat_sd_sederajat_l'),
            DB::raw('sum(tamat_sd_sederajat_p) as total_tamat_sd_sederajat_p'),
            DB::raw('sum(tamat_sd_sederajat_jml) as total_tamat_sd_sederajat_jml'),
            DB::raw('sum(sltp_sederajat_l) as total_sltp_sederajat_l'),
            DB::raw('sum(sltp_sederajat_p) as total_sltp_sederajat_p'),
            DB::raw('sum(sltp_sederajat_jml) as total_sltp_sederajat_jml'),
            DB::raw('sum(slta_sederajat_l) as total_slta_sederajat_l'),
            DB::raw('sum(slta_sederajat_p) as total_slta_sederajat_p'),
            DB::raw('sum(slta_sederajat_jml) as total_slta_sederajat_jml'),
            DB::raw('sum(diploma_i_ii_l) as total_diploma_i_ii_l'),
            DB::raw('sum(diploma_i_ii_p) as total_diploma_i_ii_p'),
            DB::raw('sum(diploma_i_ii_jml) as total_diploma_i_ii_jml'),
            DB::raw('sum(akademi_dipl_iii_s_muda_l) as total_akademi_dipl_iii_s_muda_l'),
            DB::raw('sum(akademi_dipl_iii_s_muda_p) as total_akademi_dipl_iii_s_muda_p'),
            DB::raw('sum(akademi_dipl_iii_s_muda_jml) as total_akademi_dipl_iii_s_muda_jml'),
            DB::raw('sum(diploma_iv_strata_i_l) as total_diploma_iv_strata_i_l'),
            DB::raw('sum(diploma_iv_strata_i_p) as total_diploma_iv_strata_i_p'),
            DB::raw('sum(diploma_iv_strata_i_jml) as total_diploma_iv_strata_i_jml'),
            DB::raw('sum(strata_ii_l) as total_strata_ii_l'),
            DB::raw('sum(strata_ii_p) as total_strata_ii_p'),
            DB::raw('sum(strata_ii_jml) as total_strata_ii_jml'),
            DB::raw('sum(strata_iii_l) as total_strata_iii_l'),
            DB::raw('sum(strata_iii_p) as total_strata_iii_p'),
            DB::raw('sum(strata_iii_jml) as total_strata_iii_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_kepala_keluarga.semester', $request['semester'])
            ->where('pendidikan_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKelapaKeluargaStatusKawin($request)
    {
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
            DB::raw('sum(belum_kawin_lk) as total_belum_kawin_lk'),
            DB::raw('sum(belum_kawin_pr) as total_belum_kawin_pr'),
            DB::raw('sum(kawin_lk) as total_kawin_lk'),
            DB::raw('sum(kawin_pr) as total_kawin_pr'),
            DB::raw('sum(cerai_hidup_lk) as total_cerai_hidup_lk'),
            DB::raw('sum(cerai_hidup_pr) as total_cerai_hidup_pr'),
            DB::raw('sum(cerai_mati_lk) as total_cerai_mati_lk'),
            DB::raw('sum(cerai_mati_pr) as total_cerai_mati_pr')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepalaKeluargaStatusKawin::select([
            DB::raw('sum(belum_kawin_lk) as total_belum_kawin_lk'),
            DB::raw('sum(belum_kawin_pr) as total_belum_kawin_pr'),
            DB::raw('sum(kawin_lk) as total_kawin_lk'),
            DB::raw('sum(kawin_pr) as total_kawin_pr'),
            DB::raw('sum(cerai_hidup_lk) as total_cerai_hidup_lk'),
            DB::raw('sum(cerai_hidup_pr) as total_cerai_hidup_pr'),
            DB::raw('sum(cerai_mati_lk) as total_cerai_mati_lk'),
            DB::raw('sum(cerai_mati_pr) as total_cerai_mati_pr'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_kepala_keluarga.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_kepala_keluarga.semester', $request['semester'])
            ->where('status_kawin_kepala_keluarga.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    // calculate data DKB Status Kawin
    public function dataStatusKawinAgama($request)
    {
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
        $dataPerkecamatan = StatusKawinPendudukAgama::select([
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
            'mstr_kecamatan.nama as kecamatan_nama',
            'status_kawin_penduduk_agama.keterangan as keterangan'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_agama.semester', $request['semester'])
            ->where('status_kawin_penduduk_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataStatusKawinJenisKelamin($request)
    {
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
            DB::raw('sum(belum_kawin_lk) as total_belum_kawin_lk'),
            DB::raw('sum(belum_kawin_pr) as total_belum_kawin_pr'),
            DB::raw('sum(kawin_lk) as total_kawin_lk'),
            DB::raw('sum(kawin_pr) as total_kawin_pr'),
            DB::raw('sum(cerai_hidup_lk) as total_cerai_hidup_lk'),
            DB::raw('sum(cerai_hidup_pr) as total_cerai_hidup_pr'),
            DB::raw('sum(cerai_mati_lk) as total_cerai_mati_lk'),
            DB::raw('sum(cerai_mati_pr) as total_cerai_mati_pr')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = StatusKawinPendudukJenisKelamin::select([
            DB::raw('sum(belum_kawin_lk) as total_belum_kawin_lk'),
            DB::raw('sum(belum_kawin_pr) as total_belum_kawin_pr'),
            DB::raw('sum(kawin_lk) as total_kawin_lk'),
            DB::raw('sum(kawin_pr) as total_kawin_pr'),
            DB::raw('sum(cerai_hidup_lk) as total_cerai_hidup_lk'),
            DB::raw('sum(cerai_hidup_pr) as total_cerai_hidup_pr'),
            DB::raw('sum(cerai_mati_lk) as total_cerai_mati_lk'),
            DB::raw('sum(cerai_mati_pr) as total_cerai_mati_pr'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_jenis_kelamin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_jenis_kelamin.semester', $request['semester'])
            ->where('status_kawin_penduduk_jenis_kelamin.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataStatusKawinPekerjaan($request)
    {
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
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = StatusKawinPendudukPekerjaan::select([
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_penduduk_pekerjaan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('status_kawin_penduduk_pekerjaan.semester', $request['semester'])
            ->where('status_kawin_penduduk_pekerjaan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    // calculate data DKB Pendidikan
    public function dataPendidikanPendudukJenisKelamin($request)
    {
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
            DB::raw('SUM(tidak_blm_sekolah_l) as total_tidak_blm_sekolah_l'),
            DB::raw('SUM(tidak_blm_sekolah_p) as total_tidak_blm_sekolah_p'),
            DB::raw('SUM(tidak_blm_sekolah_jml) as total_tidak_blm_sekolah_jml'),
            DB::raw('SUM(belum_tamat_sd_sederajat_l) as total_belum_tamat_sd_sederajat_l'),
            DB::raw('SUM(belum_tamat_sd_sederajat_p) as total_belum_tamat_sd_sederajat_p'),
            DB::raw('SUM(belum_tamat_sd_sederajat_jml) as total_belum_tamat_sd_sederajat_jml'),
            DB::raw('SUM(tamat_sd_sederajat_l) as total_tamat_sd_sederajat_l'),
            DB::raw('SUM(tamat_sd_sederajat_p) as total_tamat_sd_sederajat_p'),
            DB::raw('SUM(tamat_sd_sederajat_jml) as total_tamat_sd_sederajat_jml'),
            DB::raw('SUM(sltp_sederajat_l) as total_sltp_sederajat_l'),
            DB::raw('SUM(sltp_sederajat_p) as total_sltp_sederajat_p'),
            DB::raw('SUM(sltp_sederajat_jml) as total_sltp_sederajat_jml'),
            DB::raw('SUM(slta_sederajat_l) as total_slta_sederajat_l'),
            DB::raw('SUM(slta_sederajat_p) as total_slta_sederajat_p'),
            DB::raw('SUM(slta_sederajat_jml) as total_slta_sederajat_jml'),
            DB::raw('SUM(diploma_i_ii_l) as total_diploma_i_ii_l'),
            DB::raw('SUM(diploma_i_ii_p) as total_diploma_i_ii_p'),
            DB::raw('SUM(diploma_i_ii_jml) as total_diploma_i_ii_jml'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_l) as total_akademi_dipl_iii_s_muda_l'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_p) as total_akademi_dipl_iii_s_muda_p'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_jml) as total_akademi_dipl_iii_s_muda_jml'),
            DB::raw('SUM(diploma_iv_strata_i_l) as total_diploma_iv_strata_i_l'),
            DB::raw('SUM(diploma_iv_strata_i_p) as total_diploma_iv_strata_i_p'),
            DB::raw('SUM(diploma_iv_strata_i_jml) as total_diploma_iv_strata_i_jml'),
            DB::raw('SUM(strata_ii_l) as total_strata_ii_l'),
            DB::raw('SUM(strata_ii_p) as total_strata_ii_p'),
            DB::raw('SUM(strata_ii_jml) as total_strata_ii_jml'),
            DB::raw('SUM(strata_iii_l) as total_strata_iii_l'),
            DB::raw('SUM(strata_iii_p) as total_strata_iii_p'),
            DB::raw('SUM(strata_iii_jml) as total_strata_iii_jml')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendidikanPendudukJenisKelamin::select([
            DB::raw('SUM(tidak_blm_sekolah_l) as total_tidak_blm_sekolah_l'),
            DB::raw('SUM(tidak_blm_sekolah_p) as total_tidak_blm_sekolah_p'),
            DB::raw('SUM(tidak_blm_sekolah_jml) as total_tidak_blm_sekolah_jml'),
            DB::raw('SUM(belum_tamat_sd_sederajat_l) as total_belum_tamat_sd_sederajat_l'),
            DB::raw('SUM(belum_tamat_sd_sederajat_p) as total_belum_tamat_sd_sederajat_p'),
            DB::raw('SUM(belum_tamat_sd_sederajat_jml) as total_belum_tamat_sd_sederajat_jml'),
            DB::raw('SUM(tamat_sd_sederajat_l) as total_tamat_sd_sederajat_l'),
            DB::raw('SUM(tamat_sd_sederajat_p) as total_tamat_sd_sederajat_p'),
            DB::raw('SUM(tamat_sd_sederajat_jml) as total_tamat_sd_sederajat_jml'),
            DB::raw('SUM(sltp_sederajat_l) as total_sltp_sederajat_l'),
            DB::raw('SUM(sltp_sederajat_p) as total_sltp_sederajat_p'),
            DB::raw('SUM(sltp_sederajat_jml) as total_sltp_sederajat_jml'),
            DB::raw('SUM(slta_sederajat_l) as total_slta_sederajat_l'),
            DB::raw('SUM(slta_sederajat_p) as total_slta_sederajat_p'),
            DB::raw('SUM(slta_sederajat_jml) as total_slta_sederajat_jml'),
            DB::raw('SUM(diploma_i_ii_l) as total_diploma_i_ii_l'),
            DB::raw('SUM(diploma_i_ii_p) as total_diploma_i_ii_p'),
            DB::raw('SUM(diploma_i_ii_jml) as total_diploma_i_ii_jml'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_l) as total_akademi_dipl_iii_s_muda_l'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_p) as total_akademi_dipl_iii_s_muda_p'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_jml) as total_akademi_dipl_iii_s_muda_jml'),
            DB::raw('SUM(diploma_iv_strata_i_l) as total_diploma_iv_strata_i_l'),
            DB::raw('SUM(diploma_iv_strata_i_p) as total_diploma_iv_strata_i_p'),
            DB::raw('SUM(diploma_iv_strata_i_jml) as total_diploma_iv_strata_i_jml'),
            DB::raw('SUM(strata_ii_l) as total_strata_ii_l'),
            DB::raw('SUM(strata_ii_p) as total_strata_ii_p'),
            DB::raw('SUM(strata_ii_jml) as total_strata_ii_jml'),
            DB::raw('SUM(strata_iii_l) as total_strata_iii_l'),
            DB::raw('SUM(strata_iii_p) as total_strata_iii_p'),
            DB::raw('SUM(strata_iii_jml) as total_strata_iii_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
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
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendidikanPendudukPekerjaan::select([
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
            'pendidikan_penduduk_pekerjaan.pendidikan as keterangan_pendidikan',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_penduduk_pekerjaan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_penduduk_pekerjaan.semester', $request['semester'])
            ->where('pendidikan_penduduk_pekerjaan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function  dataPendidikanGolonganDarah($request)
    {
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
            DB::raw('SUM(a_lk) as a_lk'),
            DB::raw('SUM(a_pr) as a_pr'),
            DB::raw('SUM(a_jml) as a_jml'),
            DB::raw('SUM(a_m_lk) as a_m_lk'),
            DB::raw('SUM(a_m_pr) as a_m_pr'),
            DB::raw('SUM(a_m_jml) as a_m_jml'),
            DB::raw('SUM(a_p_lk) as a_p_lk'),
            DB::raw('SUM(a_p_pr) as a_p_pr'),
            DB::raw('SUM(a_p_jml) as a_p_jml'),
            DB::raw('SUM(b_lk) as b_lk'),
            DB::raw('SUM(b_pr) as b_pr'),
            DB::raw('SUM(b_jml) as b_jml'),
            DB::raw('SUM(b_m_lk) as b_m_lk'),
            DB::raw('SUM(b_m_pr) as b_m_pr'),
            DB::raw('SUM(b_m_jml) as b_m_jml'),
            DB::raw('SUM(b_p_lk) as b_p_lk'),
            DB::raw('SUM(b_p_pr) as b_p_pr'),
            DB::raw('SUM(b_p_jml) as b_p_jml'),
            DB::raw('SUM(ab_lk) as ab_lk'),
            DB::raw('SUM(ab_pr) as ab_pr'),
            DB::raw('SUM(ab_jml) as ab_jml'),
            DB::raw('SUM(ab_m_lk) as ab_m_lk'),
            DB::raw('SUM(ab_m_pr) as ab_m_pr'),
            DB::raw('SUM(ab_m_jml) as ab_m_jml'),
            DB::raw('SUM(ab_p_lk) as ab_p_lk'),
            DB::raw('SUM(ab_p_pr) as ab_p_pr'),
            DB::raw('SUM(ab_p_jml) as ab_p_jml'),
            DB::raw('SUM(o_lk) as o_lk'),
            DB::raw('SUM(o_pr) as o_pr'),
            DB::raw('SUM(o_jml) as o_jml'),
            DB::raw('SUM(o_m_lk) as o_m_lk'),
            DB::raw('SUM(o_m_pr) as o_m_pr'),
            DB::raw('SUM(o_m_jml) as o_m_jml'),
            DB::raw('SUM(o_p_lk) as o_p_lk'),
            DB::raw('SUM(o_p_pr) as o_p_pr'),
            DB::raw('SUM(o_p_jml) as o_p_jml'),
            DB::raw('SUM(tidak_tahu_lk) as tidak_tahu_lk'),
            DB::raw('SUM(tidak_tahu_pr) as tidak_tahu_pr'),
            DB::raw('SUM(tidak_tahu_jml) as tidak_tahu_jml'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = PendidikanPendudukJGolonganDarah::select([
            DB::raw('SUM(a_lk) as a_lk'),
            DB::raw('SUM(a_pr) as a_pr'),
            DB::raw('SUM(a_jml) as a_jml'),
            DB::raw('SUM(a_m_lk) as a_m_lk'),
            DB::raw('SUM(a_m_pr) as a_m_pr'),
            DB::raw('SUM(a_m_jml) as a_m_jml'),
            DB::raw('SUM(a_p_lk) as a_p_lk'),
            DB::raw('SUM(a_p_pr) as a_p_pr'),
            DB::raw('SUM(a_p_jml) as a_p_jml'),
            DB::raw('SUM(b_lk) as b_lk'),
            DB::raw('SUM(b_pr) as b_pr'),
            DB::raw('SUM(b_jml) as b_jml'),
            DB::raw('SUM(b_m_lk) as b_m_lk'),
            DB::raw('SUM(b_m_pr) as b_m_pr'),
            DB::raw('SUM(b_m_jml) as b_m_jml'),
            DB::raw('SUM(b_p_lk) as b_p_lk'),
            DB::raw('SUM(b_p_pr) as b_p_pr'),
            DB::raw('SUM(b_p_jml) as b_p_jml'),
            DB::raw('SUM(ab_lk) as ab_lk'),
            DB::raw('SUM(ab_pr) as ab_pr'),
            DB::raw('SUM(ab_jml) as ab_jml'),
            DB::raw('SUM(ab_m_lk) as ab_m_lk'),
            DB::raw('SUM(ab_m_pr) as ab_m_pr'),
            DB::raw('SUM(ab_m_jml) as ab_m_jml'),
            DB::raw('SUM(ab_p_lk) as ab_p_lk'),
            DB::raw('SUM(ab_p_pr) as ab_p_pr'),
            DB::raw('SUM(ab_p_jml) as ab_p_jml'),
            DB::raw('SUM(o_lk) as o_lk'),
            DB::raw('SUM(o_pr) as o_pr'),
            DB::raw('SUM(o_jml) as o_jml'),
            DB::raw('SUM(o_m_lk) as o_m_lk'),
            DB::raw('SUM(o_m_pr) as o_m_pr'),
            DB::raw('SUM(o_m_jml) as o_m_jml'),
            DB::raw('SUM(o_p_lk) as o_p_lk'),
            DB::raw('SUM(o_p_pr) as o_p_pr'),
            DB::raw('SUM(o_p_jml) as o_p_jml'),
            DB::raw('SUM(tidak_tahu_lk) as tidak_tahu_lk'),
            DB::raw('SUM(tidak_tahu_pr) as tidak_tahu_pr'),
            DB::raw('SUM(tidak_tahu_jml) as tidak_tahu_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'golongan_darah_pendidikan.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('golongan_darah_pendidikan.semester', $request['semester'])
            ->where('golongan_darah_pendidikan.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    // calculate data DKB disabilitas 
    public function dataDisabilitasJenisKelamin($request)
    {
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
            DB::raw('SUM(disabiltas_fisik_lk) as total_disabiltas_fisik_lk'),
            DB::raw('SUM(disabiltas_fisik_pr) as total_disabiltas_fisik_pr'),
            DB::raw('SUM(disabiltas_fisik_jml) as total_disabiltas_fisik_jml'),
            DB::raw('SUM(disabiltas_netra_buta_lk) as total_disabiltas_netra_buta_lk'),
            DB::raw('SUM(disabiltas_netra_buta_pr) as total_disabiltas_netra_buta_pr'),
            DB::raw('SUM(disabiltas_netra_buta_jml) as total_disabiltas_netra_buta_jml'),
            DB::raw('SUM(disabiltas_rungu_wicara_lk) as total_disabiltas_rungu_wicara_lk'),
            DB::raw('SUM(disabiltas_rungu_wicara_pr) as total_disabiltas_rungu_wicara_pr'),
            DB::raw('SUM(disabiltas_rungu_wicara_jml) as total_disabiltas_rungu_wicara_jml'),
            DB::raw('SUM(disabiltas_mental_jiwa_lk) as total_disabiltas_mental_jiwa_lk'),
            DB::raw('SUM(disabiltas_mental_jiwa_pr) as total_disabiltas_mental_jiwa_pr'),
            DB::raw('SUM(disabiltas_mental_jiwa_jml) as total_disabiltas_mental_jiwa_jml'),
            DB::raw('SUM(disabiltas_fisik_mental_lk) as total_disabiltas_fisik_mental_lk'),
            DB::raw('SUM(disabiltas_fisik_mental_pr) as total_disabiltas_fisik_mental_pr'),
            DB::raw('SUM(disabiltas_fisik_mental_jml) as total_disabiltas_fisik_mental_jml'),
            DB::raw('SUM(disabiltas_lainya_lk) as total_disabiltas_lainya_lk'),
            DB::raw('SUM(disabiltas_lainya_pr) as total_disabiltas_lainya_pr'),
            DB::raw('SUM(disabiltas_lainya_jml) as total_disabiltas_lainya_jml')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = DisabilitasPendudukJenisKelamin::select([
            DB::raw('SUM(disabiltas_fisik_lk) as total_disabiltas_fisik_lk'),
            DB::raw('SUM(disabiltas_fisik_pr) as total_disabiltas_fisik_pr'),
            DB::raw('SUM(disabiltas_fisik_jml) as total_disabiltas_fisik_jml'),
            DB::raw('SUM(disabiltas_netra_buta_lk) as total_disabiltas_netra_buta_lk'),
            DB::raw('SUM(disabiltas_netra_buta_pr) as total_disabiltas_netra_buta_pr'),
            DB::raw('SUM(disabiltas_netra_buta_jml) as total_disabiltas_netra_buta_jml'),
            DB::raw('SUM(disabiltas_rungu_wicara_lk) as total_disabiltas_rungu_wicara_lk'),
            DB::raw('SUM(disabiltas_rungu_wicara_pr) as total_disabiltas_rungu_wicara_pr'),
            DB::raw('SUM(disabiltas_rungu_wicara_jml) as total_disabiltas_rungu_wicara_jml'),
            DB::raw('SUM(disabiltas_mental_jiwa_lk) as total_disabiltas_mental_jiwa_lk'),
            DB::raw('SUM(disabiltas_mental_jiwa_pr) as total_disabiltas_mental_jiwa_pr'),
            DB::raw('SUM(disabiltas_mental_jiwa_jml) as total_disabiltas_mental_jiwa_jml'),
            DB::raw('SUM(disabiltas_fisik_mental_lk) as total_disabiltas_fisik_mental_lk'),
            DB::raw('SUM(disabiltas_fisik_mental_pr) as total_disabiltas_fisik_mental_pr'),
            DB::raw('SUM(disabiltas_fisik_mental_jml) as total_disabiltas_fisik_mental_jml'),
            DB::raw('SUM(disabiltas_lainya_lk) as total_disabiltas_lainya_lk'),
            DB::raw('SUM(disabiltas_lainya_pr) as total_disabiltas_lainya_pr'),
            DB::raw('SUM(disabiltas_lainya_jml) as total_disabiltas_lainya_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('jenis_kelamin_disabilitas.semester', $request['semester'])
            ->where('jenis_kelamin_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataDisabilitasPekerjaan($request)
    {
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
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();

        $dataPerkecamatan = DisabilitasPendudukPekerjaan::select([
            DB::raw('SUM(belum_tidak_bekerja_l) as belum_tidak_bekerja_l'),
            DB::raw('SUM(belum_tidak_bekerja_p) as belum_tidak_bekerja_p'),
            DB::raw('SUM(mengurus_rumah_tangga_l) as mengurus_rumah_tangga_l'),
            DB::raw('SUM(mengurus_rumah_tangga_p) as mengurus_rumah_tangga_p'),
            DB::raw('SUM(pelajar_mahasiswa_l) as pelajar_mahasiswa_l'),
            DB::raw('SUM(pelajar_mahasiswa_p) as pelajar_mahasiswa_p'),
            DB::raw('SUM(pensiunan_l) as pensiunan_l'),
            DB::raw('SUM(pensiunan_p) as pensiunan_p'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_l) as pegawai_negeri_sipil_pns_l'),
            DB::raw('SUM(pegawai_negeri_sipil_pns_p) as pegawai_negeri_sipil_pns_p'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_l) as tentara_nasional_indonesia_tni_l'),
            DB::raw('SUM(tentara_nasional_indonesia_tni_p) as tentara_nasional_indonesia_tni_p'),
            DB::raw('SUM(kepolisian_ri_polri_l) as kepolisian_ri_polri_l'),
            DB::raw('SUM(kepolisian_ri_polri_p) as kepolisian_ri_polri_p'),
            DB::raw('SUM(perdagangan_l) as perdagangan_l'),
            DB::raw('SUM(perdagangan_p) as perdagangan_p'),
            DB::raw('SUM(petani_pekebun_l) as petani_pekebun_l'),
            DB::raw('SUM(petani_pekebun_p) as petani_pekebun_p'),
            DB::raw('SUM(peternak_l) as peternak_l'),
            DB::raw('SUM(peternak_p) as peternak_p'),
            DB::raw('SUM(nelayan_perikanan_l) as nelayan_perikanan_l'),
            DB::raw('SUM(nelayan_perikanan_p) as nelayan_perikanan_p'),
            DB::raw('SUM(industri_l) as industri_l'),
            DB::raw('SUM(industri_p) as industri_p'),
            DB::raw('SUM(konstruksi_l) as konstruksi_l'),
            DB::raw('SUM(konstruksi_p) as konstruksi_p'),
            DB::raw('SUM(transportasi_l) as transportasi_l'),
            DB::raw('SUM(transportasi_p) as transportasi_p'),
            DB::raw('SUM(karyawan_swasta_l) as karyawan_swasta_l'),
            DB::raw('SUM(karyawan_swasta_p) as karyawan_swasta_p'),
            DB::raw('SUM(karyawan_bumn_l) as karyawan_bumn_l'),
            DB::raw('SUM(karyawan_bumn_p) as karyawan_bumn_p'),
            DB::raw('SUM(karyawan_bumd_l) as karyawan_bumd_l'),
            DB::raw('SUM(karyawan_bumd_p) as karyawan_bumd_p'),
            DB::raw('SUM(karyawan_honorer_l) as karyawan_honorer_l'),
            DB::raw('SUM(karyawan_honorer_p) as karyawan_honorer_p'),
            DB::raw('SUM(buruh_harian_lepas_l) as buruh_harian_lepas_l'),
            DB::raw('SUM(buruh_harian_lepas_p) as buruh_harian_lepas_p'),
            DB::raw('SUM(buruh_tani_perkebunan_l) as buruh_tani_perkebunan_l'),
            DB::raw('SUM(buruh_tani_perkebunan_p) as buruh_tani_perkebunan_p'),
            DB::raw('SUM(buruh_nelayan_perikanan_l) as buruh_nelayan_perikanan_l'),
            DB::raw('SUM(buruh_nelayan_perikanan_p) as buruh_nelayan_perikanan_p'),
            DB::raw('SUM(buruh_peternakan_l) as buruh_peternakan_l'),
            DB::raw('SUM(buruh_peternakan_p) as buruh_peternakan_p'),
            DB::raw('SUM(pembantu_rumah_tangga_l) as pembantu_rumah_tangga_l'),
            DB::raw('SUM(pembantu_rumah_tangga_p) as pembantu_rumah_tangga_p'),
            DB::raw('SUM(tukang_cukur_l) as tukang_cukur_l'),
            DB::raw('SUM(tukang_cukur_p) as tukang_cukur_p'),
            DB::raw('SUM(tukang_listrik_l) as tukang_listrik_l'),
            DB::raw('SUM(tukang_listrik_p) as tukang_listrik_p'),
            DB::raw('SUM(tukang_batu_l) as tukang_batu_l'),
            DB::raw('SUM(tukang_batu_p) as tukang_batu_p'),
            DB::raw('SUM(tukang_kayu_l) as tukang_kayu_l'),
            DB::raw('SUM(tukang_kayu_p) as tukang_kayu_p'),
            DB::raw('SUM(tukang_sol_sepatu_l) as tukang_sol_sepatu_l'),
            DB::raw('SUM(tukang_sol_sepatu_p) as tukang_sol_sepatu_p'),
            DB::raw('SUM(tukang_las_pandai_besi_l) as tukang_las_pandai_besi_l'),
            DB::raw('SUM(tukang_las_pandai_besi_p) as tukang_las_pandai_besi_p'),
            DB::raw('SUM(tukang_jahit_l) as tukang_jahit_l'),
            DB::raw('SUM(tukang_jahit_p) as tukang_jahit_p'),
            DB::raw('SUM(tukang_gigi_l) as tukang_gigi_l'),
            DB::raw('SUM(tukang_gigi_p) as tukang_gigi_p'),
            DB::raw('SUM(penata_rias_l) as penata_rias_l'),
            DB::raw('SUM(penata_rias_p) as penata_rias_p'),
            DB::raw('SUM(penata_busana_l) as penata_busana_l'),
            DB::raw('SUM(penata_busana_p) as penata_busana_p'),
            DB::raw('SUM(penata_rambut_l) as penata_rambut_l'),
            DB::raw('SUM(penata_rambut_p) as penata_rambut_p'),
            DB::raw('SUM(mekanik_l) as mekanik_l'),
            DB::raw('SUM(mekanik_p) as mekanik_p'),
            DB::raw('SUM(seniman_l) as seniman_l'),
            DB::raw('SUM(seniman_p) as seniman_p'),
            DB::raw('SUM(tabib_l) as tabib_l'),
            DB::raw('SUM(tabib_p) as tabib_p'),
            DB::raw('SUM(paraji_l) as paraji_l'),
            DB::raw('SUM(paraji_p) as paraji_p'),
            DB::raw('SUM(perancang_busana_l) as perancang_busana_l'),
            DB::raw('SUM(perancang_busana_p) as perancang_busana_p'),
            DB::raw('SUM(penterjemah_l) as penterjemah_l'),
            DB::raw('SUM(penterjemah_p) as penterjemah_p'),
            DB::raw('SUM(imam_masjid_l) as imam_masjid_l'),
            DB::raw('SUM(imam_masjid_p) as imam_masjid_p'),
            DB::raw('SUM(pendeta_l) as pendeta_l'),
            DB::raw('SUM(pendeta_p) as pendeta_p'),
            DB::raw('SUM(pastor_l) as pastor_l'),
            DB::raw('SUM(pastor_p) as pastor_p'),
            DB::raw('SUM(wartawan_l) as wartawan_l'),
            DB::raw('SUM(wartawan_p) as wartawan_p'),
            DB::raw('SUM(ustadz_mubaligh_l) as ustadz_mubaligh_l'),
            DB::raw('SUM(ustadz_mubaligh_p) as ustadz_mubaligh_p'),
            DB::raw('SUM(juru_masak_l) as juru_masak_l'),
            DB::raw('SUM(juru_masak_p) as juru_masak_p'),
            DB::raw('SUM(promotor_acara_l) as promotor_acara_l'),
            DB::raw('SUM(promotor_acara_p) as promotor_acara_p'),
            DB::raw('SUM(anggota_dpr_ri_l) as anggota_dpr_ri_l'),
            DB::raw('SUM(anggota_dpr_ri_p) as anggota_dpr_ri_p'),
            DB::raw('SUM(anggota_dpd_ri_l) as anggota_dpd_ri_l'),
            DB::raw('SUM(anggota_dpd_ri_p) as anggota_dpd_ri_p'),
            DB::raw('SUM(anggota_bpk_l) as anggota_bpk_l'),
            DB::raw('SUM(anggota_bpk_p) as anggota_bpk_p'),
            DB::raw('SUM(presiden_l) as presiden_l'),
            DB::raw('SUM(presiden_p) as presiden_p'),
            DB::raw('SUM(wakil_presiden_l) as wakil_presiden_l'),
            DB::raw('SUM(wakil_presiden_p) as wakil_presiden_p'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_l) as anggota_mahkamah_konstitusi_l'),
            DB::raw('SUM(anggota_mahkamah_konstitusi_p) as anggota_mahkamah_konstitusi_p'),
            DB::raw('SUM(anggota_kabinet_kementerian_l) as anggota_kabinet_kementerian_l'),
            DB::raw('SUM(anggota_kabinet_kementerian_p) as anggota_kabinet_kementerian_p'),
            DB::raw('SUM(duta_besar_l) as duta_besar_l'),
            DB::raw('SUM(duta_besar_p) as duta_besar_p'),
            DB::raw('SUM(gubernur_l) as gubernur_l'),
            DB::raw('SUM(gubernur_p) as gubernur_p'),
            DB::raw('SUM(wakil_gubernur_l) as wakil_gubernur_l'),
            DB::raw('SUM(wakil_gubernur_p) as wakil_gubernur_p'),
            DB::raw('SUM(bupati_l) as bupati_l'),
            DB::raw('SUM(bupati_p) as bupati_p'),
            DB::raw('SUM(wakil_bupati_l) as wakil_bupati_l'),
            DB::raw('SUM(wakil_bupati_p) as wakil_bupati_p'),
            DB::raw('SUM(walikota_l) as walikota_l'),
            DB::raw('SUM(walikota_p) as walikota_p'),
            DB::raw('SUM(wakil_walikota_l) as wakil_walikota_l'),
            DB::raw('SUM(wakil_walikota_p) as wakil_walikota_p'),
            DB::raw('SUM(anggota_dprd_prop_l) as anggota_dprd_prop_l'),
            DB::raw('SUM(anggota_dprd_prop_p) as anggota_dprd_prop_p'),
            DB::raw('SUM(anggota_dprd_kab_kota_l) as anggota_dprd_kab_kota_l'),
            DB::raw('SUM(anggota_dprd_kab_kota_p) as anggota_dprd_kab_kota_p'),
            DB::raw('SUM(dosen_l) as dosen_l'),
            DB::raw('SUM(dosen_p) as dosen_p'),
            DB::raw('SUM(guru_l) as guru_l'),
            DB::raw('SUM(guru_p) as guru_p'),
            DB::raw('SUM(pilot_l) as pilot_l'),
            DB::raw('SUM(pilot_p) as pilot_p'),
            DB::raw('SUM(pengacara_l) as pengacara_l'),
            DB::raw('SUM(pengacara_p) as pengacara_p'),
            DB::raw('SUM(notaris_l) as notaris_l'),
            DB::raw('SUM(notaris_p) as notaris_p'),
            DB::raw('SUM(arsitek_l) as arsitek_l'),
            DB::raw('SUM(arsitek_p) as arsitek_p'),
            DB::raw('SUM(akuntan_l) as akuntan_l'),
            DB::raw('SUM(akuntan_p) as akuntan_p'),
            DB::raw('SUM(konsultan_l) as konsultan_l'),
            DB::raw('SUM(konsultan_p) as konsultan_p'),
            DB::raw('SUM(dokter_l) as dokter_l'),
            DB::raw('SUM(dokter_p) as dokter_p'),
            DB::raw('SUM(bidan_l) as bidan_l'),
            DB::raw('SUM(bidan_p) as bidan_p'),
            DB::raw('SUM(perawat_l) as perawat_l'),
            DB::raw('SUM(perawat_p) as perawat_p'),
            DB::raw('SUM(apotek_l) as apotek_l'),
            DB::raw('SUM(apotek_p) as apotek_p'),
            DB::raw('SUM(psikiater_psikolog_l) as psikiater_psikolog_l'),
            DB::raw('SUM(psikiater_psikolog_p) as psikiater_psikolog_p'),
            DB::raw('SUM(penyiara_televisi_l) as penyiara_televisi_l'),
            DB::raw('SUM(penyiara_televisi_p) as penyiara_televisi_p'),
            DB::raw('SUM(penyiara_radio_l) as penyiara_radio_l'),
            DB::raw('SUM(penyiara_radio_p) as penyiara_radio_p'),
            DB::raw('SUM(pelaut_l) as pelaut_l'),
            DB::raw('SUM(pelaut_p) as pelaut_p'),
            DB::raw('SUM(peneliti_l) as peneliti_l'),
            DB::raw('SUM(peneliti_p) as peneliti_p'),
            DB::raw('SUM(sopir_l) as sopir_l'),
            DB::raw('SUM(sopir_p) as sopir_p'),
            DB::raw('SUM(pialang_l) as pialang_l'),
            DB::raw('SUM(pialang_p) as pialang_p'),
            DB::raw('SUM(paranormal_l) as paranormal_l'),
            DB::raw('SUM(paranormal_p) as paranormal_p'),
            DB::raw('SUM(pedagang_l) as pedagang_l'),
            DB::raw('SUM(pedagang_p) as pedagang_p'),
            DB::raw('SUM(perangkat_desa_l) as perangkat_desa_l'),
            DB::raw('SUM(perangkat_desa_p) as perangkat_desa_p'),
            DB::raw('SUM(kepala_desa_l) as kepala_desa_l'),
            DB::raw('SUM(kepala_desa_p) as kepala_desa_p'),
            DB::raw('SUM(biarawan_biarawati_l) as biarawan_biarawati_l'),
            DB::raw('SUM(biarawan_biarawati_p) as biarawan_biarawati_p'),
            DB::raw('SUM(wiraswasta_l) as wiraswasta_l'),
            DB::raw('SUM(wiraswasta_p) as wiraswasta_p'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_l) as anggota_lembaga_tinggi_lainnya_l'),
            DB::raw('SUM(anggota_lembaga_tinggi_lainnya_p) as anggota_lembaga_tinggi_lainnya_p'),
            DB::raw('SUM(artis_l) as artis_l'),
            DB::raw('SUM(artis_p) as artis_p'),
            DB::raw('SUM(atlit_l) as atlit_l'),
            DB::raw('SUM(atlit_p) as atlit_p'),
            DB::raw('SUM(chef_l) as chef_l'),
            DB::raw('SUM(chef_p) as chef_p'),
            DB::raw('SUM(manajer_l) as manajer_l'),
            DB::raw('SUM(manajer_p) as manajer_p'),
            DB::raw('SUM(tenaga_tata_usaha_l) as tenaga_tata_usaha_l'),
            DB::raw('SUM(tenaga_tata_usaha_p) as tenaga_tata_usaha_p'),
            DB::raw('SUM(operator_l) as operator_l'),
            DB::raw('SUM(operator_p) as operator_p'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_l) as pekerja_pengolahan_krajinan_l'),
            DB::raw('SUM(pekerja_pengolahan_krajinan_p) as pekerja_pengolahan_krajinan_p'),
            DB::raw('SUM(teknisi_l) as teknisi_l'),
            DB::raw('SUM(teknisi_p) as teknisi_p'),
            DB::raw('SUM(asisten_ahli_l) as asisten_ahli_l'),
            DB::raw('SUM(asisten_ahli_p) as asisten_ahli_p'),
            DB::raw('SUM(pekerjaan_lainnya_l) as pekerjaan_lainnya_l'),
            DB::raw('SUM(pekerjaan_lainnya_p) as pekerjaan_lainnya_p'),
            'pekerjaan_disabilitas.keterangan as disabilitas_keterangan',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_disabilitas.semester', $request['semester'])
            ->where('pekerjaan_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataDisabilitasPendidikan($request)
    {
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
            DB::raw('SUM(tidak_blm_sekolah_l) as total_tidak_blm_sekolah_l'),
            DB::raw('SUM(tidak_blm_sekolah_p) as total_tidak_blm_sekolah_p'),
            DB::raw('SUM(tidak_blm_sekolah_jml) as total_tidak_blm_sekolah_jml'),
            DB::raw('SUM(belum_tamat_sd_sederajat_l) as total_belum_tamat_sd_sederajat_l'),
            DB::raw('SUM(belum_tamat_sd_sederajat_p) as total_belum_tamat_sd_sederajat_p'),
            DB::raw('SUM(belum_tamat_sd_sederajat_jml) as total_belum_tamat_sd_sederajat_jml'),
            DB::raw('SUM(tamat_sd_sederajat_l) as total_tamat_sd_sederajat_l'),
            DB::raw('SUM(tamat_sd_sederajat_p) as total_tamat_sd_sederajat_p'),
            DB::raw('SUM(tamat_sd_sederajat_jml) as total_tamat_sd_sederajat_jml'),
            DB::raw('SUM(sltp_sederajat_l) as total_sltp_sederajat_l'),
            DB::raw('SUM(sltp_sederajat_p) as total_sltp_sederajat_p'),
            DB::raw('SUM(sltp_sederajat_jml) as total_sltp_sederajat_jml'),
            DB::raw('SUM(slta_sederajat_l) as total_slta_sederajat_l'),
            DB::raw('SUM(slta_sederajat_p) as total_slta_sederajat_p'),
            DB::raw('SUM(slta_sederajat_jml) as total_slta_sederajat_jml'),
            DB::raw('SUM(diploma_i_ii_l) as total_diploma_i_ii_l'),
            DB::raw('SUM(diploma_i_ii_p) as total_diploma_i_ii_p'),
            DB::raw('SUM(diploma_i_ii_jml) as total_diploma_i_ii_jml'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_l) as total_akademi_dipl_iii_s_muda_l'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_p) as total_akademi_dipl_iii_s_muda_p'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_jml) as total_akademi_dipl_iii_s_muda_jml'),
            DB::raw('SUM(diploma_iv_strata_i_l) as total_diploma_iv_strata_i_l'),
            DB::raw('SUM(diploma_iv_strata_i_p) as total_diploma_iv_strata_i_p'),
            DB::raw('SUM(diploma_iv_strata_i_jml) as total_diploma_iv_strata_i_jml'),
            DB::raw('SUM(strata_ii_l) as total_strata_ii_l'),
            DB::raw('SUM(strata_ii_p) as total_strata_ii_p'),
            DB::raw('SUM(strata_ii_jml) as total_strata_ii_jml'),
            DB::raw('SUM(strata_iii_l) as total_strata_iii_l'),
            DB::raw('SUM(strata_iii_p) as total_strata_iii_p'),
            DB::raw('SUM(strata_iii_jml) as total_strata_iii_jml'),
            'pendidikan_disabilitas.keterangan as disabilitas_keterangan'
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = DisabilitasPendudukPendidikan::select([
            DB::raw('SUM(tidak_blm_sekolah_l) as total_tidak_blm_sekolah_l'),
            DB::raw('SUM(tidak_blm_sekolah_p) as total_tidak_blm_sekolah_p'),
            DB::raw('SUM(tidak_blm_sekolah_jml) as total_tidak_blm_sekolah_jml'),
            DB::raw('SUM(belum_tamat_sd_sederajat_l) as total_belum_tamat_sd_sederajat_l'),
            DB::raw('SUM(belum_tamat_sd_sederajat_p) as total_belum_tamat_sd_sederajat_p'),
            DB::raw('SUM(belum_tamat_sd_sederajat_jml) as total_belum_tamat_sd_sederajat_jml'),
            DB::raw('SUM(tamat_sd_sederajat_l) as total_tamat_sd_sederajat_l'),
            DB::raw('SUM(tamat_sd_sederajat_p) as total_tamat_sd_sederajat_p'),
            DB::raw('SUM(tamat_sd_sederajat_jml) as total_tamat_sd_sederajat_jml'),
            DB::raw('SUM(sltp_sederajat_l) as total_sltp_sederajat_l'),
            DB::raw('SUM(sltp_sederajat_p) as total_sltp_sederajat_p'),
            DB::raw('SUM(sltp_sederajat_jml) as total_sltp_sederajat_jml'),
            DB::raw('SUM(slta_sederajat_l) as total_slta_sederajat_l'),
            DB::raw('SUM(slta_sederajat_p) as total_slta_sederajat_p'),
            DB::raw('SUM(slta_sederajat_jml) as total_slta_sederajat_jml'),
            DB::raw('SUM(diploma_i_ii_l) as total_diploma_i_ii_l'),
            DB::raw('SUM(diploma_i_ii_p) as total_diploma_i_ii_p'),
            DB::raw('SUM(diploma_i_ii_jml) as total_diploma_i_ii_jml'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_l) as total_akademi_dipl_iii_s_muda_l'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_p) as total_akademi_dipl_iii_s_muda_p'),
            DB::raw('SUM(akademi_dipl_iii_s_muda_jml) as total_akademi_dipl_iii_s_muda_jml'),
            DB::raw('SUM(diploma_iv_strata_i_l) as total_diploma_iv_strata_i_l'),
            DB::raw('SUM(diploma_iv_strata_i_p) as total_diploma_iv_strata_i_p'),
            DB::raw('SUM(diploma_iv_strata_i_jml) as total_diploma_iv_strata_i_jml'),
            DB::raw('SUM(strata_ii_l) as total_strata_ii_l'),
            DB::raw('SUM(strata_ii_p) as total_strata_ii_p'),
            DB::raw('SUM(strata_ii_jml) as total_strata_ii_jml'),
            DB::raw('SUM(strata_iii_l) as total_strata_iii_l'),
            DB::raw('SUM(strata_iii_p) as total_strata_iii_p'),
            DB::raw('SUM(strata_iii_jml) as total_strata_iii_jml'),
            'pendidikan_disabilitas.keterangan as keterangan_disabilitas',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_disabilitas.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pendidikan_disabilitas.semester', $request['semester'])
            ->where('pendidikan_disabilitas.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    // calculate data DKB kepemilikan akta kelahiran
    public function dataKepemilikanAktaKelahiran($request)
    {
        $dataPerkelurahan = KepemilikanAktaKelahiran::select([
            'akta_kelahiran.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kelahiran.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kelahiran.semester', $request['semester'])
            ->where('akta_kelahiran.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = KepemilikanAktaKelahiran::select(
            // Wajib Akta Awal
            DB::raw('SUM(wajib_akta_awal_lk) as total_wajib_akta_awal_lk'),
            DB::raw('SUM(wajib_akta_awal_pr) as total_wajib_akta_awal_pr'),
            DB::raw('SUM(wajib_akta_awal_jml) as total_wajib_akta_awal_jml'),

            // Memiliki Akta Awal
            DB::raw('SUM(memiliki_awal_lk) as total_memiliki_awal_lk'),
            DB::raw('SUM(memiliki_awal_pr) as total_memiliki_awal_pr'),
            DB::raw('SUM(memiliki_awal_jml) as total_memiliki_awal_jml'),

            // Belum Memiliki Akta Awal
            DB::raw('SUM(belum_memiliki_awal_lk) as total_belum_memiliki_awal_lk'),
            DB::raw('SUM(belum_memiliki_awal_pr) as total_belum_memiliki_awal_pr'),
            DB::raw('SUM(belum_memiliki_awal_jml) as total_belum_memiliki_awal_jml'),

            // Persen Awal
            DB::raw('IF(SUM(wajib_akta_awal_jml) = 0, 0, SUM(memiliki_awal_jml) / SUM(wajib_akta_awal_jml) * 100) as persen_memiliki_awal'),

            // Usia Lebih dari Target
            DB::raw('SUM(usia_lebih_dari_target_lk) as total_usia_lebih_dari_target_lk'),
            DB::raw('SUM(usia_lebih_dari_target_pr) as total_usia_lebih_dari_target_pr'),
            DB::raw('SUM(usia_lebih_dari_target_jml) as total_usia_lebih_dari_target_jml'),

            // Meninggal
            DB::raw('SUM(meninggal_lk) as total_meninggal_lk'),
            DB::raw('SUM(meninggal_pr) as total_meninggal_pr'),
            DB::raw('SUM(meninggal_jml) as total_meninggal_jml'),

            // Nonaktif
            DB::raw('SUM(nonaktif_lk) as total_nonaktif_lk'),
            DB::raw('SUM(nonaktif_pr) as total_nonaktif_pr'),
            DB::raw('SUM(nonaktif_jml) as total_nonaktif_jml'),

            // Pindah
            DB::raw('SUM(pindah_lk) as total_pindah_lk'),
            DB::raw('SUM(pindah_pr) as total_pindah_pr'),
            DB::raw('SUM(pindah_jml) as total_pindah_jml'),

            // Datang
            DB::raw('SUM(datang_lk) as total_datang_lk'),
            DB::raw('SUM(datang_pr) as total_datang_pr'),
            DB::raw('SUM(datang_jml) as total_datang_jml'),

            // Hapus Operator
            DB::raw('SUM(hapus_operator_lk) as total_hapus_operator_lk'),
            DB::raw('SUM(hapus_operator_pr) as total_hapus_operator_pr'),
            DB::raw('SUM(hapus_operator_jml) as total_hapus_operator_jml'),

            // Terbit Akta Baru Dalam DKB
            DB::raw('SUM(terbit_akta_baru_dalam_dkb_lk) as total_terbit_akta_baru_dalam_dkb_lk'),
            DB::raw('SUM(terbit_akta_baru_dalam_dkb_pr) as total_terbit_akta_baru_dalam_dkb_pr'),
            DB::raw('SUM(terbit_akta_baru_dalam_dkb_jml) as total_terbit_akta_baru_dalam_dkb_jml'),

            // Terbit Akta Baru Luar DKB
            DB::raw('SUM(terbit_akta_baru_luar_dkb_lk) as total_terbit_akta_baru_luar_dkb_lk'),
            DB::raw('SUM(terbit_akta_baru_luar_dkb_pr) as total_terbit_akta_baru_luar_dkb_pr'),
            DB::raw('SUM(terbit_akta_baru_luar_dkb_jml) as total_terbit_akta_baru_luar_dkb_jml'),

            // Wajib Akta Dinamis
            DB::raw('SUM(wajib_akta_dinamis_lk) as total_wajib_akta_dinamis_lk'),
            DB::raw('SUM(wajib_akta_dinamis_pr) as total_wajib_akta_dinamis_pr'),
            DB::raw('SUM(wajib_akta_dinamis_jml) as total_wajib_akta_dinamis_jml'),

            // Memiliki Akta Dinamis
            DB::raw('SUM(memiliki_dinamis_lk) as total_memiliki_dinamis_lk'),
            DB::raw('SUM(memiliki_dinamis_pr) as total_memiliki_dinamis_pr'),
            DB::raw('SUM(memiliki_dinamis_jml) as total_memiliki_dinamis_jml'),

            // Belum Memiliki Akta Dinamis
            DB::raw('SUM(belum_memiliki_dinamis_lk) as total_belum_memiliki_dinamis_lk'),
            DB::raw('SUM(belum_memiliki_dinamis_pr) as total_belum_memiliki_dinamis_pr'),
            DB::raw('SUM(belum_memiliki_dinamis_jml) as total_belum_memiliki_dinamis_jml'),

            // Persen Dinamis
            DB::raw('IF(SUM(wajib_akta_dinamis_jml) = 0, 0, SUM(memiliki_dinamis_jml) / SUM(wajib_akta_dinamis_jml) * 100) as persen_memiliki_dinamis'),

            // Penambahan
            DB::raw('SUM(penambahan_lk) as total_penambahan_lk'),
            DB::raw('SUM(penambahan_pr) as total_penambahan_pr'),
            DB::raw('SUM(penambahan_jml) as total_penambahan_jml'),
            'akta_kelahiran.keterangan as keterangan_umur'
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = KepemilikanAktaKelahiran::select([
            // Wajib Akta Awal
            DB::raw('SUM(wajib_akta_awal_lk) as total_wajib_akta_awal_lk'),
            DB::raw('SUM(wajib_akta_awal_pr) as total_wajib_akta_awal_pr'),
            DB::raw('SUM(wajib_akta_awal_jml) as total_wajib_akta_awal_jml'),

            // Memiliki Akta Awal
            DB::raw('SUM(memiliki_awal_lk) as total_memiliki_awal_lk'),
            DB::raw('SUM(memiliki_awal_pr) as total_memiliki_awal_pr'),
            DB::raw('SUM(memiliki_awal_jml) as total_memiliki_awal_jml'),

            // Belum Memiliki Akta Awal
            DB::raw('SUM(belum_memiliki_awal_lk) as total_belum_memiliki_awal_lk'),
            DB::raw('SUM(belum_memiliki_awal_pr) as total_belum_memiliki_awal_pr'),
            DB::raw('SUM(belum_memiliki_awal_jml) as total_belum_memiliki_awal_jml'),

            // Persen Awal
            DB::raw('IF(SUM(wajib_akta_awal_jml) = 0, 0, SUM(memiliki_awal_jml) / SUM(wajib_akta_awal_jml) * 100) as persen_memiliki_awal'),

            // Usia Lebih dari Target
            DB::raw('SUM(usia_lebih_dari_target_lk) as total_usia_lebih_dari_target_lk'),
            DB::raw('SUM(usia_lebih_dari_target_pr) as total_usia_lebih_dari_target_pr'),
            DB::raw('SUM(usia_lebih_dari_target_jml) as total_usia_lebih_dari_target_jml'),

            // Meninggal
            DB::raw('SUM(meninggal_lk) as total_meninggal_lk'),
            DB::raw('SUM(meninggal_pr) as total_meninggal_pr'),
            DB::raw('SUM(meninggal_jml) as total_meninggal_jml'),

            // Nonaktif
            DB::raw('SUM(nonaktif_lk) as total_nonaktif_lk'),
            DB::raw('SUM(nonaktif_pr) as total_nonaktif_pr'),
            DB::raw('SUM(nonaktif_jml) as total_nonaktif_jml'),

            // Pindah
            DB::raw('SUM(pindah_lk) as total_pindah_lk'),
            DB::raw('SUM(pindah_pr) as total_pindah_pr'),
            DB::raw('SUM(pindah_jml) as total_pindah_jml'),

            // Datang
            DB::raw('SUM(datang_lk) as total_datang_lk'),
            DB::raw('SUM(datang_pr) as total_datang_pr'),
            DB::raw('SUM(datang_jml) as total_datang_jml'),

            // Hapus Operator
            DB::raw('SUM(hapus_operator_lk) as total_hapus_operator_lk'),
            DB::raw('SUM(hapus_operator_pr) as total_hapus_operator_pr'),
            DB::raw('SUM(hapus_operator_jml) as total_hapus_operator_jml'),

            // Terbit Akta Baru Dalam DKB
            DB::raw('SUM(terbit_akta_baru_dalam_dkb_lk) as total_terbit_akta_baru_dalam_dkb_lk'),
            DB::raw('SUM(terbit_akta_baru_dalam_dkb_pr) as total_terbit_akta_baru_dalam_dkb_pr'),
            DB::raw('SUM(terbit_akta_baru_dalam_dkb_jml) as total_terbit_akta_baru_dalam_dkb_jml'),

            // Terbit Akta Baru Luar DKB
            DB::raw('SUM(terbit_akta_baru_luar_dkb_lk) as total_terbit_akta_baru_luar_dkb_lk'),
            DB::raw('SUM(terbit_akta_baru_luar_dkb_pr) as total_terbit_akta_baru_luar_dkb_pr'),
            DB::raw('SUM(terbit_akta_baru_luar_dkb_jml) as total_terbit_akta_baru_luar_dkb_jml'),

            // Wajib Akta Dinamis
            DB::raw('SUM(wajib_akta_dinamis_lk) as total_wajib_akta_dinamis_lk'),
            DB::raw('SUM(wajib_akta_dinamis_pr) as total_wajib_akta_dinamis_pr'),
            DB::raw('SUM(wajib_akta_dinamis_jml) as total_wajib_akta_dinamis_jml'),

            // Memiliki Akta Dinamis
            DB::raw('SUM(memiliki_dinamis_lk) as total_memiliki_dinamis_lk'),
            DB::raw('SUM(memiliki_dinamis_pr) as total_memiliki_dinamis_pr'),
            DB::raw('SUM(memiliki_dinamis_jml) as total_memiliki_dinamis_jml'),

            // Belum Memiliki Akta Dinamis
            DB::raw('SUM(belum_memiliki_dinamis_lk) as total_belum_memiliki_dinamis_lk'),
            DB::raw('SUM(belum_memiliki_dinamis_pr) as total_belum_memiliki_dinamis_pr'),
            DB::raw('SUM(belum_memiliki_dinamis_jml) as total_belum_memiliki_dinamis_jml'),

            // Persen Dinamis
            DB::raw('IF(SUM(wajib_akta_dinamis_jml) = 0, 0, SUM(memiliki_dinamis_jml) / SUM(wajib_akta_dinamis_jml) * 100) as persen_memiliki_dinamis'),

            // Penambahan
            DB::raw('SUM(penambahan_lk) as total_penambahan_lk'),
            DB::raw('SUM(penambahan_pr) as total_penambahan_pr'),
            DB::raw('SUM(penambahan_jml) as total_penambahan_jml'),
            'akta_kelahiran.keterangan as keterangan_umur',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kelahiran.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kelahiran.semester', $request['semester'])
            ->where('akta_kelahiran.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepemilikanAktaPerkawinan($request)
    {
        $dataPerkelurahan = KepemilikanAktaKawin::select([
            'akta_kawin.*',
            'mstr_kelurahan.nama as kelurahan_nama',
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin.semester', $request['semester'])
            ->where('akta_kawin.tahun', $request['tahun'])
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        $dataKeseluruhan = PendudukJenisKelamin::select(
            // Muslim and Non-Muslim
            DB::raw('SUM(muslim_jml) as total_muslim_jml'),
            DB::raw('SUM(non_muslim_jml) as total_non_muslim_jml'),

            // Status Kawin
            DB::raw('SUM(status_kawin_lk) as total_status_kawin_lk'),
            DB::raw('SUM(status_kawin_pr) as total_status_kawin_pr'),
            DB::raw('SUM(status_kawin_jml) as total_status_kawin_jml'),

            // Memiliki Akta Kawin
            DB::raw('SUM(memiliki_akta_kawin_lk) as total_memiliki_akta_kawin_lk'),
            DB::raw('SUM(memiliki_akta_kawin_pr) as total_memiliki_akta_kawin_pr'),
            DB::raw('SUM(memiliki_akta_kawin_jml) as total_memiliki_akta_kawin_jml'),

            // Belum Memiliki Akta Kawin
            DB::raw('SUM(belum_memiliki_akta_kawin_jml) as total_belum_memiliki_akta_kawin_jml'),

            // Persen Memiliki
            DB::raw('IF(SUM(status_kawin_jml) = 0, 0, SUM(memiliki_akta_kawin_jml) / SUM(status_kawin_jml) * 100) as persen_memiliki')
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();

        $dataPerkecamatan = PendudukJenisKelamin::select([
            // Muslim and Non-Muslim
            DB::raw('SUM(muslim_jml) as total_muslim_jml'),
            DB::raw('SUM(non_muslim_jml) as total_non_muslim_jml'),

            // Status Kawin
            DB::raw('SUM(status_kawin_lk) as total_status_kawin_lk'),
            DB::raw('SUM(status_kawin_pr) as total_status_kawin_pr'),
            DB::raw('SUM(status_kawin_jml) as total_status_kawin_jml'),

            // Memiliki Akta Kawin
            DB::raw('SUM(memiliki_akta_kawin_lk) as total_memiliki_akta_kawin_lk'),
            DB::raw('SUM(memiliki_akta_kawin_pr) as total_memiliki_akta_kawin_pr'),
            DB::raw('SUM(memiliki_akta_kawin_jml) as total_memiliki_akta_kawin_jml'),

            // Belum Memiliki Akta Kawin
            DB::raw('SUM(belum_memiliki_akta_kawin_jml) as total_belum_memiliki_akta_kawin_jml'),
            // Persen Memiliki
            DB::raw('IF(SUM(status_kawin_jml) = 0, 0, SUM(memiliki_akta_kawin_jml) / SUM(status_kawin_jml) * 100) as persen_memiliki'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin.semester', $request['semester'])
            ->where('akta_kawin.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataKepemilikanAktaPerkawinanAgama($request)
    {
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
        $dataPerkecamatan = KepemilikanAktaKawinAgama::select([
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
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kawin_agama.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('akta_kawin_agama.semester', $request['semester'])
            ->where('akta_kawin_agama.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->get();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
