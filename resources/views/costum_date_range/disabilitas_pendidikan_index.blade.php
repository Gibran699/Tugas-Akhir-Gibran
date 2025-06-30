@extends('layout.master')
@section('content')
@php
    $atributField = config('dataArray.categoryEducationDisabilites');
@endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Costum Kelompok Umur</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Disabilitas Pendidikan</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Pencarian</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchDateRangeAgeDisabilitasPendidikan',
                            'method' => 'post',
                            'route' => ['search_data', '7fGk2pQ9Lm'],
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
                            <div class="col-md-6 mb-3">
                                <input type="number" class="form-control" id="from" name="from" placeholder="dari umur">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="number" class="form-control" id="to" name="to" placeholder="sampai umur">
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
                        <h4 class="card-title" id="title"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <select id="educationFilter" class="mb-2">
                                <option value="">All</option>
                                <option value="TIDAK BELUM SEKOLAH">Tidak Blm Sekolah</option>
                                <option value="BELUM TAMAT SD SEDERAJAT">Belum Tamat SD Sederajat</option>
                                <option value="TAMAT SD SEDERAJAT">Tamat SD Sederajat</option>
                                <option value="SLTP SEDERAJAT">SLTP Sederajat</option>
                                <option value="SLTA SEDERAJAT">SLTA Sederajat</option>
                                <option value="DIPLOMA I II">Diploma I/II</option>
                                <option value="AKADEMI DIPLOMA III S MUDA">Akademi Diploma III/S. Muda</option>
                                <option value="DIPLOMA IV STRATA I">Diploma IV/Strata I</option>
                                <option value="STRATA II">Strata II</option>
                                <option value="STRATA III">Strata III</option>
                            </select>
                            <table class="display table table-striped" id="tableSum">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Pendidikan & Disabilitas</th>
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
                        <h4 class="card-title">Perkecamatan</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKecamatan" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Kecamatan</th>
                                        @foreach ($atributField as $item)
                                            <th>{{ $item }}</th>
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
                        <h4 class="card-title">Perkelurahan</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKelurahan" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Kecamatan</th>
                                        <th class="text-uppercase">Kelurahan</th>
                                        @foreach ($atributField as $item)
                                            <th>{{ $item }}</th>
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
    <script src="{{asset('js/index/date_range/disabilitas_pendidikan.js')}}"></script>
@endsection
