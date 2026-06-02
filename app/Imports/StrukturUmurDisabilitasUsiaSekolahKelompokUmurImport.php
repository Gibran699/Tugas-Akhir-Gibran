<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\StrukturUmur\Disabilitas\UsiaSekolahKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class StrukturUmurDisabilitasUsiaSekolahKelompokUmurImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
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
        $categoryAgeSchollDisabilities = config('dataArray.categoryAgeSchollDisabilities');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryAgeSchollDisabilities as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new UsiaSekolahKelompokUmur($data);
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
