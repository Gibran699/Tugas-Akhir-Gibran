@extends('layout.master')
@section('content')
    @php
        $categories = [
            'JUMLAH AWAL(LK)',
            'JUMLAH AWAL(PR)',
            'JUMLAH AWAL(JML)',
            'MEMILIKI AWAL(LK)',
            'MEMILIKI AWAL(PR)',
            'MEMILIKI AWAL(JML)',
            'BELUM MEMILIKI AWAL(LK)',
            'BELUM MEMILIKI AWAL(PR)',
            'BELUM MEMILIKI AWAL(JML)',
            'PERSEN AWAL(%)',
            'USIA LEBIH TARGET(LK)',
            'USIA LEBIH TARGET(PR)',
            'USIA LEBIH TARGET(JML)',
            'MENINGGAL(LK)',
            'MENINGGAL(PR)',
            'MENINGGAL(JML)',
            'NONAKTIF(LK)',
            'NONAKTIF(PR)',
            'NONAKTIF(JML)',
            'MEMILIKI DALAM DKB(LK)',
            'MEMILIKI DALAM DKB(PR)',
            'MEMILIKI DALAM DKB(JML)',
            'MEMILIKI LUAR DKB(LK)',
            'MEMILIKI LUAR DKB(PR)',
            'MEMILIKI LUAR DKB(JML)',
            'JUMLAH DINAMIS(LK)',
            'JUMLAH DINAMIS(PR)',
            'JUMLAH DINAMIS(TTL)',
            'MEMILIKI DINAMIS(LK)',
            'MEMILIKI DINAMIS(PR)',
            'MEMILIKI DINAMIS(JML)',
            'BELUM MEMILIKI DINAMIS(LK)',
            'BELUM MEMILIKI DINAMIS(PR)',
            'BELUM MEMILIKI DINAMIS(JML)',
            'PERSEN DINAMIS(%)',
            'PENAMBAHAN(LK)',
            'PENAMBAHAN(PR)',
            'PENAMBAHAN(JML)',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepemilikan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">KIA</a></li>
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
                            'id' => 'formSearchKepemilikanKia',
                            'method' => 'post',
                            'route' => ['search_data', '2ovlKZBzGU'],
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
                            {{-- <button type="submit" class="btn btn-primary" >
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
                            <table class="display table table-striped" id="tableSum">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Keterangan</th>
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
    <script src="{{asset('js/index/kepemilikan/kia.js')}}"></script>
@endsection
