@extends('layout.master')
@section('content')
    @php
        $data = [
            'islam_memiliki_lk',
            'islam_memiliki_pr',
            'islam_memiliki_jml',
            'islam_blm_memiliki_jml',
            'kristen_memiliki_lk',
            'kristen_memiliki_pr',
            'kristen_memiliki_jml',
            'kristen_blm_memiliki_jml',
            'katholik_memiliki_lk',
            'katholik_memiliki_pr',
            'katholik_memiliki_jml',
            'katholik_blm_memiliki_jml',
            'hindu_memiliki_lk',
            'hindu_memiliki_pr',
            'hindu_memiliki_jml',
            'hindu_blm_memiliki_jml',
            'budha_memiliki_lk',
            'budha_memiliki_pr',
            'budha_memiliki_jml',
            'budha_blm_memiliki_jml',
            'khonghucu_memiliki_lk',
            'khonghucu_memiliki_pr',
            'khonghucu_memiliki_jml',
            'khonghucu_blm_memiliki_jml',
            'kepercayaan_memiliki_lk',
            'kepercayaan_memiliki_pr',
            'kepercayaan_memiliki_jml',
            'kepercayaan_blm_memiliki_jml',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepemilikan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Akta Cerai Agama</a></li>
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
                            'id' => 'formSearchKepemilikanAktaCeraiAgama',
                            'method' => 'post',
                            'route' => ['search_data', 'eCnoaOxtiS'],
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
                            <table id="tableKecamatan" class="display" style="min-width: 845px">
                                <thead>
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
                            <table id="tableKelurahan" class="display" style="min-width: 845px">
                                <thead>
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
    <script src="{{ asset('js/index/kepemilikan/akta_cerai_agama.js') }}"></script>
@endsection
