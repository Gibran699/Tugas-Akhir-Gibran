@extends('layout.master')
@section('content')
    @php
        $occupations = [
            'BELUM/TIDAK BEKERJA_L',
            'BELUM/TIDAK BEKERJA_P',
            'MENGURUS RUMAH TANGGA_L',
            'MENGURUS RUMAH TANGGA_P',
            'PELAJAR/MAHASISWA_L',
            'PELAJAR/MAHASISWA_P',
            'PENSIUNAN_L',
            'PENSIUNAN_P',
            'PEGAWAI NEGERI SIPIL (PNS)_L',
            'PEGAWAI NEGERI SIPIL (PNS)_P',
            'TENTARA NASIONAL INDONESIA (TNI)_L',
            'TENTARA NASIONAL INDONESIA (TNI)_P',
            'KEPOLISIAN RI (POLRI)_L',
            'KEPOLISIAN RI (POLRI)_P',
            'PERDAGANGAN_L',
            'PERDAGANGAN_P',
            'PETANI/PEKEBUN_L',
            'PETANI/PEKEBUN_P',
            'PETERNAK_L',
            'PETERNAK_P',
            'NELAYAN/PERIKANAN_L',
            'NELAYAN/PERIKANAN_P',
            'INDUSTRI_L',
            'INDUSTRI_P',
            'KONSTRUKSI_L',
            'KONSTRUKSI_P',
            'TRANSPORTASI_L',
            'TRANSPORTASI_P',
            'KARYAWAN SWASTA_L',
            'KARYAWAN SWASTA_P',
            'KARYAWAN BUMN_L',
            'KARYAWAN BUMN_P',
            'KARYAWAN BUMD_L',
            'KARYAWAN BUMD_P',
            'KARYAWAN HONORER_L',
            'KARYAWAN HONORER_P',
            'BURUH HARIAN LEPAS_L',
            'BURUH HARIAN LEPAS_P',
            'BURUH TANI/PERKEBUNAN_L',
            'BURUH TANI/PERKEBUNAN_P',
            'BURUH NELAYAN/PERIKANAN_L',
            'BURUH NELAYAN/PERIKANAN_P',
            'BURUH PETERNAKAN_L',
            'BURUH PETERNAKAN_P',
            'PEMBANTU RUMAH TANGGA_L',
            'PEMBANTU RUMAH TANGGA_P',
            'TUKANG CUKUR_L',
            'TUKANG CUKUR_P',
            'TUKANG LISTRIK_L',
            'TUKANG LISTRIK_P',
            'TUKANG BATU_L',
            'TUKANG BATU_P',
            'TUKANG KAYU_L',
            'TUKANG KAYU_P',
            'TUKANG SOL SEPATU_L',
            'TUKANG SOL SEPATU_P',
            'TUKANG LAS/PANDAI BESI_L',
            'TUKANG LAS/PANDAI BESI_P',
            'TUKANG JAHIT_L',
            'TUKANG JAHIT_P',
            'TUKANG GIGI_L',
            'TUKANG GIGI_P',
            'PENATA RIAS_L',
            'PENATA RIAS_P',
            'PENATA BUSANA_L',
            'PENATA BUSANA_P',
            'PENATA RAMBUT_L',
            'PENATA RAMBUT_P',
            'MEKANIK_L',
            'MEKANIK_P',
            'SENIMAN_L',
            'SENIMAN_P',
            'TABIB_L',
            'TABIB_P',
            'PARAJI_L',
            'PARAJI_P',
            'PERANCANG BUSANA_L',
            'PERANCANG BUSANA_P',
            'PENTERJEMAH_L',
            'PENTERJEMAH_P',
            'IMAM MASJID_L',
            'IMAM MASJID_P',
            'PENDETA_L',
            'PENDETA_P',
            'PASTOR_L',
            'PASTOR_P',
            'WARTAWAN_L',
            'WARTAWAN_P',
            'USTADZ/MUBALIGH_L',
            'USTADZ/MUBALIGH_P',
            'JURU MASAK_L',
            'JURU MASAK_P',
            'PROMOTOR ACARA_L',
            'PROMOTOR ACARA_P',
            'ANGGOTA DPR RI_L',
            'ANGGOTA DPR RI_P',
            'ANGGOTA DPD RI_L',
            'ANGGOTA DPD RI_P',
            'ANGGOTA BPK_L',
            'ANGGOTA BPK_P',
            'PRESIDEN_L',
            'PRESIDEN_P',
            'WAKIL PRESIDEN_L',
            'WAKIL PRESIDEN_P',
            'ANGGOTA MAHKAMAH KONSTITUSI_L',
            'ANGGOTA MAHKAMAH KONSTITUSI_P',
            'ANGGOTA KABINET KEMENTRIAN_L',
            'ANGGOTA KABINET KEMENTRIAN_P',
            'DUTA BESAR_L',
            'DUTA BESAR_P',
            'GUBERNUR_L',
            'GUBERNUR_P',
            'WAKIL GUBERNUR_L',
            'WAKIL GUBERNUR_P',
            'BUPATI_L',
            'BUPATI_P',
            'WAKIL BUPATI_L',
            'WAKIL BUPATI_P',
            'WALIKOTA_L',
            'WALIKOTA_P',
            'WAKIL WALIKOTA_L',
            'WAKIL WALIKOTA_P',
            'ANGGOTA DPRD PROP._L',
            'ANGGOTA DPRD PROP._P',
            'ANGGOTA DPRD KAB./KOTA_L',
            'ANGGOTA DPRD KAB./KOTA_P',
            'DOSEN_L',
            'DOSEN_P',
            'GURU_L',
            'GURU_P',
            'PILOT_L',
            'PILOT_P',
            'PENGACARA_L',
            'PENGACARA_P',
            'NOTARIS_L',
            'NOTARIS_P',
            'ARSITEK_L',
            'ARSITEK_P',
            'AKUNTAN_L',
            'AKUNTAN_P',
            'KONSULTAN_L',
            'KONSULTAN_P',
            'DOKTER_L',
            'DOKTER_P',
            'BIDAN_L',
            'BIDAN_P',
            'PERAWAT_L',
            'PERAWAT_P',
            'APOTEKER_L',
            'APOTEKER_P',
            'PSIKIATER/PSIKOLOG_L',
            'PSIKIATER/PSIKOLOG_P',
            'PENYIAR TELEVISI_L',
            'PENYIAR TELEVISI_P',
            'PENYIAR RADIO_L',
            'PENYIAR RADIO_P',
            'PELAUT_L',
            'PELAUT_P',
            'PENELITI_L',
            'PENELITI_P',
            'SOPIR_L',
            'SOPIR_P',
            'PIALANG_L',
            'PIALANG_P',
            'PARANORMAL_L',
            'PARANORMAL_P',
            'PEDAGANG_L',
            'PEDAGANG_P',
            'PERANGKAT DESA_L',
            'PERANGKAT DESA_P',
            'KEPALA DESA_L',
            'KEPALA DESA_P',
            'BIARAWAN/BIARAWATI_L',
            'BIARAWAN/BIARAWATI_P',
            'WIRASWASTA_L',
            'WIRASWASTA_P',
            'ANGGOTA LEMBAGA TINGGI LAINNYA_L',
            'ANGGOTA LEMBAGA TINGGI LAINNYA_P',
            'ARTIS_L',
            'ARTIS_P',
            'ATLIT_L',
            'ATLIT_P',
            'CHEFF_L',
            'CHEFF_P',
            'MANAJER_L',
            'MANAJER_P',
            'TENAGA TATA USAHA_L',
            'TENAGA TATA USAHA_P',
            'OPERATOR_L',
            'OPERATOR_P',
            'PEKERJA PENGOLAHAN KERAJINAN_L',
            'PEKERJA PENGOLAHAN KERAJINAN_P',
            'TEKNISI_L',
            'TEKNISI_P',
            'ASISTEN AHLI_L',
            'ASISTEN AHLI_P',
            'PEKERJAAN LAINNYA_L',
            'PEKERJAAN LAINNYA_P',
        ];
    @endphp
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kepala Keluarga - Perkerjaan</a></li>
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
                            'id' => 'formSearchKepalaKeluargaPekerjaan',
                            'method' => 'post',
                            'route' => ['search_data', 'aQIpF1uiEO'],
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="tahunSemester"></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableSum" class="display table table-striped table-responsive"
                                style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Pekerjaan</th>
                                        <th>Laki -Laki</th>
                                        <th>Perempuan</th>
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
                                        @foreach ($occupations as $item)
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
                                        @foreach ($occupations as $item)
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
    <script src="{{ asset('js/index/agregat_dkb/kepala_keluarga/pekerjaan.js') }}"></script>
@endsection
