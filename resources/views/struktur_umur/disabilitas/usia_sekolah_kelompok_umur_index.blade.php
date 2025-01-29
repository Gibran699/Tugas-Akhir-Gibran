@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Disabilitas</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Usia Sekolah Kelompok Umur</a></li>
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
                        <h4 class="card-title">Disabilitas - Usia Sekolah Kelompok Umur<span id="tahunSemester">I
                                2025</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $disabilities = [
                                    'FISIK U4-6TH (LK)',
                                    'FISIK U4-6TH (PR)',
                                    'FISIK U7-12TH (LK)',
                                    'FISIK U7-12TH (PR)',
                                    'FISIK U13-15TH (LK)',
                                    'FISIK U13-15TH (PR)',
                                    'FISIK U16-18TH (LK)',
                                    'FISIK U16-18TH (PR)',
                                    'NETRA/BUTA U4-6TH (LK)',
                                    'NETRA/BUTA U4-6TH (PR)',
                                    'NETRA/BUTA U7-12TH (LK)',
                                    'NETRA/BUTA U7-12TH (PR)',
                                    'NETRA/BUTA U13-15TH (LK)',
                                    'NETRA/BUTA U13-15TH (PR)',
                                    'NETRA/BUTA U16-18TH (LK)',
                                    'NETRA/BUTA U16-18TH (PR)',
                                    'RUNGU/WICARA U4-6TH (LK)',
                                    'RUNGU/WICARA U4-6TH (PR)',
                                    'RUNGU/WICARA U7-12TH (LK)',
                                    'RUNGU/WICARA U7-12TH (PR)',
                                    'RUNGU/WICARA U13-15TH (LK)',
                                    'RUNGU/WICARA U13-15TH (PR)',
                                    'RUNGU/WICARA U16-18TH (LK)',
                                    'RUNGU/WICARA U16-18TH (PR)',
                                    'MENTAL/JIWA U4-6TH (LK)',
                                    'MENTAL/JIWA U4-6TH (PR)',
                                    'MENTAL/JIWA U7-12TH (LK)',
                                    'MENTAL/JIWA U7-12TH (PR)',
                                    'MENTAL/JIWA U13-15TH (LK)',
                                    'MENTAL/JIWA U13-15TH (PR)',
                                    'MENTAL/JIWA U16-18TH (LK)',
                                    'MENTAL/JIWA U16-18TH (PR)',
                                    'FISIK/MENTAL U4-6TH (LK)',
                                    'FISIK/MENTAL U4-6TH (PR)',
                                    'FISIK/MENTAL U7-12TH (LK)',
                                    'FISIK/MENTAL U7-12TH (PR)',
                                    'FISIK/MENTAL U13-15TH (LK)',
                                    'FISIK/MENTAL U13-15TH (PR)',
                                    'FISIK/MENTAL U16-18TH (LK)',
                                    'FISIK/MENTAL U16-18TH (PR)',
                                    'LAINNYA U4-6TH (LK)',
                                    'LAINNYA U4-6TH (PR)',
                                    'LAINNYA U7-12TH (LK)',
                                    'LAINNYA U7-12TH (PR)',
                                    'LAINNYA U13-15TH (LK)',
                                    'LAINNYA U13-15TH (PR)',
                                    'LAINNYA U16-18TH (LK)',
                                    'LAINNYA U16-18TH (PR)',
                                ];
                            @endphp
                            <table id="table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        @foreach ($disabilities as $item)
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
