@extends('layout.master')
@section('content')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
/* ── Layout ─────────────────────────────────────────────────── */
.wk-wrapper {
    display: flex;
    gap: 18px;
    align-items: flex-start;
}
.wk-table-panel {
    flex: 0 0 42%;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.wk-map-panel {
    flex: 1 1 0;
    position: sticky;
    top: 76px;
}
@media (max-width: 991px) {
    .wk-wrapper       { flex-direction: column; }
    .wk-table-panel   { flex: none; width: 100%; }
    .wk-map-panel     { position: static; }
}

/* ── Map ─────────────────────────────────────────────────────── */
#samarindaMap {
    height: 580px;
    border-radius: 0 0 12px 12px;
    border: none;
    z-index: 0;
}

/* ── Table ───────────────────────────────────────────────────── */
.wk-table-scroll {
    max-height: 520px;
    overflow-y: auto;
    border-radius: 0 0 12px 12px;
}
.wk-table-scroll::-webkit-scrollbar { width: 5px; }
.wk-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

#kelurahanTable { margin: 0; font-size: 13px; }
#kelurahanTable thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    background: #1e293b;
    color: #fff;
    font-weight: 600;
    font-size: 12px;
    padding: 10px 12px;
    border: none;
    white-space: nowrap;
}
#kelurahanTable tbody tr.kec-header td {
    background: linear-gradient(90deg, #f0f4ff 0%, #f0fdf4 100%) !important;
    font-weight: 700;
    font-size: 12px;
    color: #1e3a6e;
    padding: 7px 12px;
    border-bottom: 1px solid #e2e8f0;
    border-top: 2px solid #e2e8f0;
}
#kelurahanTable tbody tr.kel-row {
    cursor: pointer;
    transition: background 0.12s;
}
#kelurahanTable tbody tr.kel-row:hover { background: #f8faff; }
#kelurahanTable tbody tr.kel-row.active-row {
    background: #dbeafe !important;
    color: #1e40af !important;
}
#kelurahanTable tbody tr.kel-row td {
    padding: 7px 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

/* ── Kode badge ─────────────────────────────────────────────── */
.kode-badge {
    font-family: 'Courier New', monospace;
    font-size: 11px;
    font-weight: 700;
    color: #3b5bdb;
    background: #eef2ff;
    padding: 2px 7px;
    border-radius: 5px;
    border: 1px solid #c7d2fe;
    white-space: nowrap;
    letter-spacing: 0.3px;
}

/* ── Stat chips ─────────────────────────────────────────────── */
.stat-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: #f8faff; border: 1px solid #dce5f5;
    border-radius: 20px; padding: 5px 14px;
    font-size: 13px; font-weight: 600; color: #374151;
}
.stat-chip .num { font-size: 17px; font-weight: 800; color: #2563eb; }

/* ── Filter chips ───────────────────────────────────────────── */
.kec-chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 16px;
    border: 1.5px solid #d1d5db; background: #fff;
    font-size: 11.5px; font-weight: 500; color: #374151;
    cursor: pointer; transition: all 0.15s; white-space: nowrap;
}
.kec-chip.active {
    color: #fff !important;
    font-weight: 600;
}
.kec-dot {
    width: 8px; height: 8px; border-radius: 50%;
    display: inline-block; flex-shrink: 0;
}

/* ── Search ─────────────────────────────────────────────────── */
.search-wrap { position: relative; }
.search-wrap i {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%); color: #94a3b8; font-size: 13px;
}
#kelurahanSearch {
    padding-left: 32px;
    font-size: 13px;
    border-radius: 8px;
}

