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
        $listFileImport = [
            '1' => 'App\Imports\DisabilitasJenisKelaminImport',
            '2' => 'App\Imports\DisabilitasPekerjaanImport',
            '3' => 'App\Imports\DisabilitasPendidikanImport',
            '4' => 'App\Imports\KepalaKeluargaJenisKelaminImport',
            '5' => 'App\Imports\KepalaKeluargaAgamaImport',
            '6' => 'App\Imports\KepalaKeluargaPekerjaanImport',
            '7' => 'App\Imports\KepalaKeluargaPendidikanImport',
            '8' => 'App\Imports\KepalaKeluargaStatusKawinImport',
            '9' => 'App\Imports\PendidikanGolonganDarahImport',
            '10' => 'App\Imports\PendidikanJenisKelaminImport',
            '11' => 'App\Imports\PendudukJenisKelaminImport',
            '12' => 'App\Imports\PendudukAgamaImport',
            '13' => 'App\Imports\PendudukGolonganDarahImport',
            '14' => 'App\Imports\PendudukHubungaKeluargaImport',
            '15' => 'App\Imports\PendudukPekerjaanImport',
            '16' => 'App\Imports\KepemilikanAktaCeraiImport',
            '17' => 'App\Imports\KepemilikanAktaKawinImport',
            '18' => 'App\Imports\KepemilikanAktaKelahiranImport',
            '19' => 'App\Imports\KepemilikanKartuKeluargaImport',
            '20' => 'App\Imports\KepemilikanKIAImport',
            '21' => 'App\Imports\KepemilikanAktaCeraiAgamaImport',
            '22' => 'App\Imports\KepemilikanAktaAgamaKawinImport',
            '23' => 'App\Imports\StrukturUmurAgamaKelompokUmurImport',
            '24' => 'App\Imports\StrukturUmurDisabilitasKelompokUmurImport',
            '25' => 'App\Imports\StrukturUmurDisabilitasPendidikanUmurTunggalImport',
            '26' => 'App\Imports\StrukturUmurDisabilitasUmurTunggalImport',
            '27' => 'App\Imports\StrukturUmurDisabilitasUsiaSekolahKelompokUmurImport',
            '28' => 'App\Imports\StrukturUmurGolonganDarahKelompokUmurImport',
            '29' => 'App\Imports\StrukturUmurGolonganDarahUmurTunggalImport',
            '30' => 'App\Imports\StrukturUmurKepalaKeluargaKelompokUmurImport',
            '31' => 'App\Imports\StrukturUmurKepalaKeluargaStatusKawinImport',
            '32' => 'App\Imports\StrukturUmurKepalaKeluargaUmurTunggalImport',
            '33' => 'App\Imports\StrukturUmurPendudukKelompokUmurImport',
            '34' => 'App\Imports\StrukturUmurPendudukStatusKawinKelompokUmurImport',
            '35' => 'App\Imports\StrukturUmurPendudukStatusKawinUmurTunggalImport',
            '36' => 'App\Imports\StrukturUmurPendudukUmurTunggalImport',
            '37' => 'App\Imports\StrukturUmurPendudukUsiaMudaProduktifImport',
            '38' => 'App\Imports\StrukturUmurPendudukUsiaSekolahImport',
        ];
        if (isset($listFileImport[$request->keterangan_file])) {
            $listFileImport = $listFileImport[$request->keterangan_file];
        }
        $request->validate([
            'semester' => 'required|integer',
            'tahun' => 'required|integer',
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
    
        $file = $request->file('file');
        $tahun = $request->input('tahun');
        $semester = $request->input('semester');
    
        try {
            DB::beginTransaction();
    
            // Explicitly specify the file type
            $fileType = \Maatwebsite\Excel\Excel::XLSX; // Default to XLSX
            if ($file->getClientOriginalExtension() === 'xls') {
                $fileType = \Maatwebsite\Excel\Excel::XLS;
            } elseif ($file->getClientOriginalExtension() === 'csv') {
                $fileType = \Maatwebsite\Excel\Excel::CSV;
            }
    
            Excel::import(new PendudukJenisKelaminImport($tahun, $semester), $file, null, $fileType);
    
            DB::commit();
            return response()->json('Import berhasil', 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json('Proses gagal: ' . $e->getMessage(), 500);
        }
    }
}
