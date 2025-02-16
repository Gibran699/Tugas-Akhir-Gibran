@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Agregat Penduduk</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Penduduk - Jenis Kelamin</a></li>
            </ol>
        </div>
        <div class="col-xl-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Semester & Tahun</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formSearchPendudukJenisKelamin',
                            'method' => 'post',
                            'route' => ['search_data', 'CV8V59hUCF'],
                        ]) !!}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="semester" id="semester" class="form-control default-select">
                                    <option value="" disabled selected>--PILIH Semester--</option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="tahun" id="tahun" class="form-control default-select">
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="submitSearch">
                                <i class="fa fa-list"></i> Tampilkan
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Penduduk - Jenis Kelamin <span id="tahunSemester">I
                                2025</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKelurahan" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>KECAMATAN</th>
                                        <th>KELURAHAN</th>
                                        <th>LAKI-LAKI </th>
                                        <th>PEREMPUAN</th>
                                        <th>JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        generateYearOptions('tahun');
    </script>
    <script>
        (function($) {
            $(document).ready(function() {
                $('#submitSearch').click(function() {
                    fetchData();
                });
            });
    
            function fetchData() {
                var formData = new FormData(document.getElementById('formSearchPendudukJenisKelamin'));
                $.ajax({
                    url: $('#formSearchPendudukJenisKelamin').attr('action'),
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
                            type: 'success', // Updated to 'type' for newer SweetAlert versions
                            title: 'Berhasil',
                            text: response.message || 'Pencarian Berhasil!',
                        });
                        setTableKelurahan(response);
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
    
                        if (xhr.status === 400 || xhr.status === 404) {
                            errorMessage = xhr.responseJSON?.data || xhr.responseJSON?.message;
                        }
                        Swal.fire({
                            type: 'error', // Updated to 'type' for newer SweetAlert versions
                            title: 'Gagal',
                            text: errorMessage,
                        });
                    }
                });
            }
    
            function setTableKelurahan(response) {
                // Map the response to the dataSet format
                let dataSet = response.dataPerkelurahan.map(item => [
                    item.kecamatan_nama,
                    item.kelurahan_nama,
                    item.lk,
                    item.pr,
                    item.jumlah
                ]);
    
                // Check if DataTable is already initialized
                if ($.fn.DataTable.isDataTable('#tableKelurahan')) {
                    // If it is, destroy the existing DataTable instance
                    $('#tableKelurahan').DataTable().clear().destroy();
                }
    
                // Initialize DataTable
                let table = $('#tableKelurahan').DataTable({
                    data: dataSet,
                    columns: [
                        { title: "KECAMATAN" },
                        { title: "KELURAHAN" },
                        { title: "LAKI-LAKI" },
                        { title: "PEREMPUAN" },
                        { title: "JUMLAH" },
                    ],
                    createdRow: function(row, data, index) {
                        $(row).addClass('selected');
                    },
                    language: {
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        }
                    }
                });
    
                // Add row click event
                table.on('click', 'tbody tr', function() {
                    var $row = table.row(this).nodes().to$();
                    $row.toggleClass('selected');
                });
    
                // Remove 'selected' class from all rows initially
                table.rows().every(function() {
                    this.nodes().to$().removeClass('selected');
                });
            }
        })(jQuery);
    </script>
@endsection
