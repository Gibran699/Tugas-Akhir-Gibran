$(document).ready(function() {
    $(".toggle-password").on("click", function() {
        let input = $(this).prev(".password-field");
        let icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            input.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
    $("#saveChangePassword").click(function() {
        swal({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin menyimpan kata sandi baru ini?",
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
                changePasswordPost()
            } else {
                swal("Pembatalan", "Data tidak disimpan", "info");
            }
        });
    })
});

function changePasswordPost() {
    var formData = new FormData(document.getElementById('formChangePassword'));
    $.ajax({
        url: $('#formChangePassword').attr('action'),
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
                text: response.message || 'Ubah kata sandi berhasil!',
            }).then(() => {
                $('#formChangePassword').trigger('reset');
                $('#formChangePassword')[0].reset();
            });
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

            if (xhr.status === 403) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message || 'Kata sandi yang dimasukkan tidak sesuai dengan kata sandi lama.';
            }else if (xhr.status === 422) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message ||
                    'Terjadi kesalahan server.';
            }else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message ||
                    'Terjadi kesalahan server.';
            }
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: errorMessage,
            });
        }
    });
}