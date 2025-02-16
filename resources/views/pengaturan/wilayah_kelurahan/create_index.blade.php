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
                        <table id="wilayahKelurahanTable" class="table table-bordered table-hover table-striped">
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

    <script>
        (function($) {
            $(document).ready(function() {
                // Fetch data from the endpoint
                $.ajax({
                    url: "/json/wilayah-kelurahan",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // Map the response to the dataSet format
                        let dataSet = response.data.map(item => [item.kode, item.nama]);

                        // Initialize DataTable
                        let table = $('#wilayahKelurahanTable').DataTable({
                            data: dataSet,
                            columns: [{
                                    title: "Kode Wilayah"
                                },
                                {
                                    title: "Nama Kelurahan"
                                }
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
                            var hasClass = $row.hasClass('selected');
                            if (hasClass) {
                                $row.removeClass('selected');
                            } else {
                                $row.addClass('selected');
                            }
                        });

                        // Remove 'selected' class from all rows initially
                        table.rows().every(function() {
                            this.nodes().to$().removeClass('selected');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
