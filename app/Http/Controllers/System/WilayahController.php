<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WilayahKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    function indexKelurahan() {
        /*
         * Dual LEFT JOIN resolves kecamatan regardless of whether kec_id stores
         * mstr_kecamatan.id  (most common)  or  mstr_kecamatan.kode (some setups).
         * COALESCE picks whichever join matched, so one query handles both FK variants.
         */
        $rows = DB::table('mstr_kelurahan as kel')
            ->leftJoin('mstr_kecamatan as ka', 'ka.id',   '=', 'kel.kec_id')  // join by PK id
            ->leftJoin('mstr_kecamatan as kb', 'kb.kode', '=', 'kel.kec_id')  // join by kode
            ->select(
                'kel.uuid',
                'kel.kode',
                'kel.nama',
                'kel.kec_id',
                DB::raw("COALESCE(ka.id,   kb.id)                                        AS kecamatan_id"),
                DB::raw("COALESCE(ka.uuid, kb.uuid)                                      AS kecamatan_uuid"),
                DB::raw("COALESCE(ka.kode, kb.kode, '')                                  AS kode_kecamatan"),
                DB::raw("UPPER(TRIM(COALESCE(ka.nama, kb.nama, 'TIDAK DIKETAHUI')))      AS nama_kecamatan")
            )
            ->whereNull('kel.deleted_at')
            ->orderBy(DB::raw("COALESCE(ka.kode, kb.kode, 9999)"), 'asc')
            ->orderBy('kel.nama', 'asc')
            ->get();

        $data = $rows->map(fn($r) => [
            'uuid'           => $r->uuid,
            'kode'           => $r->kode,
            'nama'           => $r->nama,
            'kec_id'         => $r->kec_id,
            'kecamatan_id'   => $r->kecamatan_id,
            'kecamatan_uuid' => $r->kecamatan_uuid,
            'kode_kecamatan' => $r->kode_kecamatan,
            'nama_kecamatan' => $r->nama_kecamatan,
        ]);

        return response()->json(['data' => $data], 200);
    }

    function indexKecamatan() {
        $rows = DB::table('mstr_kecamatan')
            ->select('id', 'uuid', 'kode', 'nama')
            ->whereNull('deleted_at')
            ->orderBy('kode', 'asc')
            ->get()
            ->map(fn($r) => [
                'id'   => $r->id,
                'uuid' => $r->uuid,
                'kode' => $r->kode,
                'nama' => strtoupper(trim($r->nama)),
            ]);
        return response()->json(['data' => $rows], 200);
    }
}
