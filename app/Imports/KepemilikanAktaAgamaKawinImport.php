<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Models\Kepemilikan\AktaKawinAgama;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class KepemilikanAktaAgamaKawinImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, SkipsOnFailure, SkipsOnError, WithValidation{
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
        $categoryReligiosOwnerShip = config('dataArray.categoryReligiosOwnerShip');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryReligiosOwnerShip as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new AktaKawinAgama($data);
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
