<?php

namespace App\Imports;

use App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurDisabilitasPendidikanUmurTunggalImport implements ToModel, WithHeadingRow
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
        $categoryDisabilities = config('dataArray.categoryDisabilities');
        return new PendidikanUmurTunggal([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'umur' => $row['umur'],
        ]);
        foreach ($categoryDisabilities as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new PendidikanUmurTunggal($data);
    }
}