/* ── Leaflet popup custom ───────────────────────────────────── */
.kel-popup { min-width: 185px; padding: 2px; }
.kel-popup-name { font-weight: 700; font-size: 14px; color: #1e3a6e; margin-bottom: 4px; }
.kel-popup-kode {
    font-family: monospace; font-size: 12px;
    background: #eef2ff; color: #3b5bdb;
    padding: 2px 8px; border-radius: 5px;
    display: inline-block; margin-bottom: 6px;
    border: 1px solid #c7d2fe;
}
.kel-popup-kec { font-size: 12px; color: #6b7280; }

/* ── Leaflet legend ─────────────────────────────────────────── */
.leaflet-legend {
    background: rgba(255,255,255,0.96);
    border-radius: 10px;
    padding: 10px 13px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.12);
    font-size: 12px;
    max-height: 260px;
    overflow-y: auto;
}
.leaflet-legend::-webkit-scrollbar { width: 4px; }
.leaflet-legend::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.l-legend-title { font-weight: 700; color: #1e3a6e; margin-bottom: 7px; font-size: 12px; }
.l-legend-item { display: flex; align-items: center; gap: 7px; margin-bottom: 5px; line-height: 1.2; }
.l-legend-dot {
    width: 11px; height: 11px; border-radius: 50%;
    flex-shrink: 0; border: 2px solid rgba(0,0,0,0.18);
}
</style>

<div class="container-fluid">
    {{-- Breadcrumb --}}
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Manajemen Akses</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Wilayah Kelurahan</a></li>
        </ol>
    </div>

    {{-- Instruction panel --}}
    <div class="col-12 mb-3">
        <div class="alert mb-0" style="background:linear-gradient(135deg,#eef4ff,#f0fdf4);border:1px solid #c7d9f8;border-radius:14px;padding:14px 18px;">
            <div class="d-flex align-items-start gap-3">
                <div style="width:36px;height:36px;border-radius:9px;flex-shrink:0;background:linear-gradient(135deg,#4f8ef7,#2563eb);display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div style="font-size:13px;color:#374151;line-height:1.7;">
                    <strong style="color:#1e3a6e;">Cara Menggunakan Peta Interaktif</strong><br>
                    Klik baris pada tabel untuk <strong>menampilkan &amp; memperbesar</strong> posisi kelurahan di peta.
                    Klik marker di peta untuk <strong>menyorot baris</strong> pada tabel.
                    Gunakan chip kecamatan untuk memfilter tampilan. Koordinat diambil dari data kecamatan di database dan diperbarui otomatis lewat OpenStreetMap.
                </div>
            </div>
        </div>
    </div>

    {{-- Stats + filter row --}}
    <div class="col-12 mb-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="stat-chip"><i class="fas fa-map-pin text-primary"></i><span class="num" id="statKel">–</span>Kelurahan</span>
            <span class="stat-chip"><i class="fas fa-layer-group" style="color:#059669"></i><span class="num" style="color:#059669" id="statKec">–</span>Kecamatan</span>
            <div id="kecChips" class="d-flex flex-wrap gap-1 ms-1"></div>
        </div>
    </div>

    {{-- Main split layout --}}
    <div class="wk-wrapper">

        {{-- LEFT: Table panel --}}
        <div class="wk-table-panel">
            <div class="card mb-0">
                <div class="card-header pb-2">
                    <h5 class="card-title mb-2">Daftar Kelurahan</h5>
                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" id="kelurahanSearch" class="form-control form-control-sm"
                            placeholder="Cari kode atau nama kelurahan…">
                    </div>
                </div>
                <div class="wk-table-scroll">
                    <table id="kelurahanTable" class="table table-bordered mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:130px;">Kode Wilayah</th>
                                <th>Nama Kelurahan</th>
                            </tr>
                        </thead>
                        <tbody id="kelurahanTbody">
                            <tr><td colspan="2" class="text-center py-4 text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i>Memuat data…
                            </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIGHT: Map panel --}}
        <div class="wk-map-panel">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map me-2 text-primary"></i>Peta Kota Samarinda
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" id="btnRefreshGeo" title="Hapus cache koordinat dan ambil ulang dari OpenStreetMap">
                                <i class="fas fa-sync-alt me-1"></i>Perbarui Koordinat
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="btnResetMap">
                                <i class="fas fa-compress-arrows-alt me-1"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2" style="position:relative;">
                    <div id="samarindaMap"></div>
                    {{-- Geocoding progress overlay --}}
                    <div id="geoProgressWrap">
                        <span id="geoProgressText">Memperbarui koordinat kecamatan…</span>
                        <div id="geoProgressBar"><div id="geoProgressFill"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
