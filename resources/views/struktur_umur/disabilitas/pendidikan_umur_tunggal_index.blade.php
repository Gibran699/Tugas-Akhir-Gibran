@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Disabilitas</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pendidikan Umur Tunggal</a></li>
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
                        <h4 class="card-title">Disabilitas - Pendidikan Umur Tunggal<span id="tahunSemester">I 2025</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $disabilities = [
                                    'FISIK TIDAK/BLM SEKOLAH_L',
                                    'FISIK TIDAK/BLM SEKOLAH_P',
                                    'FISIK TIDAK/BLM SEKOLAH',
                                    'FISIK BELUM TAMAT SD/SEDERAJAT_L',
                                    'FISIK BELUM TAMAT SD/SEDERAJAT_P',
                                    'FISIK BELUM TAMAT SD/SEDERAJAT',
                                    'FISIK TAMAT SD/SEDERAJAT_L',
                                    'FISIK TAMAT SD/SEDERAJAT_P',
                                    'FISIK TAMAT SD/SEDERAJAT',
                                    'FISIK SLTP/SEDERAJAT_L',
                                    'FISIK SLTP/SEDERAJAT_P',
                                    'FISIK SLTP/SEDERAJAT',
                                    'FISIK SLTA/SEDERAJAT_L',
                                    'FISIK SLTA/SEDERAJAT_P',
                                    'FISIK SLTA/SEDERAJAT',
                                    'FISIK DIPLOMA I/II_L',
                                    'FISIK DIPLOMA I/II_P',
                                    'FISIK DIPLOMA I/II',
                                    'FISIK AKADEMI/DIPLOMA III/S. MUDA_L',
                                    'FISIK AKADEMI/DIPLOMA III/S. MUDA_P',
                                    'FISIK AKADEMI/DIPLOMA III/S. MUDA',
                                    'FISIK DIPLOMA IV/STRATA I_L',
                                    'FISIK DIPLOMA IV/STRATA I_P',
                                    'FISIK DIPLOMA IV/STRATA I',
                                    'FISIK STRATA-II_L',
                                    'FISIK STRATA-II_P',
                                    'FISIK STRATA-II',
                                    'FISIK STRATA-III_L',
                                    'FISIK STRATA-III_P',
                                    'FISIK STRATA-III',
                                    'NETRA/BUTA TIDAK/BLM SEKOLAH_L',
                                    'NETRA/BUTA TIDAK/BLM SEKOLAH_P',
                                    'NETRA/BUTA TIDAK/BLM SEKOLAH',
                                    'NETRA/BUTA BELUM TAMAT SD/SEDERAJAT_L',
                                    'NETRA/BUTA BELUM TAMAT SD/SEDERAJAT_P',
                                    'NETRA/BUTA BELUM TAMAT SD/SEDERAJAT',
                                    'NETRA/BUTA TAMAT SD/SEDERAJAT_L',
                                    'NETRA/BUTA TAMAT SD/SEDERAJAT_P',
                                    'NETRA/BUTA TAMAT SD/SEDERAJAT',
                                    'NETRA/BUTA SLTP/SEDERAJAT_L',
                                    'NETRA/BUTA SLTP/SEDERAJAT_P',
                                    'NETRA/BUTA SLTP/SEDERAJAT',
                                    'NETRA/BUTA SLTA/SEDERAJAT_L',
                                    'NETRA/BUTA SLTA/SEDERAJAT_P',
                                    'NETRA/BUTA SLTA/SEDERAJAT',
                                    'NETRA/BUTA DIPLOMA I/II_L',
                                    'NETRA/BUTA DIPLOMA I/II_P',
                                    'NETRA/BUTA DIPLOMA I/II',
                                    'NETRA/BUTA AKADEMI/DIPLOMA III/S. MUDA_L',
                                    'NETRA/BUTA AKADEMI/DIPLOMA III/S. MUDA_P',
                                    'NETRA/BUTA AKADEMI/DIPLOMA III/S. MUDA',
                                    'NETRA/BUTA DIPLOMA IV/STRATA I_L',
                                    'NETRA/BUTA DIPLOMA IV/STRATA I_P',
                                    'NETRA/BUTA DIPLOMA IV/STRATA I',
                                    'NETRA/BUTA STRATA-II_L',
                                    'NETRA/BUTA STRATA-II_P',
                                    'NETRA/BUTA STRATA-II',
                                    'NETRA/BUTA STRATA-III_L',
                                    'NETRA/BUTA STRATA-III_P',
                                    'NETRA/BUTA STRATA-III',
                                    'RUNGU/WICARA TIDAK/BLM SEKOLAH_L',
                                    'RUNGU/WICARA TIDAK/BLM SEKOLAH_P',
                                    'RUNGU/WICARA TIDAK/BLM SEKOLAH',
                                    'RUNGU/WICARA BELUM TAMAT SD/SEDERAJAT_L',
                                    'RUNGU/WICARA BELUM TAMAT SD/SEDERAJAT_P',
                                    'RUNGU/WICARA BELUM TAMAT SD/SEDERAJAT',
                                    'RUNGU/WICARA TAMAT SD/SEDERAJAT_L',
                                    'RUNGU/WICARA TAMAT SD/SEDERAJAT_P',
                                    'RUNGU/WICARA TAMAT SD/SEDERAJAT',
                                    'RUNGU/WICARA SLTP/SEDERAJAT_L',
                                    'RUNGU/WICARA SLTP/SEDERAJAT_P',
                                    'RUNGU/WICARA SLTP/SEDERAJAT',
                                    'RUNGU/WICARA SLTA/SEDERAJAT_L',
                                    'RUNGU/WICARA SLTA/SEDERAJAT_P',
                                    'RUNGU/WICARA SLTA/SEDERAJAT',
                                    'RUNGU/WICARA DIPLOMA I/II_L',
                                    'RUNGU/WICARA DIPLOMA I/II_P',
                                    'RUNGU/WICARA DIPLOMA I/II',
                                    'RUNGU/WICARA AKADEMI/DIPLOMA III/S. MUDA_L',
                                    'RUNGU/WICARA AKADEMI/DIPLOMA III/S. MUDA_P',
                                    'RUNGU/WICARA AKADEMI/DIPLOMA III/S. MUDA',
                                    'RUNGU/WICARA DIPLOMA IV/STRATA I_L',
                                    'RUNGU/WICARA DIPLOMA IV/STRATA I_P',
                                    'RUNGU/WICARA DIPLOMA IV/STRATA I',
                                    'RUNGU/WICARA STRATA-II_L',
                                    'RUNGU/WICARA STRATA-II_P',
                                    'RUNGU/WICARA STRATA-II',
                                    'RUNGU/WICARA STRATA-III_L',
                                    'RUNGU/WICARA STRATA-III_P',
                                    'RUNGU/WICARA STRATA-III',
                                    'MENTAL/JIWA TIDAK/BLM SEKOLAH_L',
                                    'MENTAL/JIWA TIDAK/BLM SEKOLAH_P',
                                    'MENTAL/JIWA TIDAK/BLM SEKOLAH',
                                    'MENTAL/JIWA BELUM TAMAT SD/SEDERAJAT_L',
                                    'MENTAL/JIWA BELUM TAMAT SD/SEDERAJAT_P',
                                    'MENTAL/JIWA BELUM TAMAT SD/SEDERAJAT',
                                    'MENTAL/JIWA TAMAT SD/SEDERAJAT_L',
                                    'MENTAL/JIWA TAMAT SD/SEDERAJAT_P',
                                    'MENTAL/JIWA TAMAT SD/SEDERAJAT',
                                    'MENTAL/JIWA SLTP/SEDERAJAT_L',
                                    'MENTAL/JIWA SLTP/SEDERAJAT_P',
                                    'MENTAL/JIWA SLTP/SEDERAJAT',
                                    'MENTAL/JIWA SLTA/SEDERAJAT_L',
                                    'MENTAL/JIWA SLTA/SEDERAJAT_P',
                                    'MENTAL/JIWA SLTA/SEDERAJAT',
                                    'MENTAL/JIWA DIPLOMA I/II_L',
                                    'MENTAL/JIWA DIPLOMA I/II_P',
                                    'MENTAL/JIWA DIPLOMA I/II',
                                    'MENTAL/JIWA AKADEMI/DIPLOMA III/S. MUDA_L',
                                    'MENTAL/JIWA AKADEMI/DIPLOMA III/S. MUDA_P',
                                    'MENTAL/JIWA AKADEMI/DIPLOMA III/S. MUDA',
                                    'MENTAL/JIWA DIPLOMA IV/STRATA I_L',
                                    'MENTAL/JIWA DIPLOMA IV/STRATA I_P',
                                    'MENTAL/JIWA DIPLOMA IV/STRATA I',
                                    'MENTAL/JIWA STRATA-II_L',
                                    'MENTAL/JIWA STRATA-II_P',
                                    'MENTAL/JIWA STRATA-II',
                                    'MENTAL/JIWA STRATA-III_L',
                                    'MENTAL/JIWA STRATA-III_P',
                                    'MENTAL/JIWA STRATA-III',
                                    "FISIK '&' MENTAL T IDAK/BLM SEKOLAH_L",
                                    "FISIK '&' MENTAL TIDAK/BLM SEKOLAH_P",
                                    "FISIK '&' MENTAL TIDAK/BLM SEKOLAH",
                                    "FISIK '&' MENTAL BELUM TAMAT SD/SEDERAJAT_L",
                                    "FISIK '&' MENTAL BELUM TAMAT SD/SEDERAJAT_P",
                                    "FISIK '&' MENTAL BELUM TAMAT SD/SEDERAJAT",
                                    "FISIK '&' MENTAL TAMAT SD/SEDERAJAT_L",
                                    "FISIK '&' MENTAL TAMAT SD/SEDERAJAT_P",
                                    "FISIK '&' MENTAL TAMAT SD/SEDERAJAT",
                                    "FISIK '&' MENTAL SLTP/SEDERAJAT_L",
                                    "FISIK '&' MENTAL SLTP/SEDERAJAT_P",
                                    "FISIK '&' MENTAL SLTP/SEDERAJAT",
                                    "FISIK '&' MENTAL SLTA/SEDERAJAT_L",
                                    "FISIK '&' MENTAL SLTA/SEDERAJAT_P",
                                    "FISIK '&' MENTAL SLTA/SEDERAJAT",
                                    "FISIK '&' MENTAL DIPLOMA I/II_L",
                                    "FISIK '&' MENTAL DIPLOMA I/II_P",
                                    "FISIK '&' MENTAL DIPLOMA I/II",
                                    "FISIK '&' MENTAL AKADEMI/DIPLOMA III/S. MUDA_L",
                                    "FISIK '&' MENTAL AKADEMI/DIPLOMA III/S. MUDA_P",
                                    "FISIK '&' MENTAL AKADEMI/DIPLOMA III/S. MUDA",
                                    "FISIK '&' MENTAL DIPLOMA IV/STRATA I_L",
                                    "FISIK '&' MENTAL DIPLOMA IV/STRATA I_P",
                                    "FISIK '&' MENTAL DIPLOMA IV/STRATA I",
                                    "FISIK '&' MENTAL STRATA-II_L",
                                    "FISIK '&' MENTAL STRATA-II_P",
                                    "FISIK '&' MENTAL STRATA-II",
                                    "FISIK '&' MENTAL STRATA-III_L",
                                    "FISIK '&' MENTAL STRATA-III_P",
                                    "FISIK '&' MENTAL STRATA-III",
                                    'LAINNYA TIDAK/BLM SEKOLAH_L',
                                    'LAINNYA TIDAK/BLM SEKOLAH_P',
                                    'LAINNYA TIDAK/BLM SEKOLAH',
                                    'LAINNYA BELUM TAMAT SD/SEDERAJAT_L',
                                    'LAINNYA BELUM TAMAT SD/SEDERAJAT_P',
                                    'LAINNYA BELUM TAMAT SD/SEDERAJAT',
                                    'LAINNYA TAMAT SD/SEDERAJAT_L',
                                    'LAINNYA TAMAT SD/SEDERAJAT_P',
                                    'LAINNYA TAMAT SD/SEDERAJAT',
                                    'LAINNYA SLTP/SEDERAJAT_L',
                                    'LAINNYA SLTP/SEDERAJAT_P',
                                    'LAINNYA SLTP/SEDERAJAT',
                                    'LAINNYA SLTA/SEDERAJAT_L',
                                    'LAINNYA SLTA/SEDERAJAT_P',
                                    'LAINNYA SLTA/SEDERAJAT',
                                    'LAINNYA DIPLOMA I/II_L',
                                    'LAINNYA DIPLOMA I/II_P',
                                    'LAINNYA DIPLOMA I/II',
                                    'LAINNYA AKADEMI/DIPLOMA III/S. MUDA_L',
                                    'LAINNYA AKADEMI/DIPLOMA III/S. MUDA_P',
                                    'LAINNYA AKADEMI/DIPLOMA III/S. MUDA',
                                    'LAINNYA DIPLOMA IV/STRATA I_L',
                                    'LAINNYA DIPLOMA IV/STRATA I_P',
                                    'LAINNYA DIPLOMA IV/STRATA I',
                                    'LAINNYA STRATA-II_L',
                                    'LAINNYA STRATA-II_P',
                                    'LAINNYA STRATA-II',
                                    'LAINNYA STRATA-III_L',
                                    'LAINNYA STRATA-III_P',
                                    'LAINNYA STRATA-III',
                                ];
                            @endphp
                            <table id="table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Umur</th>
                                        @foreach ($disabilities as $item)
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
    <script>
        $("#umur").select2();
        selectAge()
    </script>
@endsection
