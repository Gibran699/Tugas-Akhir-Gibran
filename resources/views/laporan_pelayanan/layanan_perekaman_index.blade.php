@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Pelayanan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Perekaman</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tanggal</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchDataLayananPerekaman',
                            'method' => 'post',
                            'route' => ['search_data', '7x9Fk2pQ8R'],
                        ]) !!}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" id="from" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" id="to" name="end_date">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-list"></i> Tampilkan
                            </button>
                            {{-- <button type="button" class="btn btn-primary" id="submitSearch">
                                <i class="fa fa-list"></i> Tampilkan
                            </button> --}}
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
