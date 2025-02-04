@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kepala Keluarga</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pendidikan</a></li>
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
                        <h4 class="card-title">Kepala Keluarga - Pendidikan<span id="tahunSemester">I 2025</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $educationalStatuses = [
                                    'TIDAK/BLM SEKOLAH L',
                                    'TIDAK/BLM SEKOLAH P',
                                    'TIDAK/BLM SEKOLAH JML',
                                    'BELUM TAMAT SD/SEDERAJAT L',
                                    'BELUM TAMAT SD/SEDERAJAT P',
                                    'BELUM TAMAT SD/SEDERAJAT JML',
                                    'TAMAT SD/SEDERAJAT L',
                                    'TAMAT SD/SEDERAJAT P',
                                    'TAMAT SD/SEDERAJAT JML',
                                    'SLTP/SEDERAJAT L',
                                    'SLTP/SEDERAJAT P',
                                    'SLTP/SEDERAJAT JML',
                                    'SLTA/SEDERAJAT L',
                                    'SLTA/SEDERAJAT P',
                                    'SLTA/SEDERAJAT JML',
                                    'DIPLOMA I/II L',
                                    'DIPLOMA I/II P',
                                    'DIPLOMA I/II JML',
                                    'AKADEMI/DIPL.III/S. MUDA L',
                                    'AKADEMI/DIPL.III/S.MUDA P',
                                    'AKADEMI/DIPL.III/S.MUDA JML',
                                    'DIPLOMA IV/STRATA I L',
                                    'DIPLOMA IV/STRATA I P',
                                    'DIPLOMA IV/STRATA I JML',
                                    'STRATA-II L',
                                    'STRATA-II P',
                                    'STRATA-II JML',
                                    'STRATA-III L',
                                    'STRATA-III P',
                                    'STRATA-III JML',
                                ];
                            @endphp
                            <table id="table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        @foreach ($educationalStatuses as $item)
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
