
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submitImport').addEventListener('click', function() {
        swal({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin menyimpan data ini?",
            type: "warning",
            buttons: {
                cancel: "Batal",
                confirm: {
                    text: "Simpan",
                    value: true,
                    visible: true,
                    className: "btn btn-primary",
                }
            },
            dangerMode: true,
        }).then((willSave) => {
            if (willSave) {
                importData()
            } else {
                swal("Pembatalan", "Data tidak disimpan", "info");
            }
        });
    });
});

function importData() {
    var formData = new FormData(document.getElementById('formImport'));
    $.ajax({
        url: $('#formImport').attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            Swal.fire({
                title: 'Processing...',
                text: 'Harap Tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            // ── Status: partial (ada baris yang gagal) ───────────────────────
            if (response.status === 'partial') {
                let failureHtml = '';
                if (response.failures && response.failures.length > 0) {
                    failureHtml += '<div style="text-align:left;max-height:200px;overflow-y:auto;margin-top:10px;font-size:12px;">';
                    failureHtml += '<strong>Detail baris gagal (maks 20):</strong><ul style="margin-top:6px;padding-left:16px;">';
                    response.failures.forEach(function(f) {
                        const errMsg = Array.isArray(f.errors) ? f.errors.join(', ') : JSON.stringify(f.errors);
                        failureHtml += `<li>Baris <strong>${f.row}</strong> [${f.attribute}]: ${errMsg}</li>`;
                    });
                    failureHtml += '</ul>';
                    if (response.failure_count > 20) {
                        failureHtml += `<p style="color:#9a3412;">… dan ${response.failure_count - 20} baris lainnya. Lihat log server untuk detail lengkap.</p>`;
                    }
                    failureHtml += '</div>';
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Import Sebagian Berhasil',
                    html: `<p>${response.message}</p>` + failureHtml,
                    confirmButtonText: 'OK',
                    width: 600,
                }).then(() => {
                    window.location.reload();
                });
                return;
            }

            // ── Status: success (semua baris tersimpan) ──────────────────────
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message || 'Import Berhasil!',
            }).then(() => {
                window.location.reload();
            });
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

            if (xhr.status === 409) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message || 'Data sudah ada.';
            } else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message || 'Terjadi kesalahan server.';
            }
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: errorMessage,
            });
        }
    });
}
