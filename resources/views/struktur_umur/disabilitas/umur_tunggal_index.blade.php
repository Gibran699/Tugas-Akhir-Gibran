@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Disabilitas</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Umur Tunggal</a></li>
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
                                <div class="col-md-4 mb-3">
                                    <select name="semester" id="semester" class="form-control default-select">
                                        <option value="" disabled selected>--PILIH Semester--</option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select name="tahun" id="tahun" class="form-control default-select">
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select name="umur" id="umur">
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
                        <h4 class="card-title">Disabilitas - Umur Tunggal <span id="tahunSemester">I 2025</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Umur</th>
                                        <th>disabilitas Fisik LK</th>
                                        <th>disabilitas Fisik PR</th>
                                        <th>disabilitas Fisik JML</th>
                                        <th>disabilitas Netra / Buta LK</th>
                                        <th>disabilitas Netra / Buta PR</th>
                                        <th>disabilitas Netra / Buta JML</th>
                                        <th>disabilitas Rungu / Wicara LK</th>
                                        <th>disabilitas Rungu / Wicara PR</th>
                                        <th>disabilitas Rungu / Wicara JML</th>
                                        <th>disabilitas Mental / Jiwa LK</th>
                                        <th>disabilitas Mental / Jiwa PR</th>
                                        <th>disabilitas Mental / Jiwa JML</th>
                                        <th>disabilitas Fisik & Mental LK</th>
                                        <th>disabilitas Fisik & Mental PR</th>
                                        <th>disabilitas Fisik & Mental JML</th>
                                        <th>disabilitas Lainya LK</th>
                                        <th>disabilitas Lainya PR</th>
                                        <th>disabilitas Lainya JML</th>
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
    <script>
        $("#umur").select2();
        selectAge()
    </script>
@endsection
