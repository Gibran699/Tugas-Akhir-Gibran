{{-- pelayanan --}}
<div class="modal fade pelayanan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-green">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-hand-holding-heart me-2"></i>Data Pelayanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'kP9mY2qR7s']) }}" class="text-decoration-none">
                            <div class="service-card card">
                                <div class="service-card-header">
                                    <div class="service-icon-wrap icon-bg-blue">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <h6 class="service-card-title">Pelayanan Online</h6>
                                </div>
                                <div class="service-card-body">
                                    Data pengajuan secara online dari semua kategori pelayanan
                                </div>
                                <div class="service-card-footer card-footer border-0">
                                    <span class="btn btn-service-open btn-open-blue">
                                        <i class="fas fa-arrow-up-right-from-square me-2"></i>Buka Data
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '7fK97qB2ax']) }}" class="text-decoration-none">
                            <div class="service-card card">
                                <div class="service-card-header">
                                    <div class="service-icon-wrap icon-bg-purple">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <h6 class="service-card-title">Pelayanan Cetak EKTP</h6>
                                </div>
                                <div class="service-card-body">
                                    Data pelayanan secara real time bersumber dari Database EKTP
                                </div>
                                <div class="service-card-footer card-footer border-0">
                                    <span class="btn btn-service-open btn-open-purple">
                                        <i class="fas fa-arrow-up-right-from-square me-2"></i>Buka Data
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '7x9Fk2pQ8R']) }}" class="text-decoration-none">
                            <div class="service-card card">
                                <div class="service-card-header">
                                    <div class="service-icon-wrap icon-bg-teal">
                                        <i class="fas fa-fingerprint"></i>
                                    </div>
                                    <h6 class="service-card-title">Pelayanan Perekaman</h6>
                                </div>
                                <div class="service-card-body">
                                    Data pelayanan secara real time bersumber dari Database Perekaman
                                </div>
                                <div class="service-card-footer card-footer border-0">
                                    <span class="btn btn-service-open btn-open-teal">
                                        <i class="fas fa-arrow-up-right-from-square me-2"></i>Buka Data
                                    </span>
                                </div>
                            </div>
                        </a>
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
            <div class="modal-header modal-header-blue">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-database me-2"></i>Data DKB Agregat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-3">
                    <div class="col-12 col-md-3 col-xl-2">
                        <div class="list-group modal-tab-sidebar" role="tablist">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#list-penduduk" role="tab">
                                <i class="fas fa-users"></i> Penduduk
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-kartu-keluarga" role="tab">
                                <i class="fas fa-house-user"></i> Kepala Keluarga
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-status-kawin" role="tab">
                                <i class="fas fa-ring"></i> Status Kawin
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-pendidikan" role="tab">
                                <i class="fas fa-graduation-cap"></i> Pendidikan
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-disabilitas" role="tab">
                                <i class="fas fa-wheelchair"></i> Disabilitas
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 col-xl-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="list-penduduk">
                                <div class="tab-pane-title"><span>Penduduk</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'MupFCfSa6a']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-mosque"></i></div><span class="data-nav-btn-text">Agama</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'aPH7zF09S1']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-droplet"></i></div><span class="data-nav-btn-text">Gol. Darah</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'CV8V59hUCF']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'fFKZKP7AnA']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-briefcase"></i></div><span class="data-nav-btn-text">Pekerjaan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'bfl4aaeCTi']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-people-group"></i></div><span class="data-nav-btn-text">Hub. Keluarga</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-kartu-keluarga" role="tabpanel">
                                <div class="tab-pane-title"><span>Kepala Keluarga</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'nYtZCUxdr6']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-mosque"></i></div><span class="data-nav-btn-text">Agama</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'MNJiVyMrxR']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'gblPf8pfSp']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-graduation-cap"></i></div><span class="data-nav-btn-text">Pendidikan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'aQIpF1uiEO']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-briefcase"></i></div><span class="data-nav-btn-text">Pekerjaan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'ZvGL0vPJLC']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-ring"></i></div><span class="data-nav-btn-text">Status Kawin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-status-kawin">
                                <div class="tab-pane-title"><span>Status Kawin</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => '2XSDKgCQJH']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-mosque"></i></div><span class="data-nav-btn-text">Agama</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'oqhOV9WfkB']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'AWn2KmOLao']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-briefcase"></i></div><span class="data-nav-btn-text">Pekerjaan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-pendidikan">
                                <div class="tab-pane-title"><span>Pendidikan</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'XYPtrXHZkf']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'eRPt22HZkf']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-briefcase"></i></div><span class="data-nav-btn-text">Pekerjaan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'XYPt22HZkf']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-droplet"></i></div><span class="data-nav-btn-text">Gol. Darah</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-disabilitas">
                                <div class="tab-pane-title"><span>Disabilitas</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'trg1Xxialt']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'iXnbXnoUnq']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-briefcase"></i></div><span class="data-nav-btn-text">Pekerjaan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => '8sfHKi6GHS']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-graduation-cap"></i></div><span class="data-nav-btn-text">Pendidikan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
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
{{-- Kepemilikan  --}}
<div class="modal fade kepemilikan-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-purple">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-folder-open me-2"></i>Data Kepemilikan Dokumen
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '6D6A18O1Hm']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-1">
                                <div class="doc-stat-icon"><i class="fas fa-baby"></i></div>
                                <span class="doc-stat-label">Akta Kelahiran</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'CJY6qXue82']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-2">
                                <div class="doc-stat-icon"><i class="fas fa-ring"></i></div>
                                <span class="doc-stat-label">Akta Perkawinan</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'PKf3FqywDa']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-3">
                                <div class="doc-stat-icon"><i class="fas fa-church"></i></div>
                                <span class="doc-stat-label">Akta Perkawinan - Agama</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'goKsHUTCOG']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-4">
                                <div class="doc-stat-icon"><i class="fas fa-heart-crack"></i></div>
                                <span class="doc-stat-label">Akta Perceraian</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'eCnoaOxtiS']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-5">
                                <div class="doc-stat-icon"><i class="fas fa-place-of-worship"></i></div>
                                <span class="doc-stat-label">Akta Perceraian - Agama</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '2ovlKZBzGU']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-6">
                                <div class="doc-stat-icon"><i class="fas fa-child"></i></div>
                                <span class="doc-stat-label">KIA</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '6DFxmctALZ']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-7">
                                <div class="doc-stat-icon"><i class="fas fa-house-user"></i></div>
                                <span class="doc-stat-label">Kartu Keluarga</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'hsdtkgPeS5']) }}" class="text-decoration-none">
                            <div class="doc-stat-card doc-card-8">
                                <div class="doc-stat-icon"><i class="fas fa-id-card"></i></div>
                                <span class="doc-stat-label">KTP</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
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
            <div class="modal-header modal-header-orange">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-chart-bar me-2"></i>Data Struktur Umur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-3">
                    <div class="col-12 col-md-3 col-xl-2">
                        <div class="list-group modal-tab-sidebar" role="tablist">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#list-sturuktur-umur-agama" role="tab">
                                <i class="fas fa-mosque"></i> Agama
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-sturuktur-umur-disabilitas" role="tab">
                                <i class="fas fa-wheelchair"></i> Disabilitas
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-sturuktur-umur-golongan-darah" role="tab">
                                <i class="fas fa-droplet"></i> Golongan Darah
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-sturuktur-umur-kepala-keluarga" role="tab">
                                <i class="fas fa-house-user"></i> Kepala Keluarga
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#list-struktur-umur-penduduk" role="tab">
                                <i class="fas fa-users"></i> Penduduk
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 col-xl-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="list-sturuktur-umur-agama">
                                <div class="tab-pane-title"><span>Agama</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'OqF8P0knI7']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-layer-group"></i></div><span class="data-nav-btn-text">Kelom. Umur</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-sturuktur-umur-disabilitas" role="tabpanel">
                                <div class="tab-pane-title"><span>Disabilitas</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'VtDkcpu8FN']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-layer-group"></i></div><span class="data-nav-btn-text">Kelom. Umur</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'nx8eUW4TWq']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-graduation-cap"></i></div><span class="data-nav-btn-text">Pendidikan</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => '3WjgN9m6aS']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-person"></i></div><span class="data-nav-btn-text">Umur Tunggal</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'FIZKE9hOxo']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-school"></i></div><span class="data-nav-btn-text">Usia Sekolah</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-sturuktur-umur-golongan-darah" role="tabpanel">
                                <div class="tab-pane-title"><span>Golongan Darah</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'dRgHdz0S5A']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-layer-group"></i></div><span class="data-nav-btn-text">Kelom. Umur</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'eRkbPisQHv']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-person"></i></div><span class="data-nav-btn-text">Umur Tunggal</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-sturuktur-umur-kepala-keluarga" role="tabpanel">
                                <div class="tab-pane-title"><span>Kepala Keluarga</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'svFaBJRBLQ']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-layer-group"></i></div><span class="data-nav-btn-text">Kelom. Umur</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'lo4z2cDrRC']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-person"></i></div><span class="data-nav-btn-text">Umur Tunggal</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'EJpy2qXC3z']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-ring"></i></div><span class="data-nav-btn-text">Status Kawin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-struktur-umur-penduduk" role="tabpanel">
                                <div class="tab-pane-title"><span>Penduduk — Umur Tunggal</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'Byxp2PxZK2']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => '4riLDLsE6q']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-ring"></i></div><span class="data-nav-btn-text">Status Kawin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="tab-pane-title mt-3"><span>Penduduk — Kelompok Umur</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'gWNOWEQuYC']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-venus-mars"></i></div><span class="data-nav-btn-text">Jenis Kelamin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'RIvQj7G1XZ']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-ring"></i></div><span class="data-nav-btn-text">Status Kawin</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="tab-pane-title mt-3"><span>Penduduk — Usia</span></div>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => 'ObqRhsP78G']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-school"></i></div><span class="data-nav-btn-text">Usia Sekolah</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <a href="{{ route('index_rumah_data', ['codeView' => '7fKa0gsKtH']) }}">
                                            <div class="data-nav-btn"><div class="data-nav-btn-icon"><i class="fas fa-chart-line"></i></div><span class="data-nav-btn-text">Demografi Usia</span><i class="fas fa-arrow-right data-nav-btn-arrow"></i></div>
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
{{-- Pengaturan --}}
<div class="modal fade pengaturan-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-gear me-2"></i>Data Pengaturan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    {{-- USER --}}
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <a href="{{ route('user.index') }}" class="text-decoration-none">
                            <div class="neon-btn neon-btn-emerald">
                                <i class="fas fa-user-gear fa-icon"></i>
                                <span>User</span>
                            </div>
                        </a>
                    </div>
                    {{-- ROLE --}}
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <a href="{{ route('role.index') }}" class="text-decoration-none">
                            <div class="neon-btn neon-btn-blue">
                                <i class="fas fa-shield-halved fa-icon"></i>
                                <span>Role</span>
                            </div>
                        </a>
                    </div>
                    {{-- WILAYAH --}}
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'IxmdS85aaN']) }}" class="text-decoration-none">
                            <div class="neon-btn neon-btn-pink">
                                <i class="fas fa-map-location-dot fa-icon"></i>
                                <span>Wilayah Kelurahan</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Kelompok umur --}}
