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
                                                data-bs-toggle="list" href="#list-status-kawin" role="tab">Status
                                                Kawin</a>
                                            <a class="list-group-item list-group-item-action" id="list-settings-list"
                                                data-bs-toggle="list" href="#list-pendidikan"
                                                role="tab">Pendidikan</a>
                                            <a class="list-group-item list-group-item-action" id="list-settings-list"
                                                data-bs-toggle="list" href="#list-disabilitas"
                                                role="tab">Disabilitas</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-10">
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="list-penduduk">
                                                <h4 class="mb-4">Penduduk</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'MupFCfSa6a']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Agama<span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'aPH7zF09S1']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Gol.Darah<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'CV8V59hUCF']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'fFKZKP7AnA']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pekerjaan<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'bfl4aaeCTi']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Hub.Keluarga <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-kartu-keluarga" role="tabpanel">
                                                <h4 class="mb-4">Kepala Keluarga</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'nYtZCUxdr6']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Agama<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'MNJiVyMrxR']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'gblPf8pfSp']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pendidikan <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'aQIpF1uiEO']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pekerjaan <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'ZvGL0vPJLC']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Status Kawin <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-status-kawin">
                                                <h4 class="mb-4">Status Kawin</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => '2XSDKgCQJH']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Agama<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'oqhOV9WfkB']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'AWn2KmOLao']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pekerjaan <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-pendidikan">
                                                <h4 class="mb-4">Pendidikan</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'XYPtrXHZkf']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'eRPt22HZkf']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pekerjaan <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'XYPt22HZkf']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Gol. Darah<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-disabilitas">
                                                <h4 class="mb-4">Disabilitas</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'trg1Xxialt']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'iXnbXnoUnq']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pekerjaan <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => '8sfHKi6GHS']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pendidikan <span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
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
                        <a href="{{ route('index_rumah_data', ['codeView' => '6D6A18O1Hm']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'CJY6qXue82']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'PKf3FqywDa']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'goKsHUTCOG']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'eCnoaOxtiS']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '2ovlKZBzGU']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '6DFxmctALZ']) }}">
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
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'hsdtkgPeS5']) }}">
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
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- struktur umur --}}
<div class="modal fade umur-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Umur</h5>
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
                                            <a class="list-group-item list-group-item-action active"
                                                id="list-home-list" data-bs-toggle="list"
                                                href="#list-sturuktur-umur-agama" role="tab">Agama</a>
                                            <a class="list-group-item list-group-item-action" id="list-profile-list"
                                                data-bs-toggle="list" href="#list-sturuktur-umur-disabilitas"
                                                role="tab">Disabilitas</a>
                                            <a class="list-group-item list-group-item-action" id="list-messages-list"
                                                data-bs-toggle="list" href="#list-sturuktur-umur-golongan-darah"
                                                role="tab">Golongan Darah</a>
                                            <a class="list-group-item list-group-item-action" id="list-settings-list"
                                                data-bs-toggle="list" href="#list-sturuktur-umur-kepala-keluarga"
                                                role="tab">Kepala Keluarga</a>
                                            <a class="list-group-item list-group-item-action" id="list-settings-list"
                                                data-bs-toggle="list" href="#list-struktur-umur-penduduk"
                                                role="tab">Penduduk</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-10">
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="list-sturuktur-umur-agama">
                                                <h4 class="mb-4">Agama</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'OqF8P0knI7']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Kelom. Umur<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-sturuktur-umur-disabilitas"
                                                role="tabpanel">
                                                <h4 class="mb-4">Disabilitas</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'VtDkcpu8FN']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Kelom. Umur<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'nx8eUW4TWq']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Pendidikan<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => '3WjgN9m6aS']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Umur Tunggal
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'FIZKE9hOxo']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Usia Sekolah<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-sturuktur-umur-golongan-darah"
                                                role="tabpanel">
                                                <h4 class="mb-4">Golongan Darah</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'dRgHdz0S5A']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Kelom. Umur<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'eRkbPisQHv']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Umur Tunggal
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-sturuktur-umur-kepala-keluarga"
                                                role="tabpanel">
                                                <h4 class="mb-4">Kepala Keluarga</h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'svFaBJRBLQ']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Kelom. Umur<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'lo4z2cDrRC']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Umur Tunggal
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'EJpy2qXC3z']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Status Kawin
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="list-struktur-umur-penduduk"
                                                role="tabpanel">
                                                <div class="row">
                                                    <h4 class="mb-4">Penduduk - Umur Tunggal</h4>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'Byxp2PxZK2']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => '4riLDLsE6q']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Status Kawin<span
                                                                    class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <h4 class="mb-4 mt-3">Penduduk - Kelompok Umur</h4>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'gWNOWEQuYC']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Jenis Kelamin
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'RIvQj7G1XZ']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Status Kawin
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <h4 class="mb-4 mt-3">Penduduk - Usia</h4>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => 'ObqRhsP78G']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 250px;">Usia Sekolah
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a
                                                            href="{{ route('index_rumah_data', ['codeView' => '7fKa0gsKtH']) }}">
                                                            <button type="button"
                                                                class="btn btn-lg btn-outline-primary mb-2"
                                                                style="width: 270px;">Demografi Usia
                                                                <span class="btn-icon-end"><i
                                                                        class="fa fa-folder-open"></i></span></button>
                                                        </a>
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
{{-- pengaturan --}}
<div class="modal fade pengaturan-dkb" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <a href="{{ route('user.index') }}">
                            <div class="widget-stat card bg-primary">
                                <div class="card-body p-4">
                                    <div class="media">
                                        <span class="me-3">
                                            <i class="flaticon-381-user"></i>
                                        </span>
                                        <div class="media-body text-white text-right">
                                            <p class="mb-1">User</p>
                                            {{-- <h3 class="text-white">$76</h3> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('role.index') }}">
                            <div class="widget-stat card bg-primary">
                                <div class="card-body p-4">
                                    <div class="media">
                                        <span class="me-3">
                                            <i class="flaticon-381-networking"></i>
                                        </span>
                                        <div class="media-body text-white text-right">
                                            <p class="mb-1">Role</p>
                                            {{-- <h3 class="text-white">$76</h3> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'IxmdS85aaN']) }}">
                            <div class="widget-stat card bg-primary">
                                <div class="card-body p-4">
                                    <div class="media">
                                        <span class="me-3">
                                            <i class="flaticon-381-key"></i>
                                        </span>
                                        <div class="media-body text-white text-right">
                                            <p class="mb-1">Permission</p>
                                            {{-- <h3 class="text-white">$76</h3> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
