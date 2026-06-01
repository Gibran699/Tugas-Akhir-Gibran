<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\services\DataAvailabilityService;
use Illuminate\Http\Request;

class DataAvailabilityController extends Controller
{
    public function __construct(protected DataAvailabilityService $service)
    {
    }

    // ──────────────────────────────────────────────────────────
    //  GET /data-availability/check
    //  Cek ketersediaan satu kombinasi fitur/entitas/dimensi.
    //  Dapat diakses oleh semua user yang sudah login.
    // ──────────────────────────────────────────────────────────
    public function check(Request $request)
    {
        $validated = $request->validate([
            'feature'        => 'required|string',
            'entity'         => 'required|string',
            'dimension'      => 'required|string',
            'tahun'          => 'required|integer|min:2000|max:2100',
            'semester'       => 'required|integer|in:1,2',
            'kode_kecamatan' => 'nullable|string',
            'kode_kelurahan' => 'nullable|string',
            'kecamatan_id'   => 'nullable|string',
            'kelurahan_id'   => 'nullable|string',
        ]);

        $result = $this->service->checkAvailability(
            feature:       $validated['feature'],
            entity:        $validated['entity'],
            dimension:     $validated['dimension'],
            tahun:         (int) $validated['tahun'],
            semester:      (int) $validated['semester'],
            kodeKecamatan: $validated['kode_kecamatan'] ?? $validated['kecamatan_id'] ?? null,
            kodeKelurahan: $validated['kode_kelurahan'] ?? $validated['kelurahan_id'] ?? null,
        );

        // Sembunyikan detail teknis dari non-admin
        if (!auth()->user()->can('pengaturan')) {
            unset($result['table'], $result['error'], $result['missing_wilayah']);
            // Ganti field message
            unset($result['message_for_admin']);
        }

        return response()->json($result);
    }

    // ──────────────────────────────────────────────────────────
    //  GET /data-availability/summary?tahun=&semester=&feature=
    //  Ringkasan seluruh entri registry. Admin only.
    // ──────────────────────────────────────────────────────────
    public function summary(Request $request)
    {
        $validated = $request->validate([
            'tahun'    => 'required|integer|min:2000|max:2100',
            'semester' => 'required|integer|in:1,2',
            'feature'  => 'nullable|string',
            'entity'   => 'nullable|string',
            'dimension'=> 'nullable|string',
        ]);

        $result = $this->service->summaryAll(
            tahun:      (int) $validated['tahun'],
            semester:   (int) $validated['semester'],
            featureKey: $validated['feature'] ?? null,
            entityKey:  $validated['entity'] ?? null,
            dimensionKey: $validated['dimension'] ?? null,
        );

        return response()->json($result);
    }

    // ──────────────────────────────────────────────────────────
    //  GET /data-availability/dashboard
    //  Halaman dashboard ketersediaan data. Admin only.
    // ──────────────────────────────────────────────────────────
    public function dashboard(Request $request)
    {
        $availableYears = $this->service->availableYears();
        $tahun    = (int) ($request->tahun ?? ($availableYears[0] ?? date('Y')));
        $semester = (int) ($request->semester ?? 1);
        $feature  = $request->feature ?? null;
        $entity   = $request->entity ?? null;
        $dimension = $request->dimension ?? null;

        // Pastikan feature yang dipilih valid
        $allFeatures = array_keys(config('data_availability', []));
        if ($feature && !in_array($feature, $allFeatures)) {
            $feature = null;
        }

        $entities = $feature ? array_keys(config("data_availability.{$feature}.entities", [])) : [];
        if ($entity && !in_array($entity, $entities)) {
            $entity = null;
            $dimension = null;
        }

        $dimensions = ($feature && $entity) ? array_keys(config("data_availability.{$feature}.entities.{$entity}.dimensions", [])) : [];
        if ($dimension && !in_array($dimension, $dimensions)) {
            $dimension = null;
        }

        $summary    = $this->service->summaryAll($tahun, $semester, $feature, $entity, $dimension);
        $features   = $allFeatures;

        return view('data_availability.dashboard', compact(
            'summary', 'features', 'entities', 'dimensions', 'tahun', 'semester', 'feature', 'entity', 'dimension', 'availableYears'
        ));
    }
}
