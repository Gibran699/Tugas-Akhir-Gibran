@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengaturan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Import Data</a></li>
            </ol>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Import Data</h4>
                    <button class="btn btn-success text-right" data-bs-toggle="modal"
                        data-bs-target=".listFileExcelFormatImport"><i class="fa fa-file-excel"></i> Format file import
                        excel</button>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::open([
                            'id' => 'formImport',
                            'method' => 'POST',
                            'route' => 'import_data',
                            'files' => true,
                        ]) !!}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="form-label">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control default-select">
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="form-label">Semester</label>
                                <select name="semester" id="semester" class="form-control default-select">
                                    <option value="" disabled selected>--PILIH Semester--</option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="form-label">File Excel</label>
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="form-label">Pilih Data Import</label>
                                <select name="keterangan_file" id="keteranganFile" required>
                                    <option value="" disabled selected>--PILIHAN DATA--</option>
                                    @foreach (config('dataArray.listFileImport') as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ preg_replace('/(?<!^)([A-Z])/', ' $1', str_replace(['App\Imports\\', 'Import'], '', $value)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{-- <button type="button" class="btn btn-primary" id="submitImport">
                                    <i class="fa fa-file-import"></i> Import
                                </button> --}}
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-file-import"></i> Import
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade listFileExcelFormatImport" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Excel Format Import</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="fileTable">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Nama File</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($collection = config('dataArray.listDataFileExcelFormatImport') as $item)
                                                <tr>
                                                    <td>{{ $item['name_file'] }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success download-btn" data-filepath="{{ $item['location_file'] }}" data-filename="{{ $item['name_file'] }}.xlsx"><i class="fa fa-download"></i>Download</button>
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
            </div>
        </div>
    </div>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        // Move this function outside the jQuery closure
        function downloadFile(filePath, fileName) {
            // Create a temporary anchor element
            const link = document.createElement('a');
            link.href = filePath; // Set the file path
            link.download = fileName; // Set the file name for download
            document.body.appendChild(link);

            // Trigger the download
            link.click();

            // Clean up
            document.body.removeChild(link);
        }

        (function($) {
            // Generate options untuk tahun
            generateYearOptions('tahun');

            // Inisialisasi Select2 pada elemen dengan ID 'keteranganFile'
            $("#keteranganFile").select2();

            $('#fileTable').DataTable({
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });

            // Alternatively, you can use jQuery event delegation instead of onclick attributes
            $(document).on('click', '.download-btn', function() {
                const filePath = $(this).data('filepath');
                const fileName = $(this).data('filename');
                downloadFile(filePath, fileName);
            });
        })(jQuery);
    </script>
    <script src="{{ asset('js/system/import_data.js') }}"></script>
@endsection
