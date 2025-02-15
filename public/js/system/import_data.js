
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
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: response.message || 'Import Berhasil!',
            }).then(() => {
                $('#formImport').trigger('reset');
                $('#formImport')[0].reset();
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