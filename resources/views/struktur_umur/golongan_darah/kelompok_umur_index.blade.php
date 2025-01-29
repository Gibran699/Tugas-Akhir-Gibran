@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Golongan Darah</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kelompok Umur</a></li>
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
                        <h4 class="card-title">Golongan Darah - Kelompok Umur <span id="tahunSemester">I 2025</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $bloodTypes = [
                                    'A (LK)',
                                    'A (PR)',
                                    'A (JML)',
                                    'A- (LK)',
                                    'A- (PR)',
                                    'A- (JML)',
                                    'A+ (LK)',
                                    'A+ (PR)',
                                    'A+ (JML)',
                                    'B (LK)',
                                    'B (PR)',
                                    'B (JML)',
                                    'B- (LK)',
                                    'B- (PR)',
                                    'B- (JML)',
                                    'B+ (LK)',
                                    'B+ (PR)',
                                    'B+ (JML)',
                                    'AB (LK)',
                                    'AB (PR)',
                                    'AB (JML)',
                                    'AB- (LK)',
                                    'AB- (PR)',
                                    'AB- (JML)',
                                    'AB+ (LK)',
                                    'AB+ (PR)',
                                    'AB+ (JML)',
                                    'O (LK)',
                                    'O (PR)',
                                    'O (JML)',
                                    'O- (LK)',
                                    'O- (PR)',
                                    'O- (JML)',
                                    'O+ (LK)',
                                    'O+ (PR)',
                                    'O+ (JML)',
                                    'TIDAK TAHU (LK)',
                                    'TIDAK TAHU (PR)',
                                    'TIDAK TAHU (JML)',
                                ];
                            @endphp
                            <table id="table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Kelompok Umur</th>
                                        @foreach ($bloodTypes as $item)
                                            <th>{{$item}}</th>
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
