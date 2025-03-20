@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Status Kawin Umur Tunggal</a></li>
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
                            'id' => 'formSearchStatusKawinUmurTunggal',
                            'method' => 'post',
                            'route' => ['search_data','4riLDLsE6q']
                        ]) !!}
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <select name="semester" id="semester" class="form-control default-select">
                                            <option value="" disabled selected>--PILIH Semester--</option>
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <select name="tahun" id="tahun" class="form-control default-select">
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <select name="umur" id="umur">
                                        </select>
                                    </div>
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
                                        <th class="text-uppercase">Status Kawin</th>
                                        <th class="text-uppercase">Umur</th>
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
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Umur</th>
                                        <th>Belum Kawin LK</th>
                                        <th>Belum Kawin PR</th>
                                        <th>Kawin LK</th>
                                        <th>Kawin PR</th>
                                        <th>Cerai Hidup LK</th>
                                        <th>Cerai Hidup PR</th>
                                        <th>Cerai Mati LK</th>
                                        <th>Cerai Mati PR</th>
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
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Umur</th>
                                        <th>Belum Kawin LK</th>
                                        <th>Belum Kawin PR</th>
                                        <th>Kawin LK</th>
                                        <th>Kawin PR</th>
                                        <th>Cerai Hidup LK</th>
                                        <th>Cerai Hidup PR</th>
                                        <th>Cerai Mati LK</th>
                                        <th>Cerai Mati PR</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script src="{{ asset('js/index/struktur_umur/penduduk/status_kawin_umur_tunggal.js') }}"></script>
    <script>
        generateYearOptions('tahun');
        $("#umur").select2();
        selectAge()
    </script>
@endsection
