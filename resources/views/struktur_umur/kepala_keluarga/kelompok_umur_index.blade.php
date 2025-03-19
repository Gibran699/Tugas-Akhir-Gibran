@extends('layout.master')
@section('content')
    @php
        $ageGroups = [
            '00-04 TAHUN(LK)',
            '00-04 TAHUN(PR)',
            '00-04 TAHUN(JML)',
            '05-09 TAHUN(LK)',
            '05-09 TAHUN(PR)',
            '05-09 TAHUN(JML)',
            '10-14 TAHUN(LK)',
            '10-14 TAHUN(PR)',
            '10-14 TAHUN(JML)',
            '15-19 TAHUN(LK)',
            '15-19 TAHUN(PR)',
            '15-19 TAHUN(JML)',
            '20-24 TAHUN(LK)',
            '20-24 TAHUN(PR)',
            '20-24 TAHUN(JML)',
            '25-29 TAHUN(LK)',
            '25-29 TAHUN(PR)',
            '25-29 TAHUN(JML)',
            '30-34 TAHUN(LK)',
            '30-34 TAHUN(PR)',
            '30-34 TAHUN(JML)',
            '35-39 TAHUN(LK)',
            '35-39 TAHUN(PR)',
            '35-39 TAHUN(JML)',
            '40-44 TAHUN(LK)',
            '40-44 TAHUN(PR)',
            '40-44 TAHUN(JML)',
            '45-49 TAHUN(LK)',
            '45-49 TAHUN(PR)',
            '45-49 TAHUN(JML)',
            '50-54 TAHUN(LK)',
            '50-54 TAHUN(PR)',
            '50-54 TAHUN(JML)',
            '55-59 TAHUN(LK)',
            '55-59 TAHUN(PR)',
            '55-59 TAHUN(JML)',
            '60-64 TAHUN(LK)',
            '60-64 TAHUN(PR)',
            '60-64 TAHUN(JML)',
            '65-69 TAHUN(LK)',
            '65-69 TAHUN(PR)',
            '65-69 TAHUN(JML)',
            '70-74 TAHUN(LK)',
            '70-74 TAHUN(PR)',
            '70-74 TAHUN(JML)',
            '>75 TAHUN(LK)',
            '>75 TAHUN(PR)',
            '>75 TAHUN(JML)',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepala Keluarga</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kelompok Umur</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Semester & Tahun</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchKepalaKeluargaKelompokUmur',
                            'method' => 'post',
                            'route' => ['search_data', 'svFaBJRBLQ'],
                        ]) !!}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="semester" id="semester" class="form-control default-select">
                                    <option value="" disabled selected>--PILIH Semester--</option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="tahun" id="tahun" class="form-control default-select">
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="tahunSemester"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped" id="tableSum">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Kelompok Umur</th>
                                        <th class="text-uppercase">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Perkecamatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKecamatan" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Kecamatan</th>
                                        <th class="text-uppercase">Umur</th>
                                        @foreach ($ageGroups as $item)
                                            <th class="text-uppercase">{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Perkelurahan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKelurahan" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Kecamatan</th>
                                        <th class="text-uppercase">Kelurahan</th>
                                        <th class="text-uppercase">Umur</th>
                                        @foreach ($ageGroups as $item)
                                            <th class="text-uppercase">{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        generateYearOptions('tahun');
    </script>
    <script src="{{ asset('js/index/struktur_umur/kepala_keluarga/kelompok_umur.js') }}"></script>
@endsection
