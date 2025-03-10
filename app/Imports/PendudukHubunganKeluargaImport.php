<?php

namespace App\Imports;

use App\Models\AgregatDKB\Penduduk\HubunganKeluarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class PendudukHubunganKeluargaImport implements ToModel, WithHeadingRow
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
        $categoryRelationshipFamily = config('dataArray.categoryRelationshipFamily');
        return new HubunganKeluarga([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ]);
        foreach ($categoryRelationshipFamily as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new HubunganKeluarga($data);
    }
}
