<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\StrukturUmur\GolonganDarah\KelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class StrukturUmurGolonganDarahKelompokUmurImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
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
        $categoryBlood = config('dataArray.categoryBlood');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'kelompok_umur' => $row['kelompok_umur']
        ]; 
        foreach ($categoryBlood as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new KelompokUmur($data);
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
