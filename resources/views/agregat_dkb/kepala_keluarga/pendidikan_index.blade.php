@extends('layout.master')
@section('content')
    @php
        $educationalStatuses = [
            'TIDAK/BLM SEKOLAH L',
            'TIDAK/BLM SEKOLAH P',
            'TIDAK/BLM SEKOLAH JML',
            'BELUM TAMAT SD/SEDERAJAT L',
            'BELUM TAMAT SD/SEDERAJAT P',
            'BELUM TAMAT SD/SEDERAJAT JML',
            'TAMAT SD/SEDERAJAT L',
            'TAMAT SD/SEDERAJAT P',
            'TAMAT SD/SEDERAJAT JML',
            'SLTP/SEDERAJAT L',
            'SLTP/SEDERAJAT P',
            'SLTP/SEDERAJAT JML',
            'SLTA/SEDERAJAT L',
            'SLTA/SEDERAJAT P',
            'SLTA/SEDERAJAT JML',
            'DIPLOMA I/II L',
            'DIPLOMA I/II P',
            'DIPLOMA I/II JML',
            'AKADEMI/DIPL.III/S. MUDA L',
            'AKADEMI/DIPL.III/S.MUDA P',
            'AKADEMI/DIPL.III/S.MUDA JML',
            'DIPLOMA IV/STRATA I L',
            'DIPLOMA IV/STRATA I P',
            'DIPLOMA IV/STRATA I JML',
            'STRATA-II L',
            'STRATA-II P',
            'STRATA-II JML',
            'STRATA-III L',
            'STRATA-III P',
            'STRATA-III JML',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepala Keluarga</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pendidikan</a></li>
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
                            'id' => 'formSearchKepalaKeluargaPendidikan',
                            'method' => 'post',
                            'route' => ['search_data', 'gblPf8pfSp'],
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
                                        <th class="text-uppercase">Pendidikan</th>
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
                    <div class="card-header">
                        <h4 class="card-title">Perkecamatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKecamatan" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        @foreach ($educationalStatuses as $item)
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
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        @foreach ($educationalStatuses as $item)
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
    <script src="{{ asset('js/index/agregat_dkb/kepala_keluarga/pendidikan.js') }}"></script>
@endsection
