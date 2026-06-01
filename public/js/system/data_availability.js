/**
 * DataAvailability — JavaScript helper
 *
 * Digunakan pada halaman fitur untuk mengecek ketersediaan data
 * sebelum menampilkan tabel/grafik.
 *
 * Cara integrasi pada halaman fitur:
 * ─────────────────────────────────────────────────────────────
 * 1. Sertakan script ini di blade view:
 *      <script src="{{ asset('js/system/data_availability.js') }}"></script>
 *
 * 2. Pastikan komponen empty-state sudah ada di halaman:
 *      <x-data-empty-state
 *          feature="data_dkb"
 *          entity="penduduk"
 *          dimension="agama"
 *          container-id="dataContentArea"
 *      />
 *      <div id="dataContentArea"> ... tabel/grafik ... </div>
 *
 * 3. Di JS halaman fitur, panggil sebelum fetch data:
 *      DataAvailability.check({
 *          feature: 'data_dkb', entity: 'penduduk', dimension: 'agama',
 *          tahun: selectedTahun, semester: selectedSemester
 *      }).then(result => {
 *          if (result.canDisplay) {
 *              loadData(); // lanjut fetch data normal
 *          }
 *      });
 * ─────────────────────────────────────────────────────────────
 */

var DataAvailability = (function () {

    var _stateEl    = null;
    var _checkUrl   = null;
    var _isAdmin    = false;
    var _canImport  = false;
    var _importUrl  = null;

    function _init() {
        _stateEl   = document.getElementById('dataAvailabilityState');
        if (!_stateEl) return;

        _checkUrl  = _stateEl.dataset.checkUrl  || '/data-availability/check';
        _isAdmin   = _stateEl.dataset.isAdmin   === '1';
        _canImport = _stateEl.dataset.canImport === '1';
        _importUrl = _stateEl.dataset.importUrl || '/form-import';
    }

    function _hideAll() {
        if (!_stateEl) return;
        _stateEl.style.display = 'none';
        _stateEl.querySelectorAll('.das-card').forEach(function(c) {
            c.style.display = 'none';
        });
    }

    function _showContent(containerId) {
        var el = document.getElementById(containerId || 'dataContentArea');
        if (el) el.style.display = '';
    }

    function _hideContent(containerId) {
        var el = document.getElementById(containerId || 'dataContentArea');
        if (el) el.style.display = 'none';
    }

    function _buildActions(status) {
        var html = '';
        if (_canImport && status !== 'available') {
            html += '<a href="' + _importUrl + '" class="btn btn-sm btn-warning">'
                  + '<i class="fa fa-upload me-1"></i>Import Data Sekarang</a>';
        }
        if (!_canImport && status !== 'available') {
            html += '<span class="text-muted small">'
                  + '<i class="fa fa-info-circle me-1"></i>'
                  + 'Silakan hubungi admin untuk memastikan ketersediaan data.</span>';
        }
        return html;
    }

    function _buildMissingWilayahBadges(missingWilayah) {
        if (!missingWilayah || missingWilayah.length === 0) return '';
        var html = '<div class="mt-1"><small class="text-warning fw-semibold">'
                 + '<i class="fa fa-map-marker-alt me-1"></i>'
                 + 'Wilayah belum tersedia (' + missingWilayah.length + '):</small><br/>';
        missingWilayah.forEach(function(w) {
            html += '<span class="badge bg-light text-secondary border me-1 mb-1" style="font-size:10px;">'
                  + w.nama + '</span>';
        });
        html += '</div>';
        return html;
    }

    function _renderMissing(data, containerId) {
        if (!_stateEl) return;
        var card    = _stateEl.querySelector('.das-missing');
        var msgEl   = card.querySelector('.das-message');
        var metaEl  = card.querySelector('.das-meta');
        var actEl   = card.querySelector('.das-actions');

        var msg = _isAdmin ? (data.message_for_admin || data.message_for_user) : data.message_for_user;
        msgEl.textContent = msg || 'Data untuk periode atau wilayah yang dipilih belum tersedia.';

        if (_isAdmin && data.table) {
            metaEl.innerHTML = '<i class="fa fa-table me-1"></i>Tabel: <code>' + data.table + '</code>'
                             + ' &nbsp;·&nbsp; Semester ' + data.semester + ' / ' + data.tahun;
        } else {
            metaEl.textContent = 'Semester ' + data.semester + ' / ' + data.tahun;
        }

        actEl.innerHTML = _buildActions('missing');

        _stateEl.style.display = '';
        card.style.display = 'flex';
        _hideContent(containerId);
    }

    function _renderPartial(data, containerId) {
        if (!_stateEl) return;
        var card    = _stateEl.querySelector('.das-partial');
        var msgEl   = card.querySelector('.das-message');
        var metaEl  = card.querySelector('.das-meta');
        var wilEl   = card.querySelector('.das-wilayah-missing');
        var actEl   = card.querySelector('.das-actions');

        var msg = _isAdmin ? (data.message_for_admin || data.message_for_user) : data.message_for_user;
        msgEl.textContent = msg || 'Data untuk periode atau wilayah yang dipilih belum lengkap.';

        if (_isAdmin && data.table) {
            metaEl.innerHTML = '<i class="fa fa-table me-1"></i>Tabel: <code>' + data.table + '</code>'
                             + ' &nbsp;·&nbsp; ' + data.total_data + '/' + data.total_wilayah + ' wilayah tersedia';
        } else {
            metaEl.textContent = data.total_data + ' dari ' + data.total_wilayah + ' wilayah tersedia.';
        }

        if (_isAdmin && data.missing_wilayah) {
            wilEl.innerHTML = _buildMissingWilayahBadges(data.missing_wilayah);
        }

        actEl.innerHTML = _buildActions('partial');

        _stateEl.style.display = '';
        card.style.display = 'flex';
        // Partial: tetap tampilkan konten data
        _showContent(containerId);
    }

    /**
     * Fungsi utama: cek ketersediaan data via API.
     *
     * @param {object} params
     *   feature, entity, dimension, tahun, semester,
     *   kode_kecamatan (opsional), kode_kelurahan (opsional)
     * @param {string} containerId  id element konten utama
     * @returns {Promise<{canDisplay: boolean, status: string, data: object}>}
     */
    function check(params, containerId) {
        _init();
        _hideAll();

        containerId = containerId || (_stateEl ? _stateEl.dataset.container : 'dataContentArea');

        var queryStr = Object.keys(params)
            .filter(function(k) { return params[k] !== null && params[k] !== undefined && params[k] !== ''; })
            .map(function(k) { return encodeURIComponent(k) + '=' + encodeURIComponent(params[k]); })
            .join('&');

        var url = (_checkUrl || '/data-availability/check') + '?' + queryStr;

        return $.get(url)
            .then(function(data) {
                switch (data.status) {
                    case 'available':
                        _showContent(containerId);
                        return { canDisplay: true, status: 'available', data: data };

                    case 'partial':
                        _renderPartial(data, containerId);
                        return { canDisplay: true, status: 'partial', data: data };

                    case 'missing':
                        _renderMissing(data, containerId);
                        return { canDisplay: false, status: 'missing', data: data };

                    default:
                        // 'unknown' — error konfigurasi, tampilkan konten agar tidak block user
                        _showContent(containerId);
                        return { canDisplay: true, status: 'unknown', data: data };
                }
            })
            .catch(function() {
                // Jika check gagal, jangan block tampilan data
                _showContent(containerId);
                return { canDisplay: true, status: 'error', data: null };
            });
    }

    return { check: check };
}());
