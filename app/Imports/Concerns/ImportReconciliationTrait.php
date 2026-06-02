<?php

namespace App\Imports\Concerns;

use Maatwebsite\Excel\Validators\Failure;

trait ImportReconciliationTrait
{
    /**
     * Array penampung semua baris yang gagal (validasi maupun error DB).
     * Setiap elemen: ['row' => N, 'attribute' => '...', 'errors' => [...], 'values' => [...]]
     */
    protected array $importFailures = [];

    /**
     * Callback dari concern SkipsOnFailure.
     * Dipanggil otomatis oleh Laravel Excel setiap kali ada baris gagal validasi.
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->importFailures[] = [
                'row'       => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors'    => $failure->errors(),
                'values'    => $failure->values(),
            ];
        }
    }

    /**
     * Callback dari concern SkipsOnError.
     * Dipanggil saat terjadi error-level exception (misal: SQL error, type mismatch).
     * Baris yang error akan dilewati dan dicatat — proses import tetap lanjut.
     */
    public function onError(\Throwable $e): void
    {
        $this->importFailures[] = [
            'row'       => null,
            'attribute' => 'system',
            'errors'    => [$e->getMessage()],
            'values'    => [],
        ];
    }

    /**
     * Aturan validasi kolom numerik yang wajib ada di setiap baris.
     * Import class dapat meng-override method ini untuk menyesuaikan kolom yang divalidasi.
     * Dipanggil oleh concern WithValidation.
     */
    public function rules(): array
    {
        // Default: validasi kode_wilayah tidak boleh kosong
        // Import class yang punya kolom berbeda harus override method ini.
        return [
            'kode_wilayah' => ['required'],
        ];
    }

    /**
     * Kembalikan semua detail baris yang gagal.
     */
    public function getImportFailures(): array
    {
        return $this->importFailures;
    }

    /**
     * Jumlah baris yang gagal diproses.
     */
    public function getImportFailureCount(): int
    {
        return count($this->importFailures);
    }
}
