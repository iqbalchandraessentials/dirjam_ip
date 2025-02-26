@extends('master')

@section('title', 'Master Komptensi Teknis')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">

                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Kompetnsi Teknis</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('master.mapping-komptensi-teknis') }}" class="btn btn-info mb-3" rel="noopener noreferrer">
                                <i class="ti-eye me-1"></i><span class="ml-1"> Mapping</span>
                            </a>
                            <a href="{{ route('export.kompetensi_teknis') }}" class="btn btn-success">
                                <i class="ti-layout-grid4"></i><span class="ml-1"> Excell</span>
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
                        <form action="{{ route('import.kompetensi_teknis') }}" method="POST"
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
                                    <table id="dataTables" class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Kode</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diisi oleh DataTables melalui AJAX -->
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
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.kompetensi-teknis') }}",
            columns: [
                { data: 'kode', name: 'kode', className: 'text-center' },
                { data: 'nama', name: 'nama', className: 'text-center' },
                { data: 'name', name: 'name', className: 'text-center' }
            ],
            order: [[1, 'asc']], // Sortir berdasarkan kolom Nama secara default
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json" // Bahasa Indonesia (opsional)
            }
        });
    });
</script>

@endsection
