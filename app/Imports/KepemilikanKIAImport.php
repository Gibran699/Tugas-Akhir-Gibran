<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Kepemilikan\KIA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class KepemilikanKIAImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    protected $tahun;
    protected $semester;

    public function __construct($tahun, $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }
    public function model(array $row)
    {
        $categoryKiaOwnerShip = config('dataArray.categoryKiaOwnerShip');
        $kodeWilayah = str_replace(['.', ' '], '', (string) $row['kode_wilayah']);
        $data =[
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $kodeWilayah,
        ];
        foreach ($categoryKiaOwnerShip as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new KIA($data);
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
