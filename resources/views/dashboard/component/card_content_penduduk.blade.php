<style>
/* ── Jelly icon bubble ──────────────────────────────── */
.jelly-icon {
    width: 80px; height: 80px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    font-size: 30px; color: #fff;
    position: relative; overflow: hidden;
    transition: transform 0.3s cubic-bezier(.36,.07,.19,.97),
                box-shadow 0.3s ease;
}
/* Glass shine */
.jelly-icon::before {
    content: '';
    position: absolute; top: 7px; left: 14px;
    width: 42%; height: 28%;
    background: rgba(255,255,255,0.38);
    border-radius: 50%;
    transform: rotate(-25deg);
    pointer-events: none;
}
/* Bottom soft glow */
.jelly-icon::after {
    content: '';
    position: absolute; bottom: 6px; right: 12px;
    width: 22%; height: 14%;
    background: rgba(255,255,255,0.18);
    border-radius: 50%;
    pointer-events: none;
}
.jelly-icon:hover {
    transform: scale(1.12) translateY(-4px);
}

/* Per-card color schemes */
.jelly-icon--penduduk {
    background: linear-gradient(135deg, #4f8ef7 0%, #2563eb 100%);
    box-shadow: 0 8px 24px rgba(79,142,247,0.45), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--penduduk:hover {
    box-shadow: 0 14px 32px rgba(79,142,247,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--kk {
    background: linear-gradient(135deg, #34d399 0%, #059669 100%);
    box-shadow: 0 8px 24px rgba(52,211,153,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--kk:hover {
    box-shadow: 0 14px 32px rgba(52,211,153,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--umur {
    background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%);
    box-shadow: 0 8px 24px rgba(251,146,60,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--umur:hover {
    box-shadow: 0 14px 32px rgba(251,146,60,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}

.jelly-icon--ktp {
    background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
    box-shadow: 0 8px 24px rgba(167,139,250,0.42), inset 0 2px 4px rgba(255,255,255,0.25);
}
.jelly-icon--ktp:hover {
    box-shadow: 0 14px 32px rgba(167,139,250,0.55), inset 0 2px 4px rgba(255,255,255,0.25);
}
</style>

<div class="row">
    <div class="col-xl-3 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--penduduk">
                    <i class="fas fa-users"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="sumPenduduk">0</h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Penduduk</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--kk">
                    <i class="fas fa-house-user"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="sumKepalaKeluarga">0</h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Kepala Keluarga</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--umur">
                    <i class="fas fa-child"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="umur017">0</h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">0-17 tahun</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 m-t35">
        <div class="card card-coin">
            <div class="card-body text-center">
                <div class="jelly-icon jelly-icon--ktp">
                    <i class="fas fa-id-card"></i>
                </div>
                <h2 class="text-black mb-2 font-w600" id="pendudukWajibKtp">0</h2>
                <p class="mb-0 fs-14">
                    <span class="text-success me-1">Wajib KTP</span>
                </p>
            </div>
        </div>
    </div>
</div>
