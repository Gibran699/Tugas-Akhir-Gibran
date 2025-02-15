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
        $listFileImport = config('dataArray.listFileImport');
        $listFileModel = config('dataArray.listFileModel');
        if (isset($listFileImport[$request->keterangan_file])) {
            $listFileImport = $listFileImport[$request->keterangan_file];
        }if (isset($listFileModel[$request->keterangan_file])) {
            $listFileModel = $listFileModel[$request->keterangan_file];
        }
        $request->validate([
            'semester' => 'required|integer',
            'tahun' => 'required|integer',
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        $file = $request->file('file');
        $tahun = $request->input('tahun');
        $semester = $request->input('semester');
        $validateAvailableData = $listFileModel::where('tahun',$tahun)->where('semester',$semester)->exists();
        //validasi ketersediaan data
        if ($validateAvailableData) {
            return response()->json('Data Sudah ada', 409);
        }
        try {
            DB::beginTransaction();
    
            // Explicitly specify the file type
            $fileType = \Maatwebsite\Excel\Excel::XLSX; // Default to XLSX
            if ($file->getClientOriginalExtension() === 'xls') {
                $fileType = \Maatwebsite\Excel\Excel::XLS;
            } elseif ($file->getClientOriginalExtension() === 'csv') {
                $fileType = \Maatwebsite\Excel\Excel::CSV;
            }
    
            Excel::import(new $listFileImport($tahun, $semester), $file, null, $fileType);
    
            DB::commit();
            return response()->json('Import berhasil', 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json('Proses gagal: ' . $e->getMessage(), 500);
        }
    }
}
