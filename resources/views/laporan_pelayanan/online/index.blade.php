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
