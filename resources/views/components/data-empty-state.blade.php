{{--
    Komponen: data-empty-state
    Digunakan pada halaman fitur untuk menampilkan pesan ketersediaan data.

    Props (opsional — semua bisa ditimpa via JavaScript):
        $feature   : key fitur (contoh: 'data_dkb')
        $entity    : key entitas
        $dimension : key dimensi
        $containerId : id HTML wrapper data utama yang perlu disembunyikan saat missing
--}}
@props([
    'feature'     => '',
    'entity'      => '',
    'dimension'   => '',
    'containerId' => 'dataContentArea',
])

<div
    id="dataAvailabilityState"
    class="data-availability-state"
    style="display:none;"
    data-feature="{{ $feature }}"
    data-entity="{{ $entity }}"
    data-dimension="{{ $dimension }}"
    data-container="{{ $containerId }}"
    data-is-admin="{{ auth()->user()->can('pengaturan') ? '1' : '0' }}"
    data-can-import="{{ auth()->user()->can('import_data') ? '1' : '0' }}"
    data-import-url="{{ route('import_data_excel') }}"
    data-check-url="{{ route('data_availability.check') }}"
>
    {{-- MISSING --}}
    <div class="das-card das-missing" style="display:none;">
        <div class="das-icon">
            <i class="fa fa-database fa-2x text-danger"></i>
        </div>
        <div class="das-body">
            <h5 class="das-title text-danger mb-1">Data Belum Tersedia</h5>
            <p class="das-message mb-0 text-muted small"></p>
            <div class="das-meta mt-2 small text-secondary"></div>
            <div class="das-actions mt-3 d-flex gap-2 flex-wrap"></div>
        </div>
    </div>

    {{-- PARTIAL --}}
    <div class="das-card das-partial" style="display:none;">
        <div class="das-icon">
            <i class="fa fa-circle-half-stroke fa-2x text-warning"></i>
        </div>
        <div class="das-body">
            <h5 class="das-title text-warning mb-1">Data Sebagian Tersedia</h5>
            <p class="das-message mb-0 text-muted small"></p>
            <div class="das-meta mt-2 small text-secondary"></div>
            <div class="das-wilayah-missing mt-2"></div>
            <div class="das-actions mt-3 d-flex gap-2 flex-wrap"></div>
        </div>
    </div>
</div>

<style>
.data-availability-state .das-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 20px 22px;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.das-missing.das-card  { border-left: 4px solid #ef4444; }
.das-partial.das-card  { border-left: 4px solid #f59e0b; }
.data-availability-state .das-icon { flex-shrink: 0; padding-top: 2px; }
.data-availability-state .das-body { flex: 1; }
.data-availability-state .das-title { font-size: 14px; font-weight: 700; }
.data-availability-state .das-message { font-size: 13px; }
.data-availability-state .das-wilayah-missing .badge {
    font-size: 10px; margin: 2px 2px 0 0;
}
</style>
