@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Manajemen Akses</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Wilayah Kelurahan</a></li>
            </ol>
        </div>

        <div class="col-xl-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title">Wilayah Kelurahan Management</h4>
                </div>
                <div class="card-body">
                    {{-- <button class="btn btn-success mb-3" onclick="openModal('wilayah_kelurahan')">Tambah</button> --}}
                    <div class="table-responsive">
                        <table id="wilayah_kelurahanTable" class="table table-bordered table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Kode Wilayah</th>
                                    <th class="text-center">Nama Kelurahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Wilayah Kelurahan Akan Ditambahkan di Sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.data_table')


@endsection
