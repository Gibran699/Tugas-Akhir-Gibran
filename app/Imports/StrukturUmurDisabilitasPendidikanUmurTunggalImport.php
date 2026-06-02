<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class StrukturUmurDisabilitasPendidikanUmurTunggalImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, SkipsOnFailure, SkipsOnError, WithValidation{
    use ImportReconciliationTrait;

    protected $tahun;
    protected $semester;

    public function __construct($tahun, $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }

    public function model(array $row)
    {
        $categoryEducationDisabilites = config('dataArray.categoryEducationDisabilites');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'umur' => $row['umur'],
        ];

        foreach ($categoryEducationDisabilites as $key) {
            $data[$key] = $row[$key] ?? null;
        }

        return new PendidikanUmurTunggal($data);
    }

    public function chunkSize(): int
    {
        return 500; // Process 500 rows at a time
    }

    public function batchSize(): int
    {
        return 50;
    }
}