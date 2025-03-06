@extends('master')

@section('title', 'Template Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List Template Jabatan </h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ asset('template/Template_import_dirjab.xlsx') }}"
                                class="btn btn-success text-white mb-3" download>
                                <i class="ti-eye me-1"></i><span class="ml-2">Template</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    @include('components.notification')
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                <li>Import data gagal !!</li>
                                @foreach ($errors->all() as $error)
                                    <li> error: {{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    {{-- @if (auth()->user()->hasRole(['SuperAdmin'])) --}}
                    <div style="margin-bottom: 15px">
                        <form action="{{ route('import.templateJabatan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="file">Upload Excel File:</label>
                            <input type="file" name="file" id="file" required>
                            <button type="submit" class="btn border-t-orange-400 btn-sm">Import</button>
                        </form>
                    </div>
                    <div style="margin-top: 40px;">
                        <form id="filterForm" method="GET" class="form-horizontal">
                            <div class="d-flex justify-content-center">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="unit" class="mr-3 mb-0">Unit:</label>
                                            <select class="form-control select2" name="unit" id="unitFilter">
                                                @if (isset($selectUnit))
                                                    <option selected disabled>{{ $selectUnit }}</option>
                                                @endif
                                                @foreach ($unitOptions as $unit)
                                                    <option value="{{ $unit->unit_kd }}"
                                                        {{ old('unit', request('unit')) == $unit->unit_kd ? 'selected' : '' }}>
                                                        ({{ $unit->unit_kd }})
                                                        {{ $unit->unit_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- @endif --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    {{-- <th class="text-left">No.</th> --}}
                                    <th class="text-left">Master Jabatan</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Jenjang</th>
                                    <th class="text-center">Action</th>
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

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('template_jabatan.filter') }}",
                    data: function(d) {
                        d.unit = $('#unitFilter').val() || "{{ Auth::user()->unit_kd }}";
                    }
                },
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'master_jabatan',
                        name: 'master_jabatan'
                    },
                    {
                        data: 'unit_kd',
                        name: 'unit_kd'
                    },
                    {
                        data: 'jen',
                        name: 'jen'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
            // Reload tabel ketika filter unit berubah
            $('#unitFilter').on('change', function() {
                table.ajax.reload();
            });

            // Submit form filter
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });
        });
    </script>
@endsection
