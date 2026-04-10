<div class="row g-4">

    {{-- Pie Chart: Status Kawin --}}
    <div class="col-xl-5 col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;">
            <div class="card-header border-0 py-3 px-4"
                 style="background:linear-gradient(135deg,#434E78 0%,#607B8F 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-heart text-warning"></i>
                    <h5 class="mb-0 text-white fw-semibold" style="font-size:0.95rem;">Status Kawin Penduduk</h5>
                </div>
            </div>
            <div class="card-body p-3">
                <div style="position:relative;height:300px;">
                    <canvas id="statusKawin"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Bar Chart: Pendidikan --}}
    <div class="col-xl-7 col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;">
            <div class="card-header border-0 py-3 px-4"
                 style="background:linear-gradient(135deg,#1a6b3a 0%,#2ecc71 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-graduation-cap text-white"></i>
                    <h5 class="mb-0 text-white fw-semibold" style="font-size:0.95rem;">Tingkat Pendidikan Penduduk</h5>
                </div>
            </div>
            <div class="card-body p-3">
                <div style="position:relative;height:300px;">
                    <canvas id="statusPendidikan"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Bar Chart: Top 10 Pekerjaan --}}
    <div class="col-xl-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;overflow:hidden;">
            <div class="card-header border-0 py-3 px-4"
                 style="background:linear-gradient(135deg,#7b2d8b 0%,#e040fb 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-briefcase text-white"></i>
                    <h5 class="mb-0 text-white fw-semibold" style="font-size:0.95rem;">10 Besar Status Pekerjaan Penduduk</h5>
                </div>
            </div>
            <div class="card-body p-3">
                <div style="position:relative;height:340px;">
                    <canvas id="top10Work"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
