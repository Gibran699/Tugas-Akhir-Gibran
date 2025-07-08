@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Penduduk - Agama</a></li>
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
                            'id' => 'formSearchPendudukAgama',
                            'method' => 'post',
                            'route' => ['search_data', 'MupFCfSa6a'],
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
                            <table class="display table table-striped table-responsive" id="tableSum">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Nama Agama</th>
                                        <th class="text-uppercase">Laki - Laki</th>
                                        <th class="text-uppercase">Perempuan</th>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-bordered table-responsive" id="tableKecamatan">
                                <thead class="thead-primary">
                                    <tr>
                                        <th class="text-uppercase">Kecamatan</th>
                                        <th class="text-uppercase">Islam LK</th>
                                        <th class="text-uppercase">Islam PR</th>
                                        <th class="text-uppercase">Islam JML</th>
                                        <th class="text-uppercase">Katholik LK</th>
                                        <th class="text-uppercase">Katholik PR</th>
                                        <th class="text-uppercase">Katholik JML</th>
                                        <th class="text-uppercase">Kristen LK</th>
                                        <th class="text-uppercase">Kristen PR</th>
                                        <th class="text-uppercase">Kristen JML</th>
                                        <th class="text-uppercase">Hindu LK</th>
                                        <th class="text-uppercase">Hindu PR</th>
                                        <th class="text-uppercase">Hindu JML</th>
                                        <th class="text-uppercase">Budha LK</th>
                                        <th class="text-uppercase">Budha PR</th>
                                        <th class="text-uppercase">Budha JML</th>
                                        <th class="text-uppercase">Konghucu LK</th>
                                        <th class="text-uppercase">Konghucu PR</th>
                                        <th class="text-uppercase">Konghucu JML</th>
                                        <th class="text-uppercase">Kepercayaan LK</th>
                                        <th class="text-uppercase">Kepercayaan PR</th>
                                        <th class="text-uppercase">Kepercayaan JML</th>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKelurahan" class="table table-bordered display" style="min-width: 845px">
                                <thead class="thead-primary">
                                    <tr>
                                        <th class="text-uppercase">KECAMATAN</th>
                                        <th class="text-uppercase">KELURAHAN</th>
                                        <th class="text-uppercase">Islam LK</th>
                                        <th class="text-uppercase">Islam PR</th>
                                        <th class="text-uppercase">Islam JML</th>
                                        <th class="text-uppercase">Katholik LK</th>
                                        <th class="text-uppercase">Katholik PR</th>
                                        <th class="text-uppercase">Katholik JML</th>
                                        <th class="text-uppercase">Kristen LK</th>
                                        <th class="text-uppercase">Kristen PR</th>
                                        <th class="text-uppercase">Kristen JML</th>
                                        <th class="text-uppercase">Hindu LK</th>
                                        <th class="text-uppercase">Hindu PR</th>
                                        <th class="text-uppercase">Hindu JML</th>
                                        <th class="text-uppercase">Budha LK</th>
                                        <th class="text-uppercase">Budha PR</th>
                                        <th class="text-uppercase">Budha JML</th>
                                        <th class="text-uppercase">Konghucu LK</th>
                                        <th class="text-uppercase">Konghucu PR</th>
                                        <th class="text-uppercase">Konghucu JML</th>
                                        <th class="text-uppercase">Kepercayaan LK</th>
                                        <th class="text-uppercase">Kepercayaan PR</th>
                                        <th class="text-uppercase">Kepercayaan JML</th>
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
    <script src="{{ asset('js/index/agregat_dkb/penduduk/agama.js') }}"></script>
@endsection
