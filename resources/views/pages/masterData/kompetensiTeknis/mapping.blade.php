@extends('master')

@section('title', 'Mapping Kompetensi Teknis')

@section('content')
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Mapping Kompetensi Teknis</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('export.mapping_kompetensi_teknis') }}" class="btn btn-success">
                            <i class="ti-layout-grid4"></i><span class="ml-1">Excell</span>
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
                    <div style="margin-bottom: 15px">
                        <form action="{{ route('import.mapping_kompetensi_teknis') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="file">Upload Excel File:</label>
                            <input type="file" name="file" id="file" required>
                            <button type="submit" class="btn border-t-orange-400 btn-sm">Import</button>
                        </form>
                    </div>
                {{-- Tab Content: Basic Info --}}
                <div class="row g-0">
                    <div class="col">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th class="text-left">No.</th> --}}
                                            <th class="text-center">Master Jabatan</th>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">Komptensi</th>
                                            <th class="text-center">Level</th>
                                            <th class="text-center">Jenis</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-uppercase">
                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.mapping-komptensi-teknis') }}",
        columns: [
            // { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Kolom index
            { data: 'master_jabatan', name: 'master_jabatan' },
            { data: 'kode', name: 'kode' },
            { data: 'master.nama', name: 'master.nama' },
            { data: 'level', name: 'level' },
            { data: 'kategori', name: 'kategori' },
        ],
    });
});

</script>
@endsection