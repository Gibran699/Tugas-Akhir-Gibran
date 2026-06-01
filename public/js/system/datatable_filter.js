/**
 * datatable_filter.js
 *
 * Otomatis menambahkan dropdown filter Kecamatan & Kelurahan
 * di atas setiap DataTable yang memiliki kolom KECAMATAN dan/atau KELURAHAN.
 *
 * Cara kerja:
 *  1. Listen event init.dt dari DataTables
 *  2. Deteksi index kolom KECAMATAN & KELURAHAN dari header
 *  3. Inject dropdown di atas tabel
 *  4. Apply filter via column().search() saat user pilih
 *  5. Cascade — daftar kelurahan berubah sesuai kecamatan yang dipilih
 *  6. Search box bawaan DataTables tetap aktif untuk cari isi row apapun
 *
 * Tidak perlu sentuh JS individual masing-masing fitur.
 */
(function ($) {
    'use strict';

    if (typeof $ === 'undefined' || typeof $.fn.DataTable === 'undefined') return;

    // ── Helpers ────────────────────────────────────────────────────────
    function findColumnIndex(api, label) {
        var idx = -1;
        api.columns().header().each(function (header, i) {
            var text = $(header).text().trim().toUpperCase();
            if (text === label.toUpperCase()) idx = i;
        });
        return idx;
    }

    function getUniqueValues(api, columnIdx, filterByColIdx, filterByValue) {
        var values = {};
        var data = api.column(columnIdx, { search: 'applied', order: 'index' }).data();
        var rows = api.rows({ search: 'applied' }).data();

        for (var i = 0; i < data.length; i++) {
            // Apply secondary filter (e.g. only kelurahan in selected kecamatan)
            if (filterByColIdx !== undefined && filterByValue) {
                var rowKecamatan = String(rows[i][filterByColIdx] || '').trim();
                if (rowKecamatan !== filterByValue) continue;
            }
            var v = String(data[i] || '').trim();
            if (v) values[v] = true;
        }
        return Object.keys(values).sort();
    }

    function buildOptions(values, placeholder) {
        var html = '<option value="">' + (placeholder || '-- Semua --') + '</option>';
        values.forEach(function (v) {
            html += '<option value="' + escapeHtml(v) + '">' + escapeHtml(v) + '</option>';
        });
        return html;
    }

    function escapeHtml(text) {
        var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, function (m) { return map[m]; });
    }

    function escapeRegex(s) {
        return String(s).replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    // ── Build the filter bar HTML ──────────────────────────────────────
    function buildFilterBar(tableId, hasKecamatan, hasKelurahan) {
        var id = 'dtf-' + tableId;
        var html = '<div class="dtf-bar" id="' + id + '" ' +
                   'style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;' +
                   'padding:12px 16px;background:#f8fafc;border:1px solid #e5e7eb;' +
                   'border-radius:10px;margin-bottom:10px;">';

        if (hasKecamatan) {
            html += '<div style="flex:1;min-width:180px;max-width:280px;">' +
                    '<label style="font-size:11px;color:#6b7280;font-weight:600;' +
                    'text-transform:uppercase;letter-spacing:.04em;display:block;margin-bottom:4px;">' +
                    '<i class="fa fa-map-marker-alt me-1"></i>Filter Kecamatan</label>' +
                    '<select class="form-control form-control-sm dtf-kecamatan" ' +
                    'style="font-size:13px;height:34px;border-radius:8px;border:1.5px solid #d1d5db;">' +
                    '<option value="">-- Semua Kecamatan --</option>' +
                    '</select></div>';
        }

        if (hasKelurahan) {
            html += '<div style="flex:1;min-width:180px;max-width:280px;">' +
                    '<label style="font-size:11px;color:#6b7280;font-weight:600;' +
                    'text-transform:uppercase;letter-spacing:.04em;display:block;margin-bottom:4px;">' +
                    '<i class="fa fa-map-pin me-1"></i>Filter Kelurahan</label>' +
                    '<select class="form-control form-control-sm dtf-kelurahan" ' +
                    'style="font-size:13px;height:34px;border-radius:8px;border:1.5px solid #d1d5db;">' +
                    '<option value="">-- Semua Kelurahan --</option>' +
                    '</select></div>';
        }

        html += '<div style="margin-left:auto;">' +
                '<button type="button" class="btn btn-sm btn-outline-secondary dtf-reset" ' +
                'style="height:34px;font-size:12px;padding:0 14px;border-radius:8px;">' +
                '<i class="fa fa-rotate-left me-1"></i>Reset Filter</button></div>';

        html += '</div>';
        return $(html);
    }

    // ── Apply filter to a column ───────────────────────────────────────
    function applyColumnFilter(api, colIdx, value) {
        if (value === '' || value === null || value === undefined) {
            api.column(colIdx).search('').draw();
        } else {
            api.column(colIdx).search('^' + escapeRegex(value) + '$', true, false).draw();
        }
    }

    // ── Main init ──────────────────────────────────────────────────────
    $(document).on('init.dt', function (e, settings) {
        var api = new $.fn.dataTable.Api(settings);
        var $tableNode = $(api.table().node());
        var tableId = $tableNode.attr('id') || 'tbl-' + Math.random().toString(36).slice(2, 9);

        var kecIdx = findColumnIndex(api, 'KECAMATAN');
        var kelIdx = findColumnIndex(api, 'KELURAHAN');

        if (kecIdx === -1 && kelIdx === -1) return; // tabel tidak punya kolom wilayah → skip

        // Kalau filter sudah pernah dipasang (re-init datatable), hapus dulu
        var $existing = $('#dtf-' + tableId);
        if ($existing.length) $existing.remove();

        var $filterBar = buildFilterBar(tableId, kecIdx !== -1, kelIdx !== -1);

        // Pasang filter bar di atas wrapper DataTable
        var $wrapper = $tableNode.closest('.dataTables_wrapper');
        if ($wrapper.length) {
            $wrapper.before($filterBar);
        } else {
            $tableNode.before($filterBar);
        }

        var $kecamatanSelect = $filterBar.find('.dtf-kecamatan');
        var $kelurahanSelect = $filterBar.find('.dtf-kelurahan');

        // ── Populate Kecamatan ─────────────────────────────────────────
        if (kecIdx !== -1) {
            var kecamatanList = getUniqueValues(api, kecIdx);
            $kecamatanSelect.html(buildOptions(kecamatanList, '-- Semua Kecamatan --'));
        }

        // ── Populate Kelurahan ─────────────────────────────────────────
        function refreshKelurahan(filterKecamatan) {
            if (kelIdx === -1) return;
            var kelurahanList = getUniqueValues(api, kelIdx, kecIdx, filterKecamatan);
            $kelurahanSelect.html(buildOptions(kelurahanList, '-- Semua Kelurahan --'));
        }
        refreshKelurahan('');

        // ── Event: pilih Kecamatan ─────────────────────────────────────
        $kecamatanSelect.on('change', function () {
            var v = $(this).val();
            applyColumnFilter(api, kecIdx, v);

            // Reset filter kelurahan + refresh dropdown sesuai kecamatan
            if (kelIdx !== -1) {
                api.column(kelIdx).search('').draw(false);
                $kelurahanSelect.val('');
                refreshKelurahan(v);
            }
        });

        // ── Event: pilih Kelurahan ─────────────────────────────────────
        $kelurahanSelect.on('change', function () {
            var v = $(this).val();
            applyColumnFilter(api, kelIdx, v);
        });

        // ── Event: tombol Reset ────────────────────────────────────────
        $filterBar.find('.dtf-reset').on('click', function () {
            $kecamatanSelect.val('');
            $kelurahanSelect.val('');
            api.search('');
            api.columns().search('').draw();
            refreshKelurahan('');
        });
    });

    // ── Cleanup saat DataTable di-destroy ─────────────────────────────
    $(document).on('destroy.dt', function (e, settings) {
        var api = new $.fn.dataTable.Api(settings);
        var $tableNode = $(api.table().node());
        var tableId = $tableNode.attr('id');
        if (!tableId) return;
        $('#dtf-' + tableId).remove();
    });

})(jQuery);
