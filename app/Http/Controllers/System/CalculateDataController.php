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
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataPendudukGoldar($request)
    {
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
        $dataPerkecamatan = PendudukGolonganDarah::select([
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
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'golongan_darah_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('golongan_darah_penduduk.semester', $request['semester'])
            ->where('golongan_darah_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }

    public function dataPendudukHubKel($request)
    {
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
            DB::raw('SUM(kepala_keluarga_l) as kepala_keluarga_l'),
            DB::raw('SUM(kepala_keluarga_p) as kepala_keluarga_p'),
            DB::raw('SUM(kepala_keluarga_jml) as kepala_keluarga_jml'),
            DB::raw('SUM(suami_l) as suami_l'),
            DB::raw('SUM(suami_p) as suami_p'),
            DB::raw('SUM(suami_jml) as suami_jml'),
            DB::raw('SUM(isteri_l) as isteri_l'),
            DB::raw('SUM(isteri_p) as isteri_p'),
            DB::raw('SUM(isteri_jml) as isteri_jml'),
            DB::raw('SUM(anak_l) as anak_l'),
            DB::raw('SUM(anak_p) as anak_p'),
            DB::raw('SUM(anak_jml) as anak_jml'),
            DB::raw('SUM(menantu_l) as menantu_l'),
            DB::raw('SUM(menantu_p) as menantu_p'),
            DB::raw('SUM(menantu_jml) as menantu_jml'),
            DB::raw('SUM(cucu_l) as cucu_l'),
            DB::raw('SUM(cucu_p) as cucu_p'),
            DB::raw('SUM(cucu_jml) as cucu_jml'),
            DB::raw('SUM(orang_tua_l) as orang_tua_l'),
            DB::raw('SUM(orang_tua_p) as orang_tua_p'),
            DB::raw('SUM(orang_tua_jml) as orang_tua_jml'),
            DB::raw('SUM(mertua_l) as mertua_l'),
            DB::raw('SUM(mertua_p) as mertua_p'),
            DB::raw('SUM(mertua_jml) as mertua_jml'),
            DB::raw('SUM(famili_lain_l) as famili_lain_l'),
            DB::raw('SUM(famili_lain_p) as famili_lain_p'),
            DB::raw('SUM(famili_lain_jml) as famili_lain_jml'),
            DB::raw('SUM(pembantu_l) as pembantu_l'),
            DB::raw('SUM(pembantu_p) as pembantu_p'),
            DB::raw('SUM(pembantu_jml) as pembantu_jml'),
            DB::raw('SUM(lainnya_l) as lainnya_l'),
            DB::raw('SUM(lainnya_p) as lainnya_p'),
            DB::raw('SUM(lainnya_jml) as lainnya_jml'),
        )->where('semester', $request['semester'])
            ->where('tahun', $request['tahun'])
            ->first();
        $dataPerkecamatan = HubunganKeluarga::select([
            DB::raw('SUM(kepala_keluarga_l) as kepala_keluarga_l'),
            DB::raw('SUM(kepala_keluarga_p) as kepala_keluarga_p'),
            DB::raw('SUM(kepala_keluarga_jml) as kepala_keluarga_jml'),
            DB::raw('SUM(suami_l) as suami_l'),
            DB::raw('SUM(suami_p) as suami_p'),
            DB::raw('SUM(suami_jml) as suami_jml'),
            DB::raw('SUM(isteri_l) as isteri_l'),
            DB::raw('SUM(isteri_p) as isteri_p'),
            DB::raw('SUM(isteri_jml) as isteri_jml'),
            DB::raw('SUM(anak_l) as anak_l'),
            DB::raw('SUM(anak_p) as anak_p'),
            DB::raw('SUM(anak_jml) as anak_jml'),
            DB::raw('SUM(menantu_l) as menantu_l'),
            DB::raw('SUM(menantu_p) as menantu_p'),
            DB::raw('SUM(menantu_jml) as menantu_jml'),
            DB::raw('SUM(cucu_l) as cucu_l'),
            DB::raw('SUM(cucu_p) as cucu_p'),
            DB::raw('SUM(cucu_jml) as cucu_jml'),
            DB::raw('SUM(orang_tua_l) as orang_tua_l'),
            DB::raw('SUM(orang_tua_p) as orang_tua_p'),
            DB::raw('SUM(orang_tua_jml) as orang_tua_jml'),
            DB::raw('SUM(mertua_l) as mertua_l'),
            DB::raw('SUM(mertua_p) as mertua_p'),
            DB::raw('SUM(mertua_jml) as mertua_jml'),
            DB::raw('SUM(famili_lain_l) as famili_lain_l'),
            DB::raw('SUM(famili_lain_p) as famili_lain_p'),
            DB::raw('SUM(famili_lain_jml) as famili_lain_jml'),
            DB::raw('SUM(pembantu_l) as pembantu_l'),
            DB::raw('SUM(pembantu_p) as pembantu_p'),
            DB::raw('SUM(pembantu_jml) as pembantu_jml'),
            DB::raw('SUM(lainnya_l) as lainnya_l'),
            DB::raw('SUM(lainnya_p) as lainnya_p'),
            DB::raw('SUM(lainnya_jml) as lainnya_jml'),
            'mstr_kecamatan.nama as kecamatan_nama'
        ])
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'hubungan_keluarga_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('hubungan_keluarga_penduduk.semester', $request['semester'])
            ->where('hubungan_keluarga_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
    }
    public function dataPendudukPekerjaan($request)
    {
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
        $dataPerkecamatan = PendudukJenisKelamin::select([
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
            ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pekerjaan_penduduk.kode_wilayah')
            ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
            ->where('pekerjaan_penduduk.semester', $request['semester'])
            ->where('pekerjaan_penduduk.tahun', $request['tahun'])
            ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
            ->orderBy('mstr_kecamatan.kode', 'asc')
            ->first();
        if (!$dataPerkelurahan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json(['dataPerkelurahan' => $dataPerkelurahan, 'dataKeseluruhan' => $dataKeseluruhan, 'dataPerkecamatan' => $dataPerkecamatan], 200);
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
}
