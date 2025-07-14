@extends('layout.master')
@section('content')
    @php
        $data = [
            'ISLAM_MEMILIKI_LK',
            'ISLAM_MEMILIKI_PR',
            'ISLAM_MEMILIKI_JML',
            'ISLAM_BLM_MEMILIKI_JML',

            'KRISTEN_MEMILIKI_LK',
            'KRISTEN_MEMILIKI_PR',
            'KRISTEN_MEMILIKI_JML',
            'KRISTEN_BLM_MEMILIKI_JML',

            'KATHOLIK_MEMILIKI_LK',
            'KATHOLIK_MEMILIKI_PR',
            'KATHOLIK_MEMILIKI_JML',
            'KATHOLIK_BLM_MEMILIKI_JML',

            'HINDU_MEMILIKI_LK',
            'HINDU_MEMILIKI_PR',
            'HINDU_MEMILIKI_JML',
            'HINDU_BLM_MEMILIKI_JML',

            'BUDHA_MEMILIKI_LK',
            'BUDHA_MEMILIKI_PR',
            'BUDHA_MEMILIKI_JML',
            'BUDHA_BLM_MEMILIKI_JML',

            'KHONGHUCU_MEMILIKI_LK',
            'KHONGHUCU_MEMILIKI_PR',
            'KHONGHUCU_MEMILIKI_JML',
            'KHONGHUCU_BLM_MEMILIKI_JML',

            'KEPERCAYAAN_MEMILIKI_LK',
            'KEPERCAYAAN_MEMILIKI_PR',
            'KEPERCAYAAN_MEMILIKI_JML',
            'KEPERCAYAAN_BLM_MEMILIKI_JML',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepemilikan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Akta Kawin Agama</a></li>
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
                            'id' => 'formSearchKepemilikanAktaKawinAgama',
                            'method' => 'post',
                            'route' => ['search_data', 'PKf3FqywDa'],
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
                            {{-- <button type="submir" class="btn btn-primary">
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
                                        <th class="text-uppercase">Agama</th>
                                        <th class="text-uppercase">Laki - Laki (Memiliki)</th>
                                        <th class="text-uppercase">Perempuan (Memiliki)</th>
                                        <th class="text-uppercase">Jumlah (Memiliki)</th>
                                        <th class="text-uppercase">Jumlah (Belum Memiliki)</th>
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
                                        <th>KECAMATAN</th>
                                        @foreach ($data as $item)
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
                        <h4 class="card-title">Perkelurahan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKelurahan" class="table table-bordered display" style="min-width: 845px">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>KECAMATAN</th>
                                        <th>KELURAHAN</th>
                                        @foreach ($data as $item)
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
    <script src="{{ asset('js/index/kepemilikan/akta_kawin_agama.js') }}"></script>
@endsection
