@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Pelayanan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Smart Service (Online)</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tanggal</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchDataLayananOnline',
                            'method' => 'post',
                            'route' => ['search_data', 'kP9mY2qR7s'],
                            'data-no-loading' => 'true',
                        ]) !!}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" id="from" name="start">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" id="to" name="finish">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{-- <button type="submit" class="btn btn-primary">
                                <i class="fa fa-list"></i> Tampilkan
                            </button> --}}
                            <button type="button" class="btn btn-primary" id="submitSearch">
                                <i class="fa fa-list"></i> Tampilkan
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xxl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="la la-file-alt"></i>
                                    </span>
                                    <div class="media-body text-white">
                                        <p class="mb-1">Permohonan</p>
                                        <h2 class="text-white" id="submissionCard"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="la la-pen-square"></i>
                                    </span>
                                    <div class="media-body text-white">
                                        <p class="mb-1">Proses</p>
                                        <h2 class="text-white" id="prosesCard"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="la la-window-close"></i>
                                    </span>
                                    <div class="media-body text-white">
                                        <p class="mb-1">Tidak Sesuai</p>
                                        <h2 class="text-white" id="tidakSesuaiCard"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="la la-check-square"></i>
                                    </span>
                                    <div class="media-body text-white">
                                        <p class="mb-1">Selesai</p>
                                        <h2 class="text-white" id="selesaiCard"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Chart Empty State --}}
            <div class="col-12 mb-1" id="chartEmptyState">
                <div class="card border-0 shadow-sm" style="border-radius:16px;background:linear-gradient(135deg,#f8f9fa 0%,#eef0f4 100%);">
                    <div class="card-body py-4 text-center">
                        <i class="fas fa-chart-bar text-muted mb-2 d-block" style="font-size:2.5rem;opacity:0.25;"></i>
                        <p class="text-muted mb-0" style="font-size:0.875rem;">
                            Pilih rentang tanggal dan klik <strong>Tampilkan</strong> untuk melihat chart rata-rata bulanan
                        </p>
                    </div>
                </div>
            </div>

            {{-- Chart Section (shown after data loaded) --}}
            <div class="col-12" id="chartSection" style="display:none;">
                <div class="row g-3 mb-3">

                    {{-- Doughnut: Total Status Distribution --}}
                    <div class="col-xl-4 col-lg-5 col-md-12">
                        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;">
                            <div class="card-header border-0 py-3 px-4"
                                 style="background:linear-gradient(135deg,#434E78 0%,#607B8F 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-chart-pie text-warning"></i>
                                    <h5 class="mb-0 text-white fw-semibold" style="font-size:0.9rem;">
                                        Distribusi Total Status
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div style="position:relative;height:290px;">
                                    <canvas id="chartStatusDistribusi"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Grouped Bar: Monthly Average per Service --}}
                    <div class="col-xl-8 col-lg-7 col-md-12">
                        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;">
                            <div class="card-header border-0 py-3 px-4"
                                 style="background:linear-gradient(135deg,#1a6b3a 0%,#2ecc71 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-chart-bar text-white"></i>
                                    <h5 class="mb-0 text-white fw-semibold" style="font-size:0.9rem;">
                                        Rata-rata Bulanan Per Layanan
                                        <small id="chartRangeLabel" class="fw-normal ms-1"
                                               style="font-size:0.72rem;opacity:0.85;"></small>
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div style="position:relative;height:290px;">
                                    <canvas id="chartRataRataBulanan"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="tanggalRequest"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-responsive" id="tableLayananOnline">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-uppercase">Nama Layanan</th>
                                        <th class="text-uppercase">Permohonan</th>
                                        <th class="text-uppercase">Proses Validasi</th>
                                        <th class="text-uppercase">Proses Pengerjaan</th>
                                        <th class="text-uppercase">Selesai</th>
                                        <th class="text-uppercase">Tidak Sesuai</th>
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
    <script src="{{ asset('js/pelayanan/online.js') }}"></script>
@endsection
