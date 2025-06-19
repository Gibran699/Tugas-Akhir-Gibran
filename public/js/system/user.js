dataTableBasic();

document.addEventListener('DOMContentLoaded', function () {
    // Event listener untuk delete buttons
    document.querySelectorAll('.deleteUser').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(userId);
                } else {
                    Swal.fire('Pembatalan', 'Data tidak dihapus', 'info');
                }
            });
        });
    });

    // Event listener untuk submit form create
    document.getElementById('formUserCreate').addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan data ini?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                store();
            } else {
                Swal.fire('Pembatalan', 'Data tidak disimpan', 'info');
            }
        });
    });

    // Event listener untuk edit buttons
    document.querySelectorAll('.editUser').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            fetchDataUserId(userId);
        });
    });

    // Event listener untuk submit form edit
    document.getElementById('formUserEdit').addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan perubahan ini?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                updateData();
            } else {
                Swal.fire('Pembatalan', 'Data tidak disimpan', 'info');
            }
        });
    });

    // Reset form saat modal ditutup
    $('#crudModal, #editModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });
});

function store() {
    const formData = $('#formUserCreate').serialize();
    $.ajax({
        url: $('#formUserCreate').attr('action'),
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Processing...',
                text: 'Harap Tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message || 'User berhasil ditambahkan!',
            }).then(() => {
                location.reload();
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
            if (xhr.status === 409) {
                errorMessage = xhr.responseJSON?.data || 'Data sudah terdaftar.';
            } else if (xhr.status === 422) {
                errorMessage = xhr.responseJSON?.errors
                    ? Object.values(xhr.responseJSON.errors).flat().join('<br>')
                    : 'Validasi gagal.';
            } else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || 'Kesalahan server.';
            }
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: errorMessage,
            });
        },
    });
}

function deleteData(userId) {
    const deleteUrl = `/user/${userId}`;
    $.ajax({
        url: deleteUrl,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Processing...',
                text: 'Harap Tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message || 'User telah dihapus!',
            }).then(() => {
                location.reload();
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
            if (xhr.status === 409) {
                errorMessage = xhr.responseJSON?.data || 'Konflik data.';
            } else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || 'Kesalahan server.';
            }
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: errorMessage,
            });
        },
    });
}

function updateData() {
    const formData = $('#formUserEdit').serialize();
    $.ajax({
        url: $('#formUserEdit').attr('action'),
        type: 'PATCH',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Processing...',
                text: 'Harap Tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message || 'User telah diubah!',
            }).then(() => {
                location.reload();
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
            if (xhr.status === 409) {
                errorMessage = xhr.responseJSON?.data || 'Konflik data.';
            } else if (xhr.status === 422) {
                errorMessage = xhr.responseJSON?.errors
                    ? Object.values(xhr.responseJSON.errors).flat().join('<br>')
                    : 'Validasi gagal.';
            } else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || 'Kesalahan server.';
            }
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: errorMessage,
            });
        },
    });
}

function fetchDataUserId(userId) {
    $('#editModal').modal('show');
    $.ajax({
        url: `/user/${userId}/edit`,
        type: 'GET',
        success: function (data) {
            // Sesuaikan dengan struktur data yang dikembalikan dari server
            $('#nameEdit').val(data.nama || data.user?.nama);
            $('#nikEdit').val(data.nik);
            $('#emailEdit').val(data.email || data.user?.email);
            $('#contactEdit').val(data.contact);
            $('#instansiEdit').val(data.instansi).trigger('change');
            $('#roleEdit').val(data.role_names || data.user?.role_names).trigger('change');
            $('#namaInstansiEdit').val(data.nama_instansi);
            $('#formUserEdit').attr('action', `/user/${data.id || data.user?.id}`);
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal mengambil data user. Silakan coba lagi.',
            });
        },
    });
}

function openModal() {
    $('#crudModal').modal('show');
}
