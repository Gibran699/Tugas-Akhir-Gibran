<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Imports\PendudukJenisKelaminImport;
use App\Models\AgregatDKB\Penduduk\JenisKelamin;
use App\services\DataAvailabilityService;
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
            // Validasi file: terima xlsx, xls, csv. Untuk CSV gunakan mimetypes
            // karena MIME type CSV sering terdeteksi sebagai text/plain,
            // application/csv, text/csv, atau application/vnd.ms-excel.
            'file' => [
                'required',
                'file',
                'max:20480', // 20 MB
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExt = ['xlsx', 'xls', 'csv'];
                    if (!in_array($extension, $allowedExt)) {
                        $fail("File harus berformat: " . implode(', ', $allowedExt) . '.');
                    }
                },
            ],
        ]);
    
        $file = $request->file('file');
        $tahun = $request->input('tahun');
        $semester = $request->input('semester');
    
        // Validasi ketersediaan data
        if ($listFileModel::where('tahun', $tahun)->where('semester', $semester)->exists()) {
            return response()->json('Data Sudah ada', 409);
        }
    
        try {
            // Menentukan tipe file
            $fileType = \Maatwebsite\Excel\Excel::XLSX; // Default
            $extension = strtolower($file->getClientOriginalExtension());

            if ($extension === 'xls') {
                $fileType = \Maatwebsite\Excel\Excel::XLS;
            } elseif ($extension === 'csv') {
                $fileType = \Maatwebsite\Excel\Excel::CSV;
            }

            // ── Optimasi resource untuk file besar ─────────────────────────
            // File Excel besar (terutama .xlsx) perlu memori dan waktu lebih.
            // PhpSpreadsheet harus parse seluruh XML dulu sebelum bisa dibaca.
            $fileSize = $file->getSize();

            if ($fileSize > 5 * 1024 * 1024) {
                // > 5 MB → resource maksimal
                ini_set('memory_limit', '2048M');
                set_time_limit(0);              // tanpa batas (sampai script selesai)
                ignore_user_abort(true);
            } elseif ($fileSize > 2 * 1024 * 1024) {
                // > 2 MB → resource menengah
                ini_set('memory_limit', '1536M');
                set_time_limit(1800);           // 30 menit
                ignore_user_abort(true);
            } else {
                // File kecil → cukup default Laravel
                set_time_limit(600);
            }

            $import = new $listFileImport($tahun, $semester);

            // Set chunk size jika import class mendukungnya
            if (method_exists($import, 'setChunkSize')) {
                $import->setChunkSize(500);
            }

            Excel::import($import, $file, null, $fileType);

            // ── Rekonsiliasi: hitung baris file vs baris tersimpan ──────────
            // onFailure() tidak selalu dipanggil dengan WithBatchInserts, maka
            // kita bandingkan jumlah baris data di file vs yang masuk ke DB.
            $savedCount = $listFileModel::where('tahun', $tahun)->where('semester', $semester)->count();

            // Hitung jumlah baris data di file (minus header)
            $fileRowCount = 0;
            if ($extension === 'csv') {
                // Untuk CSV, hitung baris dengan SplFileInfo
                $tempPath = $file->getRealPath();
                $handle   = fopen($tempPath, 'r');
                if ($handle) {
                    $lineCount = 0;
                    while (!feof($handle)) {
                        $line = fgets($handle);
                        if ($line !== false && trim($line) !== '') {
                            $lineCount++;
                        }
                    }
                    fclose($handle);
                    $fileRowCount = max(0, $lineCount - 1); // minus header row
                }
            } else {
                // Untuk xlsx/xls, gunakan method getImportFailureCount dari trait
                // sebagai fallback — hitung dari failures array jika ada
                $fileRowCount = $savedCount + count($import->getImportFailures());
            }

            $missedCount  = max(0, $fileRowCount - $savedCount);
            $failureCount = count($import->getImportFailures());

            if ($missedCount > 0 || $failureCount > 0) {
                $totalMissed = max($missedCount, $failureCount);
                $failureDetail = array_slice($import->getImportFailures(), 0, 20);

                \Log::warning("Import Partial: {$savedCount} baris tersimpan, {$totalMissed} baris tidak tersimpan.", [
                    'tahun'        => $tahun,
                    'semester'     => $semester,
                    'file_rows'    => $fileRowCount,
                    'saved_count'  => $savedCount,
                    'missed_count' => $totalMissed,
                    'failures'     => $failureDetail,
                ]);

                return response()->json([
                    'status'        => 'partial',
                    'message'       => "Import sebagian berhasil: {$savedCount} baris tersimpan, {$totalMissed} baris tidak dapat disimpan (tipe data tidak valid atau baris kosong).",
                    'saved_count'   => $savedCount,
                    'file_count'    => $fileRowCount,
                    'failure_count' => $totalMissed,
                    'failures'      => $failureDetail,
                ], 200);
            }

            return response()->json([
                'status'      => 'success',
                'message'     => "Import berhasil: {$savedCount} baris tersimpan.",
                'saved_count' => $savedCount,
            ], 200);

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Import Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json('Proses gagal: ' . $e->getMessage(), 500);
        }
    }
    function searchData(Request $request,$jenisData) {
        // ── Pre-check ketersediaan data ────────────────────────────────────
        // Sebelum panggil fungsi calculate, cek apakah data untuk tahun + semester
        // yang diminta benar-benar ada di database. Kalau tidak, kembalikan 404
        // dengan pesan informatif.
        $availabilityMap = config('dataArray.codeViewAvailability', []);

        if (isset($availabilityMap[$jenisData])) {
            $entry = $availabilityMap[$jenisData];

            // Lewati pengecekan untuk fitur yang ditandai skip_check
            if (empty($entry['skip_check'])) {
                $tahun    = $request->input('tahun');
                $semester = $request->input('semester');

                // Hanya cek kalau tahun dan semester benar-benar dikirim
                if ($tahun && $semester) {
                    try {
                        $service = app(DataAvailabilityService::class);
                        $result  = $service->checkAvailability(
                            feature:   $entry['feature'],
                            entity:    $entry['entity'],
                            dimension: $entry['dimension'],
                            tahun:     (int) $tahun,
                            semester:  (int) $semester,
                        );

                        // Jika data sama sekali belum ada (missing), tolak permintaan
                        if (($result['status'] ?? null) === 'missing') {
                            $label = $entry['label'] ?? 'Data yang dicari';
                            return response()->json([
                                'status'  => 'missing',
                                'message' => "Data \"{$label}\" untuk Semester {$semester} Tahun {$tahun} tidak tersedia saat ini.",
                                'detail'  => 'Silakan pilih periode lain atau hubungi admin untuk melakukan import data.',
                                'feature_label'   => $entry['label'] ?? null,
                                'periode_label'   => "Semester {$semester} Tahun {$tahun}",
                            ], 404);
                        }
                    } catch (\Throwable $e) {
                        // Jika pengecekan gagal (misal config salah), biarkan
                        // alur lama tetap jalan supaya tidak block fitur.
                        \Log::warning('Availability pre-check gagal: ' . $e->getMessage());
                    }
                }
            }
        }

        $listCalculateDataFunction = config('dataArray.listCalculateDataFunction');
        if (isset($listCalculateDataFunction[$jenisData])) {
            $listCalculateDataFunction = $listCalculateDataFunction[$jenisData];
            return $this->calculateDateFunction->$listCalculateDataFunction($request);
        }
        return response()->json(['error' => 'Invalid data type'], 400);

    }
}
