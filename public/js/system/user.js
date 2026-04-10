dataTableBasic();

document.addEventListener('DOMContentLoaded', function () {
    // Event listener untuk delete buttons
    document.querySelectorAll('.deleteUser').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            swal({
                title: "Konfirmasi",
                text: "Apakah Anda yakin ingin menghapus data ini?",
                type: "warning",
                buttons: {
                    cancel: "Batal",
                    confirm: {
                        text: "Hapus",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    deleteData(userId);
                } else {
                    swal("Pembatalan", "Data tidak dihapus", "info");
                }
            });
        });
    });

    // Event listener untuk button save create
    document.getElementById('saveUser').addEventListener('click', function (e) {
        e.preventDefault();
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
                store();
            } else {
                swal("Pembatalan", "Data tidak disimpan", "info");
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

    // Event listener untuk button save edit
    document.getElementById('saveEditUser').addEventListener('click', function (e) {
        e.preventDefault();
        swal({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin menyimpan perubahan ini?",
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
                updateData();
            } else {
                swal("Pembatalan", "Data tidak disimpan", "info");
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
    
    // Debug: Log form data
    console.log('Form Data:', formData);
    console.log('URL:', $('#formUserCreate').attr('action'));
    
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
    
    // Debug: Log form data
    console.log('Update Form Data:', formData);
    console.log('Update URL:', $('#formUserEdit').attr('action'));
    
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
