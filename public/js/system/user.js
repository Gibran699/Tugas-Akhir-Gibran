dataTableBasic();
document.addEventListener('DOMContentLoaded', function () {
    // Attach event listeners to all delete buttons
    document.querySelectorAll('.deleteUser').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id')

            swal({
                title: "Konfirmasi",
                text: "Apakah Anda yakin ingin menghapus data ini?",
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
                    // If the user confirms, submit the form
                    deleteData(userId)
                } else {
                    swal("Pembatalan", "Data tidak dihapus", "info");
                }
            });
        });
    });
    document.getElementById('saveUser').addEventListener('click', function () {
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
                // If the user confirms, submit the form
                store()
            } else {
                swal("Pembatalan", "Data tidak disimpan", "info");
            }
        });
    });
    document.querySelectorAll('.editUser').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id')
            fetchDataUserId(userId)
        })
    })
    document.getElementById('saveEditUser').addEventListener('click', function () {
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
                // If the user confirms, submit the form
                updateData()
            } else {
                swal("Pembatalan", "Data tidak disimpan", "info");
            }
        });
    });
});
function store() {
    var formData = new FormData(document.getElementById('formUserCreate'));
    $.ajax({
        url: $('#formUserCreate').attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
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
                title: 'Berhasil',
                text: response.message || 'User berhasil ditambahkan!',
            }).then(() => {
                location.reload();
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

            if (xhr.status === 409) {
                errorMessage = xhr.responseJSON?.data;
            } else if (xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data;
            }
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: errorMessage,
            });
        }
    });
}
function deleteData(userId) {
    const deleteUrl = `user/:id`.replace(':id', userId); // Replace with user ID
    $.ajax({
        url: deleteUrl,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
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
                title: 'Berhasil',
                text: response.message || 'User telah dihapus!',
            }).then(() => {
                location.reload(); // Reload page after success
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

            if (xhr.status === 409 || xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || errorMessage;
            }

            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: errorMessage,
            });
        }
    });
}
function updateData() {
    var formData = $('#formUserEdit').serialize()
    $.ajax({
        url: $('#formUserEdit').attr('action'),
        type: 'PATCH',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
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
                title: 'Berhasil',
                text: response.message || 'User telah diubah!',
            }).then(() => {
                location.reload(); // Reload page after success
            });
        },
        error: function (xhr) {
            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

            if (xhr.status === 409 || xhr.status === 500) {
                errorMessage = xhr.responseJSON?.data || errorMessage;
            }

            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: errorMessage,
            });
        }
    });
}
function fetchDataUserId(userId) {
    $('#editModal').modal('show')
    $.ajax({
        url: '/user/' + userId + '/edit',
        type: 'GET',
        success: function (data) {
            $('#nameEdit').val(data.nama);
            $('#nikEdit').val(data.nik);
            $('#emailEdit').val(data.email);
            $('#contactEdit').val(data.contact);
            $('#instansiEdit').val(data.instansi).change();
            $('#namaInstansiEdit').val(data.nama_instansi);
            $('#formUserEdit ').attr('action', '/user/' + data.id);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    })
}
function openModal() {
    $('#crudModal').modal('show');
}