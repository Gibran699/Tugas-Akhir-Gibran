@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepemilikan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Akta Cerai Agama</a></li>
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
                        <h4 class="card-title">Kepemilikan - Akta Cerai Agama <span id="tahunSemester">I
                                2025</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $data = [
                                    'ISLAM_MEMILIKI_LK',
                                    'ISLAM_MEMILIKI_PR',
                                    'ISLAM_MEMILIKI_JML',
                                    'ISLAM_BLM_MEMILIKI_JML',

                                    'KRISTEN_MEMILIKI_LK',
                                    'KRISTEN_MEMILIKI_PR',
                                    'KRISTEN_MEMILIKI_JML',
                                    'KRISTEN_BLM_MEMILIKI_JML',

                                    'KATHOLIK_MEMILIKI_LK',
                                    'KATHOLIK_MEMILIKI_PR',
                                    'KATHOLIK_MEMILIKI_JML',
                                    'KATHOLIK_BLM_MEMILIKI_JML',

                                    'HINDU_MEMILIKI_LK',
                                    'HINDU_MEMILIKI_PR',
                                    'HINDU_MEMILIKI_JML',
                                    'HINDU_BLM_MEMILIKI_JML',

                                    'BUDHA_MEMILIKI_LK',
                                    'BUDHA_MEMILIKI_PR',
                                    'BUDHA_MEMILIKI_JML',
                                    'BUDHA_BLM_MEMILIKI_JML',

                                    'KHONGHUCU_MEMILIKI_LK',
                                    'KHONGHUCU_MEMILIKI_PR',
                                    'KHONGHUCU_MEMILIKI_JML',
                                    'KHONGHUCU_BLM_MEMILIKI_JML',

                                    'KEPERCAYAAN_MEMILIKI_LK',
                                    'KEPERCAYAAN_MEMILIKI_PR',
                                    'KEPERCAYAAN_MEMILIKI_JML',
                                    'KEPERCAYAAN_BLM_MEMILIKI_JML',
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
