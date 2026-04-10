@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Manajemen Akses</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Role</a></li>
            </ol>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Role Management</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" onclick="openModal('role')">Tambah role</button>
                    <div class="table-responsive mt-3">
                        <table id="table" class="table table-striped">
                            @php
                                $no = 1;
                            @endphp
                            <thead class="thead-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger deleteRole"
                                                data-id="{{ $item->uuid }}"><i class="fa fa-trash"></i></button>
                                            <button type="button" class="btn btn-warning editRole"
                                                data-id="{{ $item->uuid }}"><i class="fas fa-pencil-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.data_table')

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="crudModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah role</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <form id="crudForm"> --}}
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => 'role.store',
                        'id' => 'formCreateRole',
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Nama role</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Permission</label>
                        <table class="table table-bordered">
                            <thead class="thead-primary text-white">
                                <th scope="col" width="1%"><input type="checkbox" name="all_permission">
                                </th>
                                <th scope="col" width="20%" class="text-center">Name</th>
                                <th scope="col" width="1%" class="text-center">Guard</th>
                            </thead>
                            <tbody>
                                @foreach ($dataPermission as $permission)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                value="{{ $permission->name }}" class='permission'>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-3" id="saveRole">Simpan</button>
                    {{-- <button type="submit" class="btn btn-outline-primary mt-3" >Simpan</button> --}}
                    {{-- </form> --}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
    <div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit role</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open([
                        'method' => 'POST',
                        'id' => 'formEditRole',
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Nama role</label>
                        <input type="text" class="form-control" id="nameEdit" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Permission</label>
                        <table class="table table-bordered">
                            <thead class="thead-primary text-white">
                                <th scope="col" width="1%"><input type="checkbox" name="all_permission">
                                </th>
                                <th scope="col" width="20%" class="text-center">Name</th>
                                <th scope="col" width="1%" class="text-center">Guard</th>
                            </thead>
                            <tbody>
                                @foreach ($dataPermission as $permission)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="permissionEdit[{{ $permission->name }}]"
                                                value="{{ $permission->name }}" class='permission'>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-3" id="saveEditRole">Simpan</button>
                    {{-- <button type="submit" class="btn btn-outline-primary mt-3" >Simpan</button> --}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if ($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked', false);
                    });
                }

            });
        });

        function openModal() {
            $('#name').val('');
            $('input[name^="permission["]').prop('checked', false);
            $('input[name="all_permission"]').prop('checked', false);
            $('#crudModal').modal('show');
        }
        document.getElementById('saveRole').addEventListener('click', function() {
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
        // Attach event listeners to all delete buttons
        document.querySelectorAll('.deleteRole').forEach(function(button) {
            button.addEventListener('click', function() {
                const roleId = this.getAttribute('data-id')

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
                        deleteData(roleId)
                    } else {
                        swal("Pembatalan", "Data tidak dihapus", "info");
                    }
                });
            });
        });
        document.querySelectorAll('.editRole').forEach(function(button) {
            button.addEventListener('click', function() {
                const roleId = this.getAttribute('data-id')
                fetchDataId(roleId)
            })
        })
        document.getElementById('saveEditRole').addEventListener('click', function() {
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
        // all function
        function store() {
            var permissions = [];
            $('input[name^="permission["]:checked').each(function() {
                permissions.push($(this).val());
            });

            // Validasi: pastikan minimal 1 permission dipilih
            if (permissions.length === 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Pilih minimal 1 permission!',
                });
                return;
            }

            console.log('Permissions yang dipilih:', permissions);

            var formData = new FormData();
            formData.append('name', $('#name').val());
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            
            permissions.forEach(function(permission) {
                formData.append('permission[]', permission);
            });

            // Debug: tampilkan semua data yang akan dikirim
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: $('#formCreateRole').attr('action'),
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
                        text: response.message || 'Role berhasil ditambahkan!',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                    } else if (xhr.status === 409) {
                        errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message;
                    } else if (xhr.status === 500) {
                        errorMessage = xhr.responseJSON?.message || xhr.responseJSON?.data;
                    }
                    Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: errorMessage,
                    });
                }
            });
        }

        function deleteData(roleId) {
            const deleteUrl = `role/:id`.replace(':id', roleId); // Replace with user ID
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
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
                        text: response.message || 'Role telah dihapus!',
                    }).then(() => {
                        location.reload(); // Reload page after success
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                    } else if (xhr.status === 409) {
                        errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message;
                    } else if (xhr.status === 500) {
                        errorMessage = xhr.responseJSON?.message || xhr.responseJSON?.data;
                    }

                    Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: errorMessage,
                    });
                }
            });
        }

        function fetchDataId(roleId) {
            $('#editRoleModal').modal('show');
            const fetchDataUrl = `role/:id/edit`.replace(':id', roleId); // Replace with user ID
            $.ajax({
                url: fetchDataUrl,
                type: 'get',
                success: function(response) {
                    $('#nameEdit').val(response.role.name)
                    // Kosongkan tabel permission
                    $('input[name^="permissionEdit"]').prop('checked', false);
                    $('#formEditRole ').attr('action', '/role/' + response.role.uuid);
                    // Centang permission yang sudah dimiliki oleh role
                    response.permission.forEach(permissionName => {
                        $(`input[name="permissionEdit[${permissionName}]"]`).prop('checked', true);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            })
        }

        function updateData(roleId) {
            var permissions = [];
            $('input[name^="permissionEdit["]:checked').each(function() {
                permissions.push($(this).val());
            });

            // Validasi: pastikan minimal 1 permission dipilih
            if (permissions.length === 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Pilih minimal 1 permission!',
                });
                return;
            }

            console.log('Permissions yang dipilih untuk update:', permissions);

            var formData = new FormData();
            formData.append('name', $('#nameEdit').val());
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('_method', 'PATCH');
            
            permissions.forEach(function(permission) {
                formData.append('permissionEdit[]', permission);
            });

            // Debug: tampilkan semua data yang akan dikirim
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: $('#formEditRole').attr('action'),
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
                        text: response.message || 'Role telah diubah!',
                    }).then(() => {
                        location.reload(); // Reload page after success
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                    } else if (xhr.status === 409) {
                        errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message;
                    } else if (xhr.status === 500) {
                        errorMessage = xhr.responseJSON?.message || xhr.responseJSON?.data;
                    }

                    Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: errorMessage,
                    });
                }
            });
        }
    </script>
@endsection
@endsection
