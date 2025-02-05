
$('#loginForm').on('submit', function (e) {
    e.preventDefault();

    let email = $('#email').val();
    let password = $('#password').val();
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: {
            _token: csrfToken,
            email: email,
            password: password
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Processing...',
                text: 'Harap Tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            Swal.fire({
                type: 'success',
                title: 'Login Berhasil',
                text: response.message || 'Selamat Datang!',
            }).then(() => {
                window.location.href = response.redirect || '/';
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

            if (xhr.status === 404) {
                errorMessage = xhr.responseJSON?.error || 'Email tidak terdaftar!';
            } else if (xhr.status === 401) {
                errorMessage = xhr.responseJSON?.error ||
                    'Email atau Password Salah.';
            }

            Swal.fire({
                type: 'error',
                title: 'Login Gagal',
                text: errorMessage,
            });
        }
    });
});