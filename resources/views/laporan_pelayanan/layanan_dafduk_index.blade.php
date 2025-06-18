@extends('layout.master')
@section('content')
    @php
        $atributeTable = [
            'kode_wilayah',
            'penerbitan_kk',
            'perubahan_kk',
            'penerbitan_nik_wni_lk',
            'penerbitan_nik_wni_pr',
            'penerbitan_nik_wni_jml',
            'penerbitan_nik_oa_lk',
            'penerbitan_nik_oa_pr',
            'penerbitan_nik_oa_jml',
            'pencetakan_kia_lk',
            'pencetakan_kia_pr',
            'pencetakan_kia_jml',
            'ktp_el_rekam_lk',
            'ktp_el_rekam_pr',
            'ktp_el_rekam_jml',
            'ktp_el_cetak_lk',
            'ktp_el_cetak_pr',
            'ktp_el_cetak_jml',
            'jml_surat_pindah',
            'jml_pindah_lk',
            'jml_pindah_pr',
            'jml_pindah_jml',
            'jml_surat_datang',
            'jml_datang_lk',
            'jml_datang_pr',
            'jml_datang_jml',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Pelayanan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">DAFDUK(Pendaftaran Penduduk)</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tanggal</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchDataLayananDafduk',
                            'method' => 'post',
                            'route' => ['search_data', '7yZk8WvNmD'],
                        ]) !!}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" id="from" name="from">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="date" class="form-control" id="to" name="to">
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
                        <h4 class="card-title" id="tanggalRequest"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-responsive" id="tableSum">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Nama Layanan</th>
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
                                        @foreach ($atributeTable as $item)
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
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        @foreach ($atributeTable as $item)
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
    <script src="{{ asset('js/pelayanan/dafduk.js') }}"></script>
@endsection
