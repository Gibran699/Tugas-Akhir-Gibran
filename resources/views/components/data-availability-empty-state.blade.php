@php
    $isAdmin = auth()->check() && auth()->user()->can('pengaturan');
    $featureLabel = $availability['feature_label'] ?? ($featureLabel ?? '-');
    $entityLabel = $availability['entity_label'] ?? ($entityLabel ?? '-');
    $dimensionLabel = $availability['dimension_label'] ?? ($dimensionLabel ?? '-');
    $semesterValue = $availability['semester'] ?? ($semester ?? '-');
    $tahunValue = $availability['tahun'] ?? ($tahun ?? '-');
@endphp

<div class="card border-0 shadow-sm my-3" style="background:#fff7ed;">
    <div class="card-body text-center py-5">
        <div class="mb-3">
            <i class="fa fa-database" style="font-size:42px;color:#f97316;"></i>
        </div>
        <h5 class="fw-bold mb-2" style="color:#9a3412;">Data belum tersedia</h5>
        @if($isAdmin)
            <p class="mb-3 text-muted">
                Data belum tersedia. Fitur: {{ $featureLabel }}, Entitas: {{ $entityLabel }}, Dimensi: {{ $dimensionLabel }}, Semester: {{ $semesterValue }}, Tahun: {{ $tahunValue }}. Silakan import data terlebih dahulu.
            </p>
            @can('import_data')
                <a href="{{ route('import_data_excel') }}" class="btn btn-warning">
                    <i class="fa fa-upload me-1"></i> Import Data Sekarang
                </a>
            @endcan
        @else
            <p class="mb-0 text-muted">
                Data untuk periode atau wilayah yang dipilih belum tersedia. Silakan hubungi admin untuk memastikan ketersediaan data.
            </p>
        @endif
    </div>
</div>
