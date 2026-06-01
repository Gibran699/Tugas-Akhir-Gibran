@extends('layout.master')
@section('content')
    @php
        // Header tabel pakai daftar kolom status kawin (kawin_lk, belum_kawin_lk, dll)
        // sesuai struktur tabel `status_kawin_penduduk_jenis_kelamin`.
        $marriageStatus = config('dataArray.categoryMarriageStatus');

        // Label rapi untuk header tabel
        $marriageLabels = [
            'kawin_lk'       => 'Kawin (L)',
            'kawin_pr'       => 'Kawin (P)',
            'belum_kawin_lk' => 'Belum Kawin (L)',
            'belum_kawin_pr' => 'Belum Kawin (P)',
            'cerai_hidup_lk' => 'Cerai Hidup (L)',
            'cerai_hidup_pr' => 'Cerai Hidup (P)',
            'cerai_mati_lk'  => 'Cerai Mati (L)',
            'cerai_mati_pr'  => 'Cerai Mati (P)',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Status Kawin</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Jenis Kelamin</a></li>
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
                            'id' => 'formSearchStatusKawinJenisKelamin',
                            'method' => 'post',
                            'route' => ['search_data', 'oqhOV9WfkB'],
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
                            <table class="display table table-striped table-responsive" id="tableSum">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Status Kawin</th>
                                        <th class="text-uppercase">Laki - Laki</th>
                                        <th class="text-uppercase">Perempuan</th>
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
                                    <tr>
                                        <th>Kecamatan</th>
                                        @foreach ($marriageStatus as $item)
                                            <th class="text-uppercase">{{ $marriageLabels[$item] ?? str_replace('_', ' ', $item) }}</th>
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
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        @foreach ($marriageStatus as $item)
                                            <th class="text-uppercase">{{ $marriageLabels[$item] ?? str_replace('_', ' ', $item) }}</th>
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
    <script src="{{ asset('js/index/agregat_dkb/status_kawin/jenis_kelamin.js') }}"></script>
@endsection
