<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Models\AgregatDKB\KepalaKeluarga\StatusKawin;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class KepalaKeluargaStatusKawinImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, SkipsOnFailure, SkipsOnError, WithValidation{
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
        $categoryMarriageStatus = config('dataArray.categoryMarriageStatus');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
        ];
        foreach ($categoryMarriageStatus as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new StatusKawin($data);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
