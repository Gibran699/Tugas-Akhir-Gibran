@extends('layout.master')
@section('content')
    @php
        $data = [
            'KEPALA_KELUARGA_L',
            'KEPALA_KELUARGA_P',
            'KEPALA_KELUARGA_JML',
            'SUAMI_L',
            'SUAMI_P',
            'SUAMI_JML',
            'ISTERI_L',
            'ISTERI_P',
            'ISTERI_JML',
            'ANAK_L',
            'ANAK_P',
            'ANAK_JML',
            'MENANTU_L',
            'MENANTU_P',
            'MENANTU_JML',
            'CUCU_L',
            'CUCU_P',
            'CUCU_JML',
            'ORANG_TUA_L',
            'ORANG_TUA_P',
            'ORANG_TUA_JML',
            'MERTUA_L',
            'MERTUA_P',
            'MERTUA_JML',
            'FAMILI_LAIN_L',
            'FAMILI_LAIN_P',
            'FAMILI_LAIN_JML',
            'PEMBANTU_L',
            'PEMBANTU_P',
            'PEMBANTU_JML',
            'LAINNYA_L',
            'LAINNYA_P',
            'LAINNYA_JML',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Penduduk - Hubungan Keluarga</a></li>
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
                            'id' => 'formPendudukHubunganKeluarga',
                            'method' => 'post',
                            'route' => ['search_data', 'bfl4aaeCTi'],
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
                            <table id="tableSum" class="display table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Hubungan Keluarga</th>
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
    <script src="{{asset('js/index/agregat_dkb/penduduk/hubkel.js')}}"></script>
@endsection
