<style>
/* ── Kepemilikan jelly color modifiers ───────────────── */
.jelly-icon--kep-ktp {
    background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
    box-shadow: 0 8px 24px rgba(96,165,250,0.45), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--kep-ktp:hover {
    box-shadow: 0 14px 32px rgba(96,165,250,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--akta-lahir {
    background: linear-gradient(135deg, #2dd4bf 0%, #0d9488 100%);
    box-shadow: 0 8px 24px rgba(45,212,191,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--akta-lahir:hover {
    box-shadow: 0 14px 32px rgba(45,212,191,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--akta-kawin {
    background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
    box-shadow: 0 8px 24px rgba(251,113,133,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--akta-kawin:hover {
    box-shadow: 0 14px 32px rgba(251,113,133,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--kk-doc {
    background: linear-gradient(135deg, #4ade80 0%, #16a34a 100%);
    box-shadow: 0 8px 24px rgba(74,222,128,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--kk-doc:hover {
    box-shadow: 0 14px 32px rgba(74,222,128,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--kia {
    background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
    box-shadow: 0 8px 24px rgba(251,191,36,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--kia:hover {
    box-shadow: 0 14px 32px rgba(251,191,36,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--akta-cerai {
    background: linear-gradient(135deg, #94a3b8 0%, #475569 100%);
    box-shadow: 0 8px 24px rgba(148,163,184,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--akta-cerai:hover {
    box-shadow: 0 14px 32px rgba(148,163,184,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}
</style>

<div class="row">
    <h3 class="mb-3">Kepemilikan</h3>
    <div class="col-xl-4 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--kep-ktp">
                    <i class="fas fa-id-card"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="kepemilikanKtp"></h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">KTP</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--akta-lahir">
                    <i class="fas fa-baby"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="kepemilikanAktaKelahiran"></h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Akta Kelahiran</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--akta-kawin">
                    <i class="fas fa-heart"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="kepemilikanAktaKawin"></h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Akta Kawin</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--kk-doc">
                    <i class="fas fa-home"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="kepemilikanKartuKeluarga"></h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Kartu Keluarga</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--kia">
                    <i class="fas fa-id-badge"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="kepemilikanKia"></h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">KIA</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--akta-cerai">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="kepemilikanAktaCerai"></h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Akta Cerai</span>
                </p>
            </div>
        </div>
    </div>
</div>
