@extends('layout.master')
@section('content')
    @php
        $categories = [
            'WAJIB AKTA(AWAL - LK)',
            'WAJIB AKTA(AWAL-PR)',
            'WAJIB AKTA(AWAL-JML)',
            'MEMILIKI(AWAL-LK)',
            'MEMILIKI(AWAL-PR)',
            'MEMILIKI(AWAL-JML)',
            'BELUM MEMILIKI(AWAL-LK)',
            'BELUM MEMILIKI(AWAL-PR)',
            'BELUM MEMILIKI(AW AL-LK)',
            'BELUM MEMILIKI(AWAL-PR)',
            'BELUM MEMILIKI(AWAL-JML)',
            'PERSEN (AWAL)(%)',
            'USIA LEBIH DARI TARGET(LK)',
            'USIA LEBIH DARI TARGET(PR)',
            'USIA LEBIH DARI TARGET(JML)',
            'MENINGGAL(LK)',
            'MENINGGAL(PR)',
            'MENINGGAL(JML)',
            'NONAKTIF(LK)',
            'NONAKTIF(PR)',
            'NONAKTIF(JML)',
            'PINDAH(LK)',
            'PINDAH(PR)',
            'PINDAH(JML)',
            'DATANG(LK)',
            'DATANG(PR)',
            'DATANG(JML)',
            'Hapus OPERATOR(LK)',
            'Hapus OPERATOR(PR)',
            'Hapus OPERATOR(JML)',
            'TERBIT AKTA BARU(DALAM DKB - LK)',
            'TERBIT AKTA BARU(DALAM DKB - PR)',
            'TERBIT AKTA BARU(DALAM DKB - JML)',
            'TERBIT AKTA BARU(LUAR DKB - LK)',
            'TERBIT AKTA BARU(LUAR DKB - PR)',
            'TERBIT AKTA BARU(LUAR DKB - JML)',
            'WAJIB AKTA(DINAMIS - LK)',
            'WAJIB AKTA(DINAMIS - PR)',
            'WAJIB AKTA(DINAMIS - JML)',
            'MEMILIKI(DINAMIS - LK)',
            'MEMILIKI(DINAMIS - PR)',
            'MEMILIKI(DINAMIS - JML)',
            'BELUM MEMILIKI(DINAMIS - LK)',
            'BELUM MEMILIKI(DINAMIS - PR)',
            'BELUM MEMILIKI(DINAMIS - JML)',
            'PERSEN (DINAMIS)(%)',
            'PENAMBAHAN(LK)',
            'PENAMBAHAN(PR)',
            'PENAMBAHAN(JML)',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepemilikan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Akta Kelahiran</a></li>
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
                            'id' => 'formSearchKepemilikanAktaKelahiran',
                            'method' => 'post',
                            'route' => ['search_data', '6D6A18O1Hm'],
                        ]) !!}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <select name="semester" id="semester" class="form-control default-select">
                                    <option value="" disabled selected>--PILIH SEMESTER--</option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <select name="tahun" id="tahun" class="form-control default-select">
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <select name="keterangan" id="kategori" class="form-control default-select">
                                    <option value="" disabled selected>--PILIH KATEGORI--</option>
                                    <option value="1">SEMUA USIA</option>
                                    <option value="2">0-1</option>
                                    <option value="3">0-4</option>
                                    <option value="4">0-5</option>
                                    <option value="5">0-18</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-list"></i> Tampilkan
                            </button>
                        </div> --}}
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
                                        <th class="text-uppercase">Keterangan</th>
                                        <th class="text-uppercase">Kategori</th>
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
                            <table id="tableKecamatan" class="table table-bordered display" style="min-width: 845px">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>KECAMATAN</th>
                                        <th>KETERANGAN</th>
                                        @foreach ($categories as $item)
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
                                        <th>KETERANGAN</th>
                                        @foreach ($categories as $item)
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
    <script src="{{asset('js/index/kepemilikan/akta_kelahiran.js')}}"></script>
@endsection
