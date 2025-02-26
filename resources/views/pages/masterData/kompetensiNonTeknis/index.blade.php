@extends('master')

@section('title', 'Master Komptensi Non Teknis | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Kompetnsi Non Teknis</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('master.mapping-komptensi-non-teknis') }}" class="btn btn-info mb-3" rel="noopener noreferrer">
                                <i class="ti-eye me-1"></i> <span class="ml-1">Mapping</span>
                            </a>
                            <a href="{{ route('export.kompetensi_non_teknis') }}" class="btn btn-success">
                                <i class="ti-layout-grid4"></i><span class="ml-1">Excell</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif


                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif


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
                        <form action="{{ route('import.kompetensi_non_teknis') }}" method="POST"
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
                                    <table id="kompetensiTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Kode</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Singkatan</th>
                                                <th class="text-center">Jenis</th>
                                                <th class="text-center">Definisi</th>
                                            </tr>
                                        </thead>
                                    </table>                                    
                                </div>
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
    $(document).ready(function() {
        $('#kompetensiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.kompetensi-non-teknis') }}",
            columns: [
                { data: 'kode', name: 'kode', className: 'text-center' },
                { data: 'nama', name: 'nama', className: 'text-center' },
                { data: 'singkatan', name: 'singkatan' },
                { data: 'jenis', name: 'jenis' },
                { data: 'definisi', name: 'definisi' }
            ]
        });
    });
    </script>
@endsection