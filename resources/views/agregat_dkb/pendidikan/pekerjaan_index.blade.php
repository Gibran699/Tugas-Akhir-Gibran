@extends('layout.master')
@section('content')
    @php
        $job = config('dataArray.categoryJob');
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pendidikan - Pekerjaan</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Semester & Tahun</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchPendidikanPekerjaan',
                            'method' => 'post',
                            'route' => ['search_data', 'eRPt22HZkf'],
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
                                        <th class="text-uppercase">Pekerjaan</th>
                                        <th class="text-uppercase">Pendidikan</th>
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
                            <table id="tableKecamatan" class="table table-bordered display" style="min-width: 845px">
                                <thead class="thead-primary">
                                    <tr class="text-uppercase">
                                        <th class="text-uppercase">KECAMATAN</th>
                                        <th class="text-uppercase">Keterangan</th>
                                        @foreach ($job as $item)
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
                            <table id="tableKelurahan" class="table table-bordered display" style="min-width: 845px">
                                <thead class="thead-primary">
                                    <tr class="text-uppercase">
                                        <th class="text-uppercase">KECAMATAN</th>
                                        <th class="text-uppercase">KELURAHAN</th>
                                        <th class="text-uppercase">Keterangan</th>
                                        @foreach ($job as $item)
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
    <script src="{{ asset('js/index/agregat_dkb/pendidikan/pekerjaan.js') }}"></script>
@endsection
