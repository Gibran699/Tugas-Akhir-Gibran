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
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h4 class="card-title mb-0">Form Import Data</h4>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('data_availability.dashboard') }}" class="btn btn-outline-primary">
                            <i class="fa fa-chart-simple me-1"></i> Data Tersedia
                        </a>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target=".listFileExcelFormatImport">
                            <i class="fa fa-file-excel me-1"></i> Format File Import Excel
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Tip box: saran convert ke CSV untuk file besar --}}
                    <div class="alert d-flex align-items-start gap-3 mb-4"
                         style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #ea580c;border-radius:10px;padding:14px 16px;">
                        <i class="fa fa-lightbulb fa-lg" style="color:#ea580c;margin-top:2px;flex-shrink:0;"></i>
                        <div style="font-size:13.5px;color:#9a3412;line-height:1.55;">
                            <strong>Tips untuk file besar:</strong>
                            untuk file dengan <strong>lebih dari 3000 baris</strong>, kami sarankan
                            <strong>convert ke CSV terlebih dahulu</strong> agar proses import jauh lebih cepat.
                            <br>
                            <span style="color:#7c2d12;">Cara: buka file Excel → <em>File</em> → <em>Save As</em> → pilih format <strong>CSV (Comma delimited)</strong> → Save.</span>
                        </div>
                    </div>

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
                                            {{ config('dataArray.listFileImportLabel')[$key]
                                                ?? preg_replace('/(?<!^)([A-Z])/', ' $1', str_replace(['App\Imports\\', 'Import'], '', $value)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" id="submitImport">
                                    <i class="fa fa-file-import"></i> Import
                                </button>
                                {{-- <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-file-import"></i> Import
                                </button> --}}
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
                    {{-- Tip box dalam modal: saran format CSV --}}
                    <div class="alert d-flex align-items-start gap-3 mb-3"
                         style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #ea580c;border-radius:10px;padding:14px 16px;">
                        <i class="fa fa-info-circle fa-lg" style="color:#ea580c;margin-top:2px;flex-shrink:0;"></i>
                        <div style="font-size:13px;color:#9a3412;line-height:1.55;">
                            <strong>Catatan:</strong> file template di bawah ini berformat <code>.xlsx</code>.
                            Untuk file dengan <strong>lebih dari 3000 baris</strong>, kami sarankan
                            <strong>convert ke CSV terlebih dahulu</strong>
                            (<em>Excel → Save As → CSV</em>) agar import lebih cepat.
                        </div>
                    </div>

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
