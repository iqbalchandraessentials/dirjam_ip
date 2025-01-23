@extends('master')

@section('title', 'Mapping Kompetensi Non Teknis')

@section('content')
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Mapping Komptensi Non Teknis</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('export.MappingKompetensiNonTeknis') }}" class="btn btn-secondary">
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
                        <form action="{{ route('import.mappingKompetensiNonTeknis') }}" method="POST"
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
                                            <th class="text-center">Master Jabatan</th>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">Komptensi</th>
                                            <th class="text-center">Kategori</th>
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

    @section('script')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master.mappingkomptensiNonTeknis') }}",
                columns: [
                    { data: 'master_jabatan', name: 'master_jabatan' },
                    { data: 'kode', name: 'kode', className: 'text-center' },
                    { data: 'nama_kompetensi', name: 'detail.nama', className: 'text-center' },
                    { data: 'kategori', name: 'kategori', className: 'text-center' },
                    { data: 'jenis', name: 'jenis', className: 'text-center' },
                ],
            });
        });
    </script>
    @endsection


@endsection