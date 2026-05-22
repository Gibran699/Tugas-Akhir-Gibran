@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Manajemen Akses</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            </ol>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">user Management</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" onclick="openModal('user')">Tambah user</button>
                    <div class="table-responsive mt-3">
                        <table id="table" class="table table-bordered">
                            <thead class="thead-primary">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->contact }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-status {{ $item->is_active ? 'badge-success' : 'badge-danger' }}"
                                                  id="badge-{{ $item->id }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger deleteUser"
                                                data-id="{{ $item->id }}"><i class="fa fa-trash"></i></button>
                                            <button class="btn btn-warning editUser" data-id="{{ $item->id }}"><i
                                                    class="fas fa-pencil-alt"></i></button>
                                            <button type="button"
                                                class="btn {{ $item->is_active ? 'btn-secondary' : 'btn-success' }} toggleUser"
                                                data-id="{{ $item->id }}"
                                                id="toggle-btn-{{ $item->id }}"
                                                title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="{{ $item->is_active ? 'fa fa-toggle-on' : 'fa fa-toggle-off' }}"
                                                   id="toggle-icon-{{ $item->id }}"></i>
                                            </button>
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
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => 'user.store',
                        'id' => 'formUserCreate',
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">NIK</label>
                        <input type="number" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="description">No.Telp</label>
                        <input type="number" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Jenis Instasi</label>
                        <select name="instansi" id="instansi" class="form-control" required>
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
                    <div class="form-group">
                        <label for="name">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="" selected disabled>--Pilih Role--</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary mt-3" id="saveUser">Simpan</button>
                        {{-- <button type="submit" class="btn btn-primary mt-3">Simpan</button> --}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit user --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open([
                        'method' => 'POST',
                        // 'route' => ['user.update',],
                        'id' => 'formUserEdit',
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="nameEdit" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">NIK</label>
                        <input type="number" class="form-control" id="nikEdit" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="description">Email</label>
                        <input type="email" class="form-control" id="emailEdit" name="email">
                    </div>
                    <div class="form-group">
                        <label for="description">No.Telp</label>
                        <input type="number" class="form-control" id="contactEdit" name="contact">
                    </div>
                    <div class="form-group">
                        <label for="description">Jenis Instasi</label>
                        <select name="instansi" id="instansiEdit" class="form-control">
                            <option disabled>--Pilihan Instasi--</option>
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
                        <input type="text" class="form-control" id="namaInstansiEdit" name="nama_instansi" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Role</label>
                        <select name="role" id="roleEdit" class="form-control">
                            <option value="" disabled>--Pilih Role--</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-actions">

                        <button type="button" class="btn btn-primary mt-3" id="saveEditUser">Simpan</button>
                        {{-- <button type="submit" class="btn btn-primary mt-3">Simpan</button> --}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script src="{{ asset('js/system/user.js') }}"></script>
@endsection
