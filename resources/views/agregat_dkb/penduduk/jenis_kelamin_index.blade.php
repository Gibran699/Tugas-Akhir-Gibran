@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Penduduk - Jenis Kelamin</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Semester & Tahun</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchPendudukJenisKelamin',
                            'method' => 'post',
                            'route' => ['search_data', 'CV8V59hUCF'],
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
            <h3 id="tahunSemester"></h3>
            <div class="col-xl-4 col-xxl-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Chart</h4>
                            </div>
                            <div class="card-body">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class="">
                                        </div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class="">
                                        </div>
                                    </div>
                                </div>
                                <canvas id="chartPendudukJenisKelamin" width="810" height="590"
                                    style="display: block; width: 405px; height: 295px;"
                                    class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="la la-users"></i>
                                    </span>
                                    <div class="media-body text-white">
                                        <p class="mb-1">LK & PR</p>
                                        <h3 class="text-white" id="totalCard"></h3>
                                        {{-- <div class="progress mb-2 bg-primary">
                                            <div class="progress-bar progress-animated bg-light" style="width: 50%"></div>
                                        </div> --}}
                                        <small>Jumlah Penduduk Kota Samarinda</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-xxl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-md-12">
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
                                                    <th>LAKI-LAKI </th>
                                                    <th>PEREMPUAN</th>
                                                    <th>JUMLAH</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
                                        <th>LAKI-LAKI </th>
                                        <th>PEREMPUAN</th>
                                        <th>JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
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
    <script src="{{asset('js/index/agregat_dkb/penduduk/jenis_kelamin.js')}}"></script>
@endsection
