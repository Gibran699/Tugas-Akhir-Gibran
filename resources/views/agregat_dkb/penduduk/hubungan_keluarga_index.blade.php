@extends('layout.master')
@section('content')
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
                        <form>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-list"></i> Tampilkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Penduduk - Hubungan Keluarga <span id="tahunSemester">I
                                2025</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                            <table id="table" class="display" style="min-width: 845px">
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
    @include('elements.data_table')
@endsection
