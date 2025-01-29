{{-- pelayanan --}}
<div class="modal fade pelayanan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Pelayanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header border-0 pb-0"
                                style="display: flex; justify-content: center; align-items: center;">
                                <h5 class="card-title">Pelayanan Online</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Data pengajuan secata online dari semua kategori pelayanan
                                </p>
                            </div>
                            <div class="card-footer border-0 pt-0"
                                style="border-top: 1px solid #848789; display: flex; justify-content: center; align-items: center;">
                                <a href="javascript:void(0);" class="btn btn-success text-center">
                                    <i class="fa fa-folder-open"></i> Open
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header border-0 pb-0"
                                style="display: flex; justify-content: center; align-items: center;">
                                <h5 class="card-title">Pelayanan PDAK</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-just">Data pelayanan bersumber dari PDAK untuk semua kategori
                                    pelayanan
                                </p>
                            </div>
                            <div class="card-footer border-0 pt-0"
                                style="border-top: 1px solid #848789; display: flex; justify-content: center; align-items: center;">
                                <a href="javascript:void(0);" class="btn btn-success text-center">
                                    <i class="fa fa-folder-open"></i> Open
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- agregat dkb --}}
<div class="modal fade agregat-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data DKB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Column starts -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-primary" id="accordion-one">
                                        <div class="accordion-item">
                                            <div class="accordion-header  rounded-lg" id="headingOne"
                                                data-bs-toggle="collapse" data-bs-target="#dataPenduduk"
                                                aria-controls="collapseOne" aria-expanded="true" role="button">
                                                <span class="accordion-header-icon"></span>
                                                <span class="accordion-header-text">Agregat Penduduk</span>
                                                <span class="accordion-header-indicator"></span>
                                            </div>
                                            <div id="dataPenduduk" class="collapse show" aria-labelledby="headingOne"
                                                data-bs-parent="#accordion-one">
                                                <div class="basic-list-group">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">Agama</li>
                                                        <li class="list-group-item">Disabilitas</li>
                                                        <li class="list-group-item">Golongan Darah</li>
                                                        <li class="list-group-item">Hubungan Keluarga</li>
                                                        <li class="list-group-item">Jenis Kelamin</li>
                                                        <li class="list-group-item">Pendidikan</li>
                                                        <li class="list-group-item">Perkawinan</li>
                                                        <li class="list-group-item">RT</li>
                                                        <li class="list-group-item">Wajib KTP</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-primary" id="accordion-one">
                                        <div class="accordion-item">
                                            <div class="accordion-header  rounded-lg" id="headingOne"
                                                data-bs-toggle="collapse" data-bs-target="#dataKepalaKeluarga"
                                                aria-controls="collapseOne" aria-expanded="true" role="button">
                                                <span class="accordion-header-icon"></span>
                                                <span class="accordion-header-text">Agregat KepalaKeluarga</span>
                                                <span class="accordion-header-indicator"></span>
                                            </div>
                                            <div id="dataKepalaKeluarga" class="collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordion-one">
                                                <div class="basic-list-group">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">Agama</li>
                                                        <li class="list-group-item">Disabilitas</li>
                                                        <li class="list-group-item">Golongan Darah</li>
                                                        <li class="list-group-item">Jenis Kelamin</li>
                                                        <li class="list-group-item">Pendidikan</li>
                                                        <li class="list-group-item">Perkawinan</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Kepemilikan  --}}
<div class="modal fade kepemilikan-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Kepemilikan Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Akta Kelahiran</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Akta Perkawinan</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Akta Perceraian</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">KIA</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Kartu Keluarga</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">KTP</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- struktur umur --}}
<div class="modal fade umur-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Umur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Agama</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Disabilitas</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Golongan Darah</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Kepala Keluarga</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Penduduk</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-folder-15"></i>
                                    </span>
                                    <div class="media-body text-white text-right">
                                        <p class="mb-1">Status Kawin</p>
                                        {{-- <h3 class="text-white">$76</h3> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
