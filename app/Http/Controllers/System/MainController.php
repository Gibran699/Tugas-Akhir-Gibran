<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Imports\PendudukJenisKelaminImport;
use App\Models\AgregatDKB\Penduduk\JenisKelamin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    function importData(Request $request) {
        $request->validate([
            'semester' => 'required|integer',
            'tahun' => 'required|integer',
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        $file = $request->file('file');
        $tahun = $request->input('tahun');
        $semester = $request->input('semester');
        try {
            DB::beginTransaction();
            Excel::import(new PendudukJenisKelaminImport($tahun,$semester),$file);
            return response()->json('import berhasil', 200);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json('proses gagal', 500);
        }
    }
}
