@extends('layout.master')
@section('content')
    @php
        $data = [
            'disabilitas Fisik LK',
            'disabilitas Fisik PR',
            'disabilitas Fisik JML',
            'disabilitas Netra / Buta LK',
            'disabilitas Netra / Buta PR',
            'disabilitas Netra / Buta JML',
            'disabilitas Rungu / Wicara LK',
            'disabilitas Rungu / Wicara PR',
            'disabilitas Rungu / Wicara JML',
            'disabilitas Mental / Jiwa LK',
            'disabilitas Mental / Jiwa PR',
            'disabilitas Mental / Jiwa JML',
            'disabilitas Fisik & Mental LK',
            'disabilitas Fisik & Mental PR',
            'disabilitas Fisik & Mental JML',
            'disabilitas Lainya LK',
            'disabilitas Lainya PR',
            'disabilitas Lainya JML',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Disabilitas</a></li>
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
                            'id' => 'formSearchStrukturUmurAgamaKelompokAgama',
                            'method' => 'POST',
                            'route' => ['search_data', 'VtDkcpu8FN'],
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
                                <div class="col-md-12">
                                    <select id="disabilitasFilter" class="mb-3 text-uppercase">
                                        <option value="">All</option>
                                        <option value="FISIK">Fisik</option>
                                        <option value="FISIK MENTAL">Fisik Mental</option>
                                        <option value="RUNGU WICARA">RUNGU WICARA</option>
                                        <option value="NETRA BUTA">Netra Buta</option>
                                        <option value="MENTAL JIWA">MENTAL JIWA</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Agama</th>
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
                                        <th class="text-uppercase">Kelompok Umur</th>
                                        @foreach ($data as $item)
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
                                        <th class="text-uppercase">Kelompok Umur</th>
                                        @foreach ($data as $item)
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
    <script src="{{ asset('js/index/struktur_umur/disabilitas/kelompok_umur.js') }}"></script>
@endsection