<div class="modal fade kelompok-umur-dkb" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-teal">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-chart-column me-2"></i>Statistik Kelompok Umur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'B5nR8yT3sK']) }}" class="text-decoration-none">
                            <div class="doc-stat-card chart-card-1">
                                <div class="doc-stat-icon"><i class="fas fa-wheelchair"></i></div>
                                <span class="doc-stat-label">Disabilitas</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '7fGk2pQ9Lm']) }}" class="text-decoration-none">
                            <div class="doc-stat-card chart-card-2">
                                <div class="doc-stat-icon"><i class="fas fa-graduation-cap"></i></div>
                                <span class="doc-stat-label">Disabilitas Pendidikan</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'aD4vH9jM6P']) }}" class="text-decoration-none">
                            <div class="doc-stat-card chart-card-3">
                                <div class="doc-stat-icon"><i class="fas fa-droplet"></i></div>
                                <span class="doc-stat-label">Golongan Darah</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => '3XwN7zYqF1']) }}" class="text-decoration-none">
                            <div class="doc-stat-card chart-card-4">
                                <div class="doc-stat-icon"><i class="fas fa-house-user"></i></div>
                                <span class="doc-stat-label">Kepala Keluarga</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'L9bJk5rV2e']) }}" class="text-decoration-none">
                            <div class="doc-stat-card chart-card-5">
                                <div class="doc-stat-icon"><i class="fas fa-users"></i></div>
                                <span class="doc-stat-label">Penduduk</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <a href="{{ route('index_rumah_data', ['codeView' => 'J5nR8yR3sK']) }}" class="text-decoration-none">
                            <div class="doc-stat-card chart-card-6">
                                <div class="doc-stat-icon"><i class="fas fa-people-arrows"></i></div>
                                <span class="doc-stat-label">Penduduk Stat. Kawin</span>
                                <i class="fas fa-chevron-right doc-stat-chevron"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
