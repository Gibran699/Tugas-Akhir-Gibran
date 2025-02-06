@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Manajemen Akses</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            </ol>
        </div>

        <div class="col-xl-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">user Management</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" onclick="openModal('user')">Tambah user</button>
                    <div class="table-responsive mt-3">
                        <table id="userTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>ID</th>
                                    <th>Nama user</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data user -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Data -->
    <div class="modal fade" id="crudModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formUserCreate" action="{{ route('user_store') }}" method="post">
                        @csrf
                    {{-- {!! Form::open([
                        'method' => 'post',
                        'route' => 'user_store',
                        'id' => 'formUserCreate',
                    ]) !!} --}}
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">NIK</label>
                        <input type="number" class="form-control" id="nik" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="description">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="description">No.Telp</label>
                        <input type="number" class="form-control" id="contact" name="contact">
                    </div>
                    <div class="form-group">
                        <label for="description">Jenis Instasi</label>
                        <select name="instansi" id="instansi" class="form-control">
                            <option selected disabled>--Pilihan Instasi--</option>
                            <option value="1">OPD Pemerintah</option>
                            <option value="2">OPD Kecamatan</option>
                            <option value="3">OPD Kelurahan</option>
                            <option value="4">BUMD</option>
                            <option value="5">Lembaga Penegak Hukum</option>
                            <option value="7">Lembaga Pemerintah Non-Kementerian</option>
                            <option value="8">Mahasiswa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Instasi</label>
                        <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required>
                    </div>
                    {{-- <div class="form-group">
                            <label for="name">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value=""></option>
                            </select>
                        </div> --}}
                    {{-- <button type="button" class="btn btn-primary mt-3" id="saveUser">Simpan</button> --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </div>
                    
                    {{-- {!! Form::close() !!} --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('#permissionTable tbody input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
        });

        function openModal() {
            $('#crudModal').modal('show');
        }
    </script>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        dataTableBasic();
        document.getElementById('saveUser').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menyimpan data user ini!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    store(); // Call the store function when confirmed
                }
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
                        text: response.message || 'User berhasil ditambahkan!',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
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
    </script>
@endsection
