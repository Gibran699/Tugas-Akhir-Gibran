@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengaturan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Import Data</a></li>
            </ol>
        </div>

        <div class="col-xl-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Import Data</h4>
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
                                            {{ str_replace(['App\Imports\\', 'Import'], '', $value) }}</option>
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
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        // Generate options untuk tahun
        generateYearOptions('tahun');

        // Inisialisasi Select2 pada elemen dengan ID 'keteranganFile'
        $("#keteranganFile").select2();
    </script>
    <script src="{{ asset('js/system/import_data.js') }}"></script>
@endsection
