/**
 * data_not_found_handler.js
 *
 * Pasang global jQuery AJAX handler untuk menampilkan SweetAlert
 * yang seragam ketika server merespons dengan status 404 dan body
 * `{status: 'missing', message: ...}` — yaitu saat data agregat
 * untuk periode yang dicari tidak tersedia.
 *
 * Otomatis aktif di semua halaman yang memuat file ini.
 */
(function () {
    if (typeof jQuery === 'undefined') return;

    jQuery(document).ajaxError(function (event, xhr, settings, thrownError) {
        // Hanya tangani permintaan ke endpoint search-data
        if (!settings || !settings.url || settings.url.indexOf('json/search-data/') === -1) {
            return;
        }

        // Hanya tangani response 404 dengan flag missing dari controller
        if (xhr.status !== 404) return;

        var res = xhr.responseJSON || {};
        if (res.status !== 'missing') return;

        // Tutup SweetAlert loading jika sedang terbuka
        if (typeof Swal !== 'undefined' && Swal.close) {
            Swal.close();
        }

        // Tampilkan alert baru dengan pesan informatif
        var feature = res.feature_label || res.message || 'Data yang dicari';
        var periode = res.periode_label || '';
        var detail  = res.detail        || 'Silakan pilih periode lain atau hubungi admin untuk melakukan import data.';

        setTimeout(function () {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Tersedia',
                html:
                    '<div style="text-align:left;font-size:14px;">' +
                        '<p class="mb-2">' +
                            'Data <strong>' + feature + '</strong>' +
                            (periode ? ' untuk <strong>' + periode + '</strong>' : '') +
                            ' tidak tersedia saat ini.' +
                        '</p>' +
                        '<div class="p-2 rounded mt-2" ' +
                            'style="background:#fff7ed;border:1px solid #fed7aa;font-size:13px;">' +
                            '<i class="fa fa-info-circle me-1" style="color:#ea580c;"></i>' +
                            detail +
                        '</div>' +
                    '</div>',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#ea580c',
            });
        }, 50);

        // Cegah handler error individual masing-masing JS menampilkan pesan generik
        // Tetap biarkan handler asli jalan, tapi marking di responseJSON agar bisa
        // dideteksi (handler asli akan tetap pakai responseJSON.message default,
        // namun karena alert kita sudah muncul terlebih dahulu, user lihat alert ini).
        try {
            xhr.responseJSON._handled = true;
        } catch (e) {}
    });
})();
