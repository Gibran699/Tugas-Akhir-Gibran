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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data DKB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="basic-list-group">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-2">
                                        <div class="list-group mb-4 " id="list-tab" role="tablist">
                                            <a class="list-group-item list-group-item-action active" id="list-home-list"
                                                data-bs-toggle="list" href="#list-penduduk" role="tab">Penduduk</a>
                                            <a class="list-group-item list-group-item-action" id="list-profile-list"
                                                data-bs-toggle="list" href="#list-kartu-keluarga" role="tab">Kepala
                                                Keluarga</a>
                                            <a class="list-group-item list-group-item-action" id="list-messages-list"
                                                data-bs-toggle="list" href="#list-status-kawin" role="tab">Status Kawin</a>
                                            <a class="list-group-item list-group-item-action" id="list-settings-list"
                                                data-bs-toggle="list" href="#list-pendidikan" role="tab">Pendidikan</a>
                                            <a class="list-group-item list-group-item-action" id="list-settings-list"
                                                data-bs-toggle="list" href="#list-disabilitas" role="tab">Disabilitas</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-10">
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="list-penduduk">
                                                <h4 class="mb-4">Penduduk</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Agama<span class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Gol.Darah<span class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Jenis Kelamin<span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pekerjaan<span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Hub.Keluarga <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-kartu-keluarga" role="tabpanel">
                                                <h4 class="mb-4">Kepala Keluarga</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Agama<span class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Jenis Kelamin <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pendidikan <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pekerjaan <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Status Kawin <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-status-kawin">
                                                <h4 class="mb-4">Status Kawin</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Agama<span class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Jenis Kelamin <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pekerjaan <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-pendidikan">
                                                <h4 class="mb-4">Pendidikan</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Jenis Kelamin <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pekerjaan <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Gol. Darah<span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-disabilitas">
                                                <h4 class="mb-4">Disabilitas</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Jenis Kelamin <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pekerjaan <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button"
                                                            class="btn btn-lg btn-outline-primary mb-2"
                                                            style="width: 250px;">Pendidikan <span
                                                                class="btn-icon-end"><i
                                                                    class="fa fa-folder-open"></i></span></button>
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
                                        <p class="mb-1">Akta Perkawinan - Agama</p>
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
                                        <p class="mb-1">Akta Perceraian - Agama</p>
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
