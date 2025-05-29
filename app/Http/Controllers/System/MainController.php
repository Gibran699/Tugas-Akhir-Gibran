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
    protected $calculateDateFunction;
    public function __construct(CalculateDataController $calculateDateFunction)
    {
        $this->calculateDateFunction = $calculateDateFunction;
    }
    // import data excel
    function importData(Request $request) {
        // Validasi input dan konfigurasi awal
        $listFileImport = config('dataArray.listFileImport');
        $listFileModel = config('dataArray.listFileModel');
        
        if (isset($listFileImport[$request->keterangan_file])) {
            $listFileImport = $listFileImport[$request->keterangan_file];
        }
        
        if (isset($listFileModel[$request->keterangan_file])) {
            $listFileModel = $listFileModel[$request->keterangan_file];
        }
        
        $request->validate([
            'semester' => 'required|integer',
            'tahun' => 'required|integer',
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480', // Meningkatkan limit menjadi 20MB
        ]);
    
        $file = $request->file('file');
        $tahun = $request->input('tahun');
        $semester = $request->input('semester');
    
        // Validasi ketersediaan data
        if ($listFileModel::where('tahun', $tahun)->where('semester', $semester)->exists()) {
            return response()->json('Data Sudah ada', 409);
        }
    
        try {
            DB::beginTransaction();
    
            // Menentukan tipe file
            $fileType = \Maatwebsite\Excel\Excel::XLSX; // Default
            $extension = strtolower($file->getClientOriginalExtension());
            
            if ($extension === 'xls') {
                $fileType = \Maatwebsite\Excel\Excel::XLS;
            } elseif ($extension === 'csv') {
                $fileType = \Maatwebsite\Excel\Excel::CSV;
            }
    
            // Optimasi untuk file besar
            $fileSize = $file->getSize();
            if ($fileSize > 2 * 1024 * 1024) {
                // Tingkatkan resource untuk file besar
                ini_set('memory_limit', '1024M');
                set_time_limit(600);
                
                // Gunakan chunk reading untuk file besar
                $import = new $listFileImport($tahun, $semester);
                
                if (method_exists($import, 'setChunkSize')) {
                    $import->setChunkSize(500); // Sesuaikan dengan kebutuhan
                }
                
                Excel::import($import, $file, null, $fileType);
            } else {
                // Proses normal untuk file kecil
                Excel::import(new $listFileImport($tahun, $semester), $file, null, $fileType);
            }
    
            DB::commit();
            return response()->json('Import berhasil', 200);
        } catch (\Exception $e) {
            DB::rollback();
            
            // Log error untuk debugging
            \Log::error('Import Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json('Proses gagal: ' . $e->getMessage(), 500);
        }
    }
    function searchData(Request $request,$jenisData) {
        $listCalculateDataFunction = config('dataArray.listCalculateDataFunction');
        if (isset($listCalculateDataFunction[$jenisData])) {
            $listCalculateDataFunction = $listCalculateDataFunction[$jenisData];
            return $this->calculateDateFunction->$listCalculateDataFunction($request);
        }
        return response()->json(['error' => 'Invalid data type'], 400);
        
    }
}
