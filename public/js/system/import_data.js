
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
            let failureHtml = '';

            if (xhr.status === 422) {
                // validation failures!
                const res = xhr.responseJSON;
                errorMessage = res.message || 'Terdapat data yang tidak valid atau kosong.';
                
                if (res.failures && res.failures.length > 0) {
                    failureHtml += '<div style="text-align:left;max-height:250px;overflow-y:auto;margin-top:10px;font-size:12.5px;border:1px solid #fecaca;background-color:#fff5f5;padding:10px;border-radius:6px;line-height:1.5;">';
                    failureHtml += '<strong class="text-danger" style="display:block;margin-bottom:8px;font-size:13.5px;"><i class="fa fa-circle-exclamation me-1"></i>Daftar Baris yang Bermasalah:</strong>';
                    failureHtml += '<ul style="margin:0;padding-left:18px;color:#991b1b;">';
                    
                    res.failures.forEach(function(f) {
                        const errMsg = Array.isArray(f.errors) ? f.errors.join(', ') : JSON.stringify(f.errors);
                        let valStr = '';
                        if (f.values && f.attribute && f.values[f.attribute] !== undefined) {
                            valStr = ` (Nilai: "${f.values[f.attribute]}")`;
                        }
                        
                        if (f.attribute === 'system') {
                            failureHtml += `<li style="margin-bottom:4px;">System Error: <span style="font-weight:bold;color:#b91c1c;">${errMsg}</span></li>`;
                        } else {
                            const rowLabel = f.row ? `Baris <strong>${f.row}</strong>` : 'Format berkas';
                            failureHtml += `<li style="margin-bottom:4px;">${rowLabel} - Kolom <strong>${f.attribute}</strong>${valStr}: <span style="font-weight:bold;color:#b91c1c;">${errMsg}</span></li>`;
                        }
                    });
                    
                    failureHtml += '</ul>';
                    if (res.failure_count > res.failures.length) {
                        failureHtml += `<p style="color:#b45309;font-weight:bold;margin:8px 0 0 0;font-size:12px;">… dan ${res.failure_count - res.failures.length} baris lainnya bermasalah.</p>`;
                    }
                    failureHtml += '</div>';
                }
            } else if (xhr.status === 409) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message || 'Data sudah ada.';
            } else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message || 'Terjadi kesalahan server.';
            }

            Swal.fire({
                icon: 'error',
                title: 'Import Gagal',
                html: failureHtml ? `<p style="margin-bottom:10px;">${errorMessage}</p>` + failureHtml : errorMessage,
                width: failureHtml ? 600 : undefined,
                confirmButtonText: 'OK',
            });
        }
    });
}
