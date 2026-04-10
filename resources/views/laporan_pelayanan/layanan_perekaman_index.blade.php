@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Pelayanan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Perekaman</a></li>
            </ol>
        </div>
        {{-- ── Cara Penggunaan ── --}}
        <div class="col-xl-12 col-md-12 mb-2">
            <div class="alert mb-0" style="
                background: linear-gradient(135deg,#eef4ff 0%,#f0fdf4 100%);
                border: 1px solid #c7d9f8; border-radius: 14px; padding: 16px 20px;">
                <div class="d-flex align-items-flex-start gap-3">
                    <div style="
                        width:38px;height:38px;border-radius:10px;flex-shrink:0;
                        background:linear-gradient(135deg,#4f8ef7,#2563eb);
                        display:flex;align-items:center;justify-content:center;
                        color:#fff;font-size:16px;">
                        <i class="fas fa-info"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:14px;color:#1e3a6e;margin-bottom:6px;">
                            Cara Melihat Data Perekaman
                        </div>
                        <ol style="margin:0;padding-left:18px;font-size:13px;color:#374151;line-height:1.9;">
                            <li>Pilih <strong>Tanggal Mulai</strong> dan <strong>Tanggal Selesai</strong> pada kolom di bawah.</li>
                            <li>Klik tombol <strong>Tampilkan</strong> untuk memuat data rekaman dalam rentang tanggal tersebut.</li>
                            <li>Tabel akan menampilkan total rekaman per hari. Klik tombol <strong>Detail</strong> pada baris tanggal untuk melihat rincian per petugas.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h4 class="card-title mb-1">Filter Rentang Tanggal</h4>
                        <p class="mb-0 text-muted" style="font-size:13px;">
                            Tentukan periode waktu untuk melihat data perekaman.
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchDataLayananPerekaman',
                            'method' => 'post',
                            'route' => ['search_data', '7x9Fk2pQ8R'],
                            'data-no-loading' => 'true',
                        ]) !!}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" style="font-size:13px;">
                                    <i class="fas fa-calendar-alt me-1 text-primary"></i> Tanggal Mulai
                                </label>
                                <input type="date" class="form-control" id="from" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" style="font-size:13px;">
                                    <i class="fas fa-calendar-check me-1 text-success"></i> Tanggal Selesai
                                </label>
                                <input type="date" class="form-control" id="to" name="end_date">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Tampilkan
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="totalKeseluruhan"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="rekamTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total Rekam</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Details for <span id="modalDate"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="detailsTable">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/pelayanan/perekaman.js') }}"></script>
@endsection
