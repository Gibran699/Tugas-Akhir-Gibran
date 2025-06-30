<div class="row">
    <div class="col-xl-6 col-xxl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-2 d-block d-sm-flex flex-wrap border-0">
                        <div class="mb-3">
                            <h4 class="fs-20 text-black">Kelompok Umur</h4>
                            {{-- <p class="mb-0 fs-12">Jumlah agregat Kelompok umur bedasarkan penduduk dan kepala keluarga</p> --}}
                        </div>
                        <div class="card-action card-tabs mb-3 style-1">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#kelompokUmurPenduduk" aria-selected="true"
                                        role="tab">
                                        Penduduk
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kelompokUmurKepalaKeluarga" aria-selected="false"
                                        role="tab" tabindex="-1">
                                        Kepala Keluarga
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body tab-content p-0">
                        <div class="tab-pane fade active show" id="kelompokUmurPenduduk" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table primary-table-bg-hover" id="table_kelompok_umur">
                                        <thead>
                                            <tr>
                                                <th>Kelompok Umur</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="kelompokUmurKepalaKeluarga" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table primary-table-bg-hover" id="table_kepala_keluarga_kelompok_umur">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Umur</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 p-0 caret mt-1">
                        <a href="coin-details.html" class="btn-link"><i class="fa fa-caret-down"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
