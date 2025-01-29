@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepala Keluarga</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)" Status Kawin>Kelompok Umur</a></li>
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
                        <h4 class="card-title">Kepala Keluarga - Status Kawin Kelompok Umur <span id="tahunSemester">I
                                2025</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $maritalStatus = [
                                    '00-04 BELUM KAWIN(LK)',
                                    '00-04 BELUM KAWIN(PR)',
                                    '00-04 KAWIN(LK)',
                                    '00-04 KAWIN(PR)',
                                    '00-04 CERAI HIDUP(LK)',
                                    '00-04 CERAI HIDUP(PR)',
                                    '00-04 CERAI MATI(LK)',
                                    '00-04 CERAI MATI(PR)',
                                    '05-09 BELUM KAWIN(LK)',
                                    '05-09 BELUM KAWIN(PR)',
                                    '05-09 KAWIN(LK)',
                                    '05-09 KAWIN(PR)',
                                    '05-09 CERAI HIDUP(LK)',
                                    '05-09 CERAI HIDUP(PR)',
                                    '05-09 CERAI MATI(LK)',
                                    '05-09 CERAI MATI(PR)',
                                    '10-14 BELUM KAWIN(LK)',
                                    '10-14 BELUM KAWIN(PR)',
                                    '10-14 KAWIN(LK)',
                                    '10-14 KAWIN(PR)',
                                    '10-14 CERAI HIDUP(LK)',
                                    '10-14 CERAI HIDUP(PR)',
                                    '10-14 CERAI MATI(LK)',
                                    '10-14 CERAI MATI(PR)',
                                    '15-19 BELUM KAWIN(LK)',
                                    '15-19 BELUM KAWIN(PR)',
                                    '15-19 KAWIN(LK)',
                                    '15-19 KAWIN(PR)',
                                    '15-19 CERAI HIDUP(LK)',
                                    '15-19 CERAI HIDUP(PR)',
                                    '15-19 CERAI MATI(LK)',
                                    '15-19 CERAI MATI(PR)',
                                    '20-24 BELUM KAWIN(LK)',
                                    '20-24 BELUM KAWIN(PR)',
                                    '20-24 KAWIN(LK)',
                                    '20-24 KAWIN(PR)',
                                    '20-24 CERAI HIDUP(LK)',
                                    '20-24 CERAI HIDUP(PR)',
                                    '20-24 CERAI MATI(LK)',
                                    '20-24 CERAI MATI(PR)',
                                    '25-29 BELUM KAWIN(LK)',
                                    '25-29 BELUM KAWIN(PR)',
                                    '25-29 KAWIN(LK)',
                                    '25-29 KAWIN(PR)',
                                    '25-29 CERAI HIDUP(LK)',
                                    '25-29 CERAI HIDUP(PR)',
                                    '25-29 CERAI MATI(LK)',
                                    '25-29 CERAI MATI(PR)',
                                    '30-34 BELUM KAWIN(LK)',
                                    '30-34 BELUM KAWIN(PR)',
                                    '30-34 KAWIN(LK)',
                                    '30-34 KAWIN(PR)',
                                    '30-34 CERAI HIDUP(LK)',
                                    '30-34 CERAI HIDUP(PR)',
                                    '30-34 CERAI MATI(LK)',
                                    '30-34 CERAI MATI(PR)',
                                    '35-39 BELUM KAWIN(LK)',
                                    '35-39 BELUM KAWIN(PR)',
                                    '35-39 KAWIN(LK)',
                                    '35-39 KAWIN(PR)',
                                    '35-39 CERAI HIDUP(LK)',
                                    '35-39 CERAI HIDUP(PR)',
                                    '35-39 CERAI MATI(LK)',
                                    '35-39 CERAI MATI(PR)',
                                    '40-44 BELUM KAWIN(LK)',
                                    '40-44 BELUM KAWIN(PR)',
                                    '40-44 KAWIN(LK)',
                                    '40-44 KAWIN(PR)',
                                    '40-44 CERAI HIDUP(LK)',
                                    '40-44 CERAI HIDUP(PR)',
                                    '40-44 CERAI MATI(LK)',
                                    '40-44 CERAI MATI(PR)',
                                    '45-49 BELUM KAWIN(LK)',
                                    '45-49 BELUM KAWIN(PR)',
                                    '45-49 KAWIN(LK)',
                                    '45-49 KAWIN(PR)',
                                    '45-49 CERAI HIDUP(LK)',
                                    '45-49 CERAI HIDUP(PR)',
                                    '45-49 CERAI MATI(LK)',
                                    '45-49 CERAI MATI(PR)',
                                    '50-54 BELUM KAWIN(LK)',
                                    '50-54 BELUM KAWIN(PR)',
                                    '50-54 KAWIN(LK)',
                                    '50-54 KAWIN(PR)',
                                    '50-54 CERAI HIDUP(LK)',
                                    '50-54 CERAI HIDUP(PR)',
                                    '50-54 CERAI MATI(LK)',
                                    '50-54 CERAI MATI(PR)',
                                    '55-59 BELUM KAWIN(LK)',
                                    '55-59 BELUM KAWIN(PR)',
                                    '55-59 KAWIN(LK)',
                                    '55-59 KAWIN(PR)',
                                    '55-59 CERAI HIDUP(LK)',
                                    '55-59 CERAI HIDUP(PR)',
                                    '55-59 CERAI MATI(LK)',
                                    '55-59 CERAI MATI(PR)',
                                    '60-64 BELUM KAWIN(LK)',
                                    '60-64 BELUM KAWIN(PR)',
                                    '60-64 KAWIN(LK)',
                                    '60-64 KAWIN(PR)',
                                    '60-64 CERAI HIDUP(LK)',
                                    '60-64 CERAI HIDUP(PR)',
                                    '60-64 CERAI MATI(LK)',
                                    '60-64 CERAI MATI(PR)',
                                    '65-69 BELUM KAWIN(LK)',
                                    '65-69 BELUM KAWIN(PR)',
                                    '65-69 KAWIN(LK)',
                                    '65-69 KAWIN(PR)',
                                    '65-69 CERAI HIDUP(LK)',
                                    '65-69 CERAI HIDUP(PR)',
                                    '65-69 CERAI MATI(LK)',
                                    '65-69 CERAI MATI(PR)',
                                    '70-74 BELUM KAWIN(LK)',
                                    '70-74 BELUM KAWIN(PR)',
                                    '70-74 KAWIN(LK)',
                                    '70-74 KAWIN(PR)',
                                    '70-74 CERAI HIDUP(LK)',
                                    '70-74 CERAI HIDUP(PR)',
                                    '70-74 CERAI MATI(LK)',
                                    '70-74 CERAI MATI(PR)',
                                    '>75 BELUM KAWIN(LK)',
                                    '>75 BELUM KAWIN(PR)',
                                    '>75 KAWIN(LK)',
                                    '>75 KAWIN(PR)',
                                    '>75 CERAI HIDUP(LK)',
                                    '>75 CERAI HIDUP(PR)',
                                    '>75 CERAI MATI(LK)',
                                    '>75 CERAI MATI(PR)',
                                ];
                            @endphp
                            <table id="table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        @foreach ($maritalStatus as $item)
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