/* ── Geocoding progress bar (inside map) ───────────────────── */
#geoProgressWrap {
    display: none;
    position: absolute;
    bottom: 36px; left: 50%; transform: translateX(-50%);
    z-index: 1000;
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    padding: 6px 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    min-width: 240px;
    text-align: center;
    font-size: 12px;
    color: #374151;
    pointer-events: none;
}
#geoProgressBar {
    height: 4px; border-radius: 2px;
    background: #e2e8f0; margin-top: 5px; overflow: hidden;
}
#geoProgressFill {
    height: 100%; width: 0;
    background: linear-gradient(90deg,#4f8ef7,#2563eb);
    transition: width 0.4s ease;
    border-radius: 2px;
}
</style>

<script>
(function ($) {

    /* ═══════════════════════════════════════════════════════════
       CONSTANTS
       ═══════════════════════════════════════════════════════════ */
    const KEC_COLORS = [
        { color:'#4f8ef7', border:'#1d4ed8' },
        { color:'#34d399', border:'#059669' },
        { color:'#fb923c', border:'#ea580c' },
        { color:'#a78bfa', border:'#7c3aed' },
        { color:'#f472b6', border:'#db2777' },
        { color:'#2dd4bf', border:'#0d9488' },
        { color:'#fbbf24', border:'#b45309' },
        { color:'#60a5fa', border:'#2563eb' },
        { color:'#94a3b8', border:'#475569' },
        { color:'#86efac', border:'#16a34a' },
    ];

    /* Fallback approximate centroids — used ONLY before Nominatim resolves */
    const KEC_APPROX = {
        'SAMARINDA ULU':      { lat:-0.4923, lng:117.1391 },
        'SAMARINDA ILIR':     { lat:-0.5145, lng:117.1703 },
        'SAMARINDA KOTA':     { lat:-0.5027, lng:117.1499 },
        'SAMBUTAN':           { lat:-0.5298, lng:117.2073 },
        'SAMARINDA SEBERANG': { lat:-0.5412, lng:117.1073 },
        'LOA JANAN ILIR':     { lat:-0.5647, lng:117.1360 },
        'SUNGAI KUNJANG':     { lat:-0.4791, lng:117.0927 },
        'SUNGAI PINANG':      { lat:-0.4287, lng:117.1621 },
        'PALARAN':            { lat:-0.5678, lng:117.2125 },
        'SAMARINDA UTARA':    { lat:-0.3947, lng:117.1492 },
    };

    const SAMARINDA_CENTER = [-0.5016, 117.1537];
    /* Bounding box constrains Nominatim results to Samarinda area */
    const SAMARINDA_BBOX   = '117.02,-0.68,117.35,-0.33';
    const GEO_CACHE_KEY    = 'wk_kec_geo_v4';

    /* ── Outer-scope state (keyed by stable kecId from DB) ── */
    let groupData  = {};   // kecId → { kec:{id,uuid,kode,nama}, items:[], }
    let groupKeys  = [];   // ordered kecId array
    let markerMap  = {};   // kelurahan.kode → L.circleMarker
    let centerMap  = {};   // kecId → {lat,lng}  (from geocoding)
    let colorMap   = {};   // kecId → {color,border}
    let activeKode   = null;
    let activeFilter = 'ALL';

    /* ═══════════════════════════════════════════════════════════
       UTILITIES
       ═══════════════════════════════════════════════════════════ */
    function titleCase(s) {
        return (s || '').toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    }
    function sleep(ms) { return new Promise(r => setTimeout(r, ms)); }

    function normKec(name) {
        return (name || '').toUpperCase().trim()
            .replace(/^(KECAMATAN|KEC\.?)\s+/i, '')
            .replace(/\s+(KECAMATAN|KEC\.?)$/i, '')
            .trim();
    }

    function getColor(kecId) {
        return colorMap[kecId] || { color: '#adb5bd', border: '#6b7280' };
    }

    /* Approximate centre from kecamatan name (fallback before geocoding) */
    function approxCenter(kecNama) {
        const n = normKec(kecNama);
        for (const [k, v] of Object.entries(KEC_APPROX)) {
            if (k === n || k.includes(n) || n.includes(k)) return v;
        }
        return { lat: SAMARINDA_CENTER[0], lng: SAMARINDA_CENTER[1] };
    }

    function getCenter(kecId, kecNama) {
        return centerMap[kecId] || approxCenter(kecNama);
    }

    /* Sunflower spiral */
    function spiralCoord(center, idx, total) {
        if (total <= 1) return { lat: center.lat, lng: center.lng };
        const golden = Math.PI * (3 - Math.sqrt(5));
        const angle  = idx * golden;
        const r      = 0.014 * Math.sqrt(idx + 1) / Math.sqrt(total);
        return {
            lat: center.lat + r * Math.cos(angle),
            lng: center.lng + r * Math.sin(angle) * 1.4,
        };
    }

    /* Reposition markers of one kecamatan to a new centre */
    function repositionMarkers(kecId, kecNama) {
        const grp    = groupData[kecId];
        if (!grp) return;
        const center = getCenter(kecId, kecNama);
        grp.items.forEach(function (item, idx) {
            const c = spiralCoord(center, idx, grp.items.length);
            if (markerMap[item.kode]) markerMap[item.kode].setLatLng([c.lat, c.lng]);
        });
    }

    function refitAll() {
        const vis = Object.values(markerMap).filter(m => map.hasLayer(m));
        if (vis.length) map.fitBounds(L.featureGroup(vis).getBounds().pad(0.08));
    }

    /* ═══════════════════════════════════════════════════════════
       GEOCODING  (Nominatim, bounded to Samarinda, cached)
       ═══════════════════════════════════════════════════════════ */
    function loadCache()     { try { return JSON.parse(localStorage.getItem(GEO_CACHE_KEY) || '{}'); } catch { return {}; } }
    function saveCache(c)    { try { localStorage.setItem(GEO_CACHE_KEY, JSON.stringify(c)); } catch {} }
    function clearGeoCache() { try { localStorage.removeItem(GEO_CACHE_KEY); } catch {} }

    async function nominatimSearch(query) {
        try {
            const url = 'https://nominatim.openstreetmap.org/search?' +
                'q='        + encodeURIComponent(query) +
                '&format=json&limit=3&countrycodes=id' +
                '&viewbox=' + SAMARINDA_BBOX + '&bounded=1';
            const r = await fetch(url, { headers: { 'Accept-Language': 'id,en' } });
            const d = await r.json();
            return (d && d.length) ? d[0] : null;
        } catch { return null; }
    }

    async function doGeocode(force) {
        const cache   = force ? {} : loadCache();
        const toFetch = groupKeys.filter(id => !cache[id]);

        /* Apply cached positions immediately */
        groupKeys.forEach(function (id) {
            if (cache[id]) {
                centerMap[id] = cache[id];
                repositionMarkers(id, groupData[id].kec.nama);
            }
        });

        if (!toFetch.length) { refitAll(); return; }

        $('#geoProgressWrap').show();
        const $fill = $('#geoProgressFill');
        const $txt  = $('#geoProgressText');

        for (let i = 0; i < toFetch.length; i++) {
            const kecId  = toFetch[i];
            const kecObj = groupData[kecId].kec;
            $txt.text('Memperbarui koordinat (' + (i + 1) + '/' + toFetch.length + '): ' + titleCase(kecObj.nama) + '…');
            $fill.css('width', ((i + 1) / toFetch.length * 100) + '%');

            /* Query uses actual kecamatan name from DB, bounded to Samarinda */
            const query  = 'Kecamatan ' + titleCase(kecObj.nama) + ' Kota Samarinda Kalimantan Timur';
            const result = await nominatimSearch(query);

            if (result) {
                const coord  = { lat: parseFloat(result.lat), lng: parseFloat(result.lon) };
                cache[kecId] = coord;
                centerMap[kecId] = coord;
                repositionMarkers(kecId, kecObj.nama);
            }

            if (i < toFetch.length - 1) await sleep(1200);
        }

        saveCache(cache);
        $('#geoProgressWrap').fadeOut(400);
        refitAll();
    }

    /* ═══════════════════════════════════════════════════════════
       LEAFLET
       ═══════════════════════════════════════════════════════════ */
    const map = L.map('samarindaMap', { center: SAMARINDA_CENTER, zoom: 12 });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
    }).addTo(map);

    function activateMarker(kode) {
        if (activeKode && markerMap[activeKode])
            markerMap[activeKode].setRadius(7).setStyle({ weight: 2, opacity: 0.9 });
        activeKode = kode;
        if (markerMap[kode]) {
            markerMap[kode].setRadius(13).setStyle({ weight: 3, opacity: 1 });
            markerMap[kode].openPopup();
        }
    }
    function activateRow(kode) {
        $('#kelurahanTbody tr.active-row').removeClass('active-row');
        const $tr = $('#kelurahanTbody tr[data-kode="' + kode + '"]');
        if ($tr.length) { $tr.addClass('active-row'); $tr[0].scrollIntoView({ behavior:'smooth', block:'nearest' }); }
    }

    /* ── Filter (uses kecId as stable key) ── */
    function applyFilter(kecId) {
        activeFilter = kecId;
        $('#kecChips .kec-chip').removeClass('active').css({ background:'#fff', color:'#374151' });
        const $chip = $('#kecChips .kec-chip[data-kec="' + kecId + '"]');
        if ($chip.length) {
            const col = $chip.data('color');
            $chip.addClass('active').css({ background: col, color: '#fff', borderColor: col });
        }
        $('#kelurahanTbody tr.kel-row').each(function () {
            $(this).toggle(kecId === 'ALL' || String($(this).data('kec')) === String(kecId));
        });
        $('#kelurahanTbody tr.kec-header').each(function () {
            $(this).toggle(kecId === 'ALL' || String($(this).data('kec')) === String(kecId));
        });
        const vis = [];
        Object.entries(markerMap).forEach(function ([kode, m]) {
            const show = kecId === 'ALL' || String(m.options.kecId) === String(kecId);
            show ? m.addTo(map) : map.removeLayer(m);
            if (show) vis.push(m);
        });
        if (vis.length) map.fitBounds(L.featureGroup(vis).getBounds().pad(0.15));
        applySearch($('#kelurahanSearch').val());
    }

    /* ── Search ── */
    function applySearch(q) {
        q = (q || '').toLowerCase().trim();
        $('#kelurahanTbody tr.kel-row').each(function () {
            const kecId = String($(this).data('kec'));
            if (activeFilter !== 'ALL' && kecId !== String(activeFilter)) { $(this).hide(); return; }
            const kode = String($(this).data('kode')).toLowerCase();
            const nama = $(this).find('td').eq(1).text().toLowerCase();
            $(this).toggle(q === '' || kode.includes(q) || nama.includes(q));
        });
        $('#kelurahanTbody tr.kec-header').each(function () {
            const kecId = String($(this).data('kec'));
            if (activeFilter !== 'ALL' && kecId !== String(activeFilter)) { $(this).hide(); return; }
            const hasVis = $('#kelurahanTbody tr.kel-row[data-kec="' + kecId + '"]').filter(':visible').length > 0;
            $(this).toggle(hasVis);
        });
    }
    $('#kelurahanSearch').on('input', function () { applySearch($(this).val()); });

    /* ═══════════════════════════════════════════════════════════
       RENDER  (called after both API calls complete)
       ═══════════════════════════════════════════════════════════ */
    function renderAll(kecList, kelList) {
        /* Build lookup by both integer id AND uuid */
        const kecById   = {};
        const kecByUuid = {};
        kecList.forEach(function (k) {
            if (k.id   !== null && k.id   !== undefined) kecById[String(k.id)]    = k;
            if (k.uuid !== null && k.uuid !== undefined) kecByUuid[String(k.uuid)] = k;
        });

        /* Group kelurahan using server-resolved kecamatan_id (from dual JOIN COALESCE).
           Falls back to kec_id then uuid so grouping never silently fails. */
        kelList.forEach(function (item) {
            /* 1. Use server-resolved id (most reliable — already COALESCE'd by backend) */
            const resolvedId = (item.kecamatan_id !== null && item.kecamatan_id !== undefined)
                ? String(item.kecamatan_id)
                : null;
            const resolvedUuid = item.kecamatan_uuid || null;
            const kecId = resolvedId || resolvedUuid || 'unknown';

            /* 2. Look up full kecamatan object for geocoding / display */
            const kec = (resolvedId   ? kecById[resolvedId]     : null)
                     || (resolvedUuid  ? kecByUuid[resolvedUuid]  : null)
                     || kecById[String(item.kec_id)]
                     || kecByUuid[String(item.kec_id)]
                     || null;

            if (!groupData[kecId]) {
                groupData[kecId] = {
                    /* If kecamatan list lookup failed, use fields resolved by backend JOIN */
                    kec: kec || {
                        id:   item.kecamatan_id   || null,
                        uuid: item.kecamatan_uuid || null,
                        kode: item.kode_kecamatan || '',
                        nama: item.nama_kecamatan || 'TIDAK DIKETAHUI',
                    },
                    items: [],
                };
            }
            groupData[kecId].items.push(item);
        });

        /* Sort groups by kecamatan kode, fallback to nama */
        groupKeys = Object.keys(groupData).sort(function (a, b) {
            const ka = String(groupData[a].kec.kode || groupData[a].kec.nama);
            const kb = String(groupData[b].kec.kode || groupData[b].kec.nama);
            return ka.localeCompare(kb);
        });

        /* Assign colours */
        groupKeys.forEach(function (kecId, i) {
            colorMap[kecId] = KEC_COLORS[i % KEC_COLORS.length];
        });

        /* Stats */
        $('#statKel').text(kelList.length);
        $('#statKec').text(groupKeys.length);

        /* Filter chips */
        const $chips = $('#kecChips').empty();
        $chips.append('<button class="kec-chip active" data-kec="ALL" data-color="#2563eb" style="background:#2563eb;color:#fff;border-color:#2563eb;">Semua</button>');
        groupKeys.forEach(function (kecId) {
            const grp = groupData[kecId];
            const col = getColor(kecId).color;
            $chips.append(
                '<button class="kec-chip" data-kec="' + kecId + '" data-color="' + col + '" style="border-color:' + col + '">' +
                '<span class="kec-dot" style="background:' + col + '"></span>' +
                titleCase(grp.kec.nama) + '</button>'
            );
        });
        $chips.on('click', '.kec-chip', function () { applyFilter($(this).data('kec')); });

        /* Build table + initial markers */
        const tbody    = $('#kelurahanTbody').empty();
        const allInitM = [];

        groupKeys.forEach(function (kecId) {
            const grp    = groupData[kecId];
            const col    = getColor(kecId);
            const center = getCenter(kecId, grp.kec.nama);

            tbody.append(
                '<tr class="kec-header" data-kec="' + kecId + '">' +
                '<td colspan="2">' +
                '<span class="kec-dot me-1" style="background:' + col.color + ';border:2px solid ' + col.border + '"></span>' +
                '<i class="fas fa-map-marker-alt me-1" style="color:' + col.color + '"></i>' +
                '<strong>Kecamatan ' + titleCase(grp.kec.nama) + '</strong>' +
                (grp.kec.kode ? '<span class="ms-1 text-muted" style="font-size:11px;font-family:monospace">[' + grp.kec.kode + ']</span>' : '') +
                '<span class="badge ms-2" style="background:' + col.color + ';color:#fff;font-size:10px;">' + grp.items.length + ' Kel.</span>' +
                '</td></tr>'
            );

            grp.items.forEach(function (item, idx) {
                const c   = spiralCoord(center, idx, grp.items.length);
                const $tr = $(
                    '<tr class="kel-row" data-kode="' + item.kode + '" data-kec="' + kecId + '">' +
                    '<td><span class="kode-badge">' + item.kode + '</span></td>' +
                    '<td>' + item.nama + '</td></tr>'
                );
                tbody.append($tr);

                $tr.on('click', function () {
                    activateRow(item.kode);
                    activateMarker(item.kode);
                    if (markerMap[item.kode]) map.flyTo(markerMap[item.kode].getLatLng(), 16, { duration: 1.0 });
                });

                const marker = L.circleMarker([c.lat, c.lng], {
                    radius: 7, fillColor: col.color, color: col.border,
                    weight: 2, opacity: 0.9, fillOpacity: 0.82,
                    kecId: kecId,
                });
                marker.bindTooltip(
                    '<b style="font-family:monospace">' + item.kode + '</b>' +
                    '<br>' + item.nama +
                    '<br><small style="color:#6b7280">Kec. ' + titleCase(grp.kec.nama) + '</small>',
                    { sticky: true, offset: L.point(8, 0) }
                );
                marker.bindPopup(
                    '<div class="kel-popup">' +
                    '<div class="kel-popup-name">' + item.nama + '</div>' +
                    '<div class="kel-popup-kode">' + item.kode + '</div>' +
                    '<div class="kel-popup-kec"><i class="fas fa-layer-group me-1"></i>Kec. ' + titleCase(grp.kec.nama) + '</div>' +
                    '</div>'
                );
                marker.on('click', function () { activateMarker(item.kode); activateRow(item.kode); });

                marker.addTo(map);
                markerMap[item.kode] = marker;
                allInitM.push(marker);
            });
        });

        if (allInitM.length) map.fitBounds(L.featureGroup(allInitM).getBounds().pad(0.08));

        /* Legend */
        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function () {
            const div = L.DomUtil.create('div', 'leaflet-legend');
            div.innerHTML = '<div class="l-legend-title"><i class="fas fa-layer-group me-1"></i>Kecamatan</div>';
            groupKeys.forEach(function (kecId) {
                const c  = getColor(kecId);
                const nm = titleCase(groupData[kecId].kec.nama);
                div.innerHTML += '<div class="l-legend-item"><div class="l-legend-dot" style="background:' + c.color + ';border-color:' + c.border + '"></div><span>' + nm + '</span></div>';
            });
            return div;
        };
        legend.addTo(map);

        /* Start geocoding in background */
        doGeocode(false);
    }

    /* ═══════════════════════════════════════════════════════════
       DOCUMENT READY
       ═══════════════════════════════════════════════════════════ */
    $(document).ready(function () {
        if (typeof window.hideLoading === 'function') window.hideLoading();

        /* Fetch kecamatan (from DB) AND kelurahan in parallel */
        $.when(
            $.ajax({ url: '/json/wilayah-kecamatan', type: 'GET', dataType: 'json' }),
            $.ajax({ url: '/json/wilayah-kelurahan',  type: 'GET', dataType: 'json' })
        ).done(function (kecResp, kelResp) {
            const kecList = kecResp[0].data || [];
            const kelList = kelResp[0].data || [];
            if (!kelList.length) {
                $('#kelurahanTbody').html('<tr><td colspan="2" class="text-center text-muted py-4">Tidak ada data kelurahan.</td></tr>');
                return;
            }
            renderAll(kecList, kelList);
        }).fail(function () {
            $('#kelurahanTbody').html('<tr><td colspan="2" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat data.</td></tr>');
        });

        /* Reset map */
        $('#btnResetMap').on('click', function () {
            map.flyTo(SAMARINDA_CENTER, 12, { duration: 0.9 });
            if (activeKode && markerMap[activeKode]) markerMap[activeKode].setRadius(7).setStyle({ weight: 2 }).closePopup();
            activeKode = null;
            $('#kelurahanTbody tr.active-row').removeClass('active-row');
        });

        /* Perbarui Koordinat — clear cache then re-geocode */
        $('#btnRefreshGeo').on('click', function () {
            clearGeoCache();
            doGeocode(true);
        });
    });

})(jQuery);
</script>
@endsection
