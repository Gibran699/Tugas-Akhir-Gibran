@extends('layout.master')
@section('content')
    @php
        $bloodTypes = [
            'A (LK)',
            'A (PR)',
            'A (JML)',
            'A- (LK)',
            'A- (PR)',
            'A- (JML)',
            'A+ (LK)',
            'A+ (PR)',
            'A+ (JML)',
            'B (LK)',
            'B (PR)',
            'B (JML)',
            'B- (LK)',
            'B- (PR)',
            'B- (JML)',
            'B+ (LK)',
            'B+ (PR)',
            'B+ (JML)',
            'AB (LK)',
            'AB (PR)',
            'AB (JML)',
            'AB- (LK)',
            'AB- (PR)',
            'AB- (JML)',
            'AB+ (LK)',
            'AB+ (PR)',
            'AB+ (JML)',
            'O (LK)',
            'O (PR)',
            'O (JML)',
            'O- (LK)',
            'O- (PR)',
            'O- (JML)',
            'O+ (LK)',
            'O+ (PR)',
            'O+ (JML)',
            'TIDAK TAHU (LK)',
            'TIDAK TAHU (PR)',
            'TIDAK TAHU (JML)',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Penduduk - Golongan Darah</a></li>
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
                            'id' => 'formPendudukGolonganDarah',
                            'method' => 'post',
                            'route' => ['search_data', 'aPH7zF09S1'],
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
                            {{-- <button type="submit" class="btn btn-primary">
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
                        <h4 class="card-title" id="tahunSemester"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableSum" class="display table table-striped table-responsive"
                                style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Golonga Darah</th>
                                        <th>Laki -Laki</th>
                                        <th>Perempuan</th>
                                        <th>Jumlah</th>
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
                            <table id="tableKecamatan" class="display table table-bordered table-responssive"
                                style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>KECAMATAN</th>
                                        @foreach ($bloodTypes as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach
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
                        <h4 class="card-title">Perkelurahan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKelurahan" class="display table table-bordered table-responssive"
                                style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>KECAMATAN</th>
                                        <th>KELURAHAN</th>
                                        @foreach ($bloodTypes as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach
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
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        generateYearOptions('tahun');
    </script>
    <script src="{{asset('js/index/agregat_dkb/penduduk/goldar.js')}}"></script>
@endsection
