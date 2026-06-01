@extends('layout.master')
@section('content')
<style>
    /* ── Hero Banner ── */
    .da-hero {
        background: linear-gradient(135deg, #431407 0%, #7c2d12 50%, #c2410c 100%);
        border-radius: 18px;
        padding: 26px 30px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 36px rgba(194, 65, 12, .22);
    }
    .da-hero::before {
        content: '';
        position: absolute;
        top: -70px; right: -50px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        pointer-events: none;
    }
    .da-hero::after {
        content: '';
        position: absolute;
        bottom: -50px; left: 28%;
        width: 150px; height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
        pointer-events: none;
    }
    .da-hero-icon {
        width: 58px; height: 58px;
        border-radius: 16px;
        background: rgba(255,255,255,.15);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        flex-shrink: 0;
    }
    .da-hero-title {
        color: #fff;
        font-size: 21px;
        font-weight: 800;
        margin-bottom: 4px;
    }
    .da-hero-sub {
        color: rgba(255,255,255,.68);
        font-size: 13px;
    }
    .da-hero-badge {
        background: rgba(255,255,255,.15);
        color: #fff;
        border-radius: 10px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid rgba(255,255,255,.20);
    }
    .da-progress {
        height: 6px;
        border-radius: 99px;
        background: rgba(255,255,255,.22);
        overflow: hidden;
    }
    .da-progress-bar {
        height: 100%;
        border-radius: 99px;
        background: rgba(255,255,255,.80);
    }

    /* ── Stat Cards ── */
    .da-stat {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(15,23,42,.09);
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .da-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15,23,42,.14);
    }
    .da-stat .card-body {
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .da-stat-icon {
        width: 50px; height: 50px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        background: rgba(255,255,255,.18);
        color: #fff;
    }
    .da-stat-num {
        font-size: 28px;
        font-weight: 900;
        line-height: 1;
        color: #fff;
    }
    .da-stat-label {
        font-size: 12px;
        color: rgba(255,255,255,.78);
        margin-top: 3px;
    }

    /* ── Filter Card ── */
    .da-filter-card {
        border: 1px solid #e7e5e4;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15,23,42,.06);
        overflow: hidden;
        margin-bottom: 22px;
    }
    .da-filter-card .card-header {
        background: #fafaf9;
        border-bottom: 1px solid #e7e5e4;
        padding: 14px 20px;
    }
    .da-filter-card .form-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #78716c;
        margin-bottom: 5px;
    }
    .da-filter-card .form-control,
    .da-filter-card .form-select {
        border-radius: 10px;
        border-color: #e7e5e4;
        font-size: 13px;
    }

    /* ── Table Card ── */
    .da-table-card {
        border: 1px solid #e7e5e4;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15,23,42,.06);
        overflow: hidden;
    }
    .da-table-card .card-header {
        background: #fafaf9;
        border-bottom: 1px solid #e7e5e4;
        padding: 14px 20px;
    }
    .da-table thead th {
        background: #f5f5f4;
        color: #57534e;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        border-bottom: 2px solid #e7e5e4;
        vertical-align: middle;
        padding: 11px 14px;
        white-space: nowrap;
    }
    .da-table tbody td {
        vertical-align: middle;
        padding: 10px 14px;
        font-size: 13px;
        border-bottom: 1px solid #f5f5f4;
        color: #292524;
    }
    .da-table tbody tr:last-child td { border-bottom: 0; }
    .da-table tbody tr:hover td { background: #fafaf9; }

    /* ── Status Badges ── */
    .badge-available { background: #dcfce7; color: #166534; font-size: 11px; border-radius: 8px; padding: 4px 10px; font-weight: 600; }
    .badge-partial   { background: #fef9c3; color: #854d0e; font-size: 11px; border-radius: 8px; padding: 4px 10px; font-weight: 600; }
    .badge-missing   { background: #fee2e2; color: #991b1b; font-size: 11px; border-radius: 8px; padding: 4px 10px; font-weight: 600; }
    .badge-unknown   { background: #f5f5f4; color: #78716c; font-size: 11px; border-radius: 8px; padding: 4px 10px; font-weight: 600; }

    /* ── Feature badge ── */
    .badge-feature { background: #fff7ed; color: #9a3412; font-size: 11px; border-radius: 8px; padding: 4px 10px; font-weight: 600; border: 1px solid #fed7aa; }

    /* ── Missing wilayah row ── */
    .da-detail-row td { background: #fffbeb !important; }
</style>

<div class="container-fluid">

    {{-- Breadcrumb --}}
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengaturan</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Tersedia</a></li>
        </ol>
    </div>

    {{-- Hero --}}
    <div class="da-hero d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="da-hero-icon">
                <i class="fa fa-database"></i>
            </div>
            <div>
                <div class="da-hero-title">Data Tersedia</div>
                <div class="da-hero-sub">Pantau kelengkapan data berdasarkan semester, tahun, fitur, entitas, dan dimensi.</div>
            </div>
        </div>
        <div class="d-flex flex-column align-items-end gap-2">
            <div class="da-hero-badge">
                <i class="fa fa-calendar-alt me-1"></i>
                Semester {{ $semester }} &nbsp;/&nbsp; {{ $tahun }}
            </div>
            <div style="color:rgba(255,255,255,.60);font-size:12px;">
                <i class="fa fa-layer-group me-1"></i>
                {{ count($availableYears) }} tahun data terdeteksi
            </div>
            @php
                $pct = $summary['total'] > 0 ? round(($summary['available'] / $summary['total']) * 100) : 0;
            @endphp
            <div style="width:180px;">
                <div style="color:rgba(255,255,255,.70);font-size:11px;margin-bottom:4px;">
                    Kelengkapan: <strong style="color:#fff;">{{ $pct }}%</strong>
                </div>
                <div class="da-progress">
                    <div class="da-progress-bar" style="width:{{ $pct }}%;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card da-stat" style="background:linear-gradient(135deg,#16a34a,#15803d);">
                <div class="card-body">
                    <div class="da-stat-icon"><i class="fa fa-check-circle"></i></div>
                    <div>
                        <div class="da-stat-num">{{ $summary['available'] }}</div>
                        <div class="da-stat-label">Data Lengkap</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card da-stat" style="background:linear-gradient(135deg,#d97706,#b45309);">
                <div class="card-body">
                    <div class="da-stat-icon"><i class="fa fa-circle-half-stroke"></i></div>
                    <div>
                        <div class="da-stat-num">{{ $summary['partial'] }}</div>
                        <div class="da-stat-label">Belum Lengkap</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card da-stat" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
                <div class="card-body">
                    <div class="da-stat-icon"><i class="fa fa-times-circle"></i></div>
                    <div>
                        <div class="da-stat-num">{{ $summary['missing'] }}</div>
                        <div class="da-stat-label">Belum Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card da-stat" style="background:linear-gradient(135deg,#57534e,#44403c);">
                <div class="card-body">
                    <div class="da-stat-icon"><i class="fa fa-layer-group"></i></div>
                    <div>
                        <div class="da-stat-num">{{ $summary['total'] }}</div>
                        <div class="da-stat-label">Total Dimensi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card da-filter-card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-0 fw-bold" style="color:#292524;">
                    <i class="fa fa-sliders me-2" style="color:#ea580c;"></i>Filter Pengecekan
                </h5>
                <small class="text-muted">Tahun diambil dari data yang tersedia di database.</small>
            </div>
            <a href="{{ route('data_availability.dashboard') }}" class="btn btn-sm btn-light border">
                <i class="fa fa-rotate-left me-1"></i> Reset Filter
            </a>
        </div>
        <div class="card-body pt-3 pb-2">
            <form method="GET" action="{{ route('data_availability.dashboard') }}" id="filterForm">
                <div class="row align-items-end g-3">
                    <div class="col-xl-2 col-md-4">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-control default-select">
                            <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester I</option>
                            <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester II</option>
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-4">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-control default-select">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-4">
                        <label class="form-label">Fitur</label>
                        <select name="feature" class="form-control default-select">
                            <option value="">-- Semua Fitur --</option>
                            @foreach($features as $fKey)
                                @php $fLabel = config("data_availability.{$fKey}.label", $fKey); @endphp
                                <option value="{{ $fKey }}" {{ $feature === $fKey ? 'selected' : '' }}>
                                    {{ $fLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-4">
                        <label class="form-label">Entitas</label>
                        <select name="entity" class="form-control default-select">
                            <option value="">-- Semua --</option>
                            @foreach($entities as $eKey)
                                @php $eLabel = config("data_availability.{$feature}.entities.{$eKey}.label", $eKey); @endphp
                                <option value="{{ $eKey }}" {{ $entity === $eKey ? 'selected' : '' }}>
                                    {{ $eLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-4">
                        <label class="form-label">Dimensi</label>
                        <select name="dimension" class="form-control default-select">
                            <option value="">-- Semua --</option>
                            @foreach($dimensions as $dKey)
                                @php $dLabel = config("data_availability.{$feature}.entities.{$entity}.dimensions.{$dKey}.label", $dKey); @endphp
                                <option value="{{ $dKey }}" {{ $dimension === $dKey ? 'selected' : '' }}>
                                    {{ $dLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-1 col-md-4">
                        <button type="submit" class="btn w-100" style="background:#ea580c;color:#fff;border-radius:10px;">
                            <i class="fa fa-search me-1"></i> Cek
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card da-table-card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <h5 class="mb-0 fw-bold" style="color:#292524;">
                    <i class="fa fa-table me-2" style="color:#ea580c;"></i>Detail Data Tersedia
                </h5>
                <span class="badge bg-secondary" style="font-size:11px;border-radius:8px;">
                    Semester {{ $semester }} / {{ $tahun }}
                </span>
                @if($feature)
                    <span class="badge-feature">
                        {{ config("data_availability.{$feature}.label", $feature) }}
                    </span>
                @endif
                @if($entity)
                    <span class="badge" style="background:#f0fdf4;color:#166534;font-size:11px;border-radius:8px;border:1px solid #bbf7d0;">
                        {{ config("data_availability.{$feature}.entities.{$entity}.label", $entity) }}
                    </span>
                @endif
                @if($dimension)
                    <span class="badge" style="background:#fef9c3;color:#854d0e;font-size:11px;border-radius:8px;border:1px solid #fde68a;">
                        {{ config("data_availability.{$feature}.entities.{$entity}.dimensions.{$dimension}.label", $dimension) }}
                    </span>
                @endif
            </div>
            <a href="{{ route('import_data_excel') }}" class="btn btn-sm" style="background:#ea580c;color:#fff;border-radius:10px;">
                <i class="fa fa-upload me-1"></i> Import Data
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 da-table" id="availabilityTable">
                    <thead>
                        <tr>
                            <th style="width:140px;">Fitur</th>
                            <th style="width:130px;">Entitas</th>
                            <th>Dimensi</th>
                            <th style="width:110px;">Tabel DB</th>
                            <th style="width:80px;" class="text-center">Data</th>
                            <th style="width:85px;" class="text-center">Wilayah</th>
                            <th style="width:85px;" class="text-center">Kurang</th>
                            <th style="width:120px;" class="text-center">Status</th>
                            <th style="width:60px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summary['items'] as $item)
                        <tr class="das-row" data-status="{{ $item['status'] }}">
                            <td>
                                <span class="badge-feature">{{ $item['feature_label'] }}</span>
                            </td>
                            <td style="color:#78716c;font-size:12.5px;">{{ $item['entity_label'] }}</td>
                            <td style="font-size:12.5px;">{{ $item['dimension_label'] }}</td>
                            <td>
                                <code style="font-size:10px;background:#f5f5f4;color:#78716c;padding:2px 6px;border-radius:6px;">
                                    {{ $item['table'] }}
                                </code>
                            </td>
                            <td class="text-center fw-semibold">{{ $item['total_data'] }}</td>
                            <td class="text-center fw-semibold">{{ $item['total_wilayah'] }}</td>
                            <td class="text-center">
                                @if($item['missing_count'] > 0)
                                    <span class="fw-bold" style="color:#dc2626;">{{ $item['missing_count'] }}</span>
                                @else
                                    <span style="color:#16a34a;"><i class="fa fa-check"></i></span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item['status'] === 'available')
                                    <span class="badge-available">✓ Tersedia</span>
                                @elseif($item['status'] === 'partial')
                                    <span class="badge-partial">◑ Sebagian</span>
                                @elseif($item['status'] === 'missing')
                                    <span class="badge-missing">✗ Belum Ada</span>
                                @else
                                    <span class="badge-unknown">? Tidak Diketahui</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(in_array($item['status'], ['missing', 'partial', 'unknown']))
                                    <a href="{{ route('import_data_excel') }}"
                                       title="Import data untuk {{ $item['entity_label'] }} – {{ $item['dimension_label'] }}"
                                       class="btn btn-xs p-1"
                                       style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;border-radius:8px;">
                                        <i class="fa fa-upload" style="font-size:11px;"></i>
                                    </a>
                                @else
                                    <span style="color:#16a34a;" title="Data lengkap">
                                        <i class="fa fa-check-circle" style="font-size:14px;"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        {{-- Detail wilayah yang belum ada data --}}
                        @if(!empty($item['missing_wilayah']) && $item['missing_count'] > 0)
                        <tr class="da-detail-row" data-status="{{ $item['status'] }}">
                            <td colspan="9" style="padding:8px 16px;">
                                <small class="fw-semibold me-2" style="color:#d97706;">
                                    <i class="fa fa-map-marker-alt me-1"></i>
                                    Wilayah belum tersedia ({{ $item['missing_count'] }}):
                                </small>
                                @foreach($item['missing_wilayah'] as $w)
                                    <span class="badge bg-light text-secondary border me-1 mb-1" style="font-size:10px;border-radius:6px;">
                                        {{ $w['nama'] }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5" style="color:#a8a29e;">
                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                Tidak ada data ditemukan untuk filter yang dipilih.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('availabilityTable');
        if (!table) return;
        table.querySelectorAll('tr.das-row[data-status="missing"]').forEach(function(tr) {
            tr.style.background = '#fff5f5';
        });
        table.querySelectorAll('tr.das-row[data-status="partial"]').forEach(function(tr) {
            tr.style.background = '#fffcf0';
        });
    });
</script>
@endsection
