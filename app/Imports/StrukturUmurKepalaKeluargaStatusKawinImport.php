<?php

namespace App\Imports;

use App\Models\StrukturUmur\KepalaKeluarga\StatusKawinKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;

class StrukturUmurKepalaKeluargaStatusKawinImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsEmptyRows
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
        // Skip baris kosong atau baris total/footer (kode_wilayah tidak ada)
        if (empty($row['kode_wilayah'])) {
            return null;
        }

        $categoryAgeGroup = config('dataArray.categoryAgeGroupMarriageStatus');
        $data = [
            'uuid'         => Str::uuid(),
            'semester'     => $this->semester,
            'tahun'        => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
        ];
        foreach ($categoryAgeGroup as $key) {
            $data[$key] = isset($row[$key]) && $row[$key] !== '' ? (int) $row[$key] : 0;
        }
        return new StatusKawinKelompokUmur($data);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 50;
    }
}
