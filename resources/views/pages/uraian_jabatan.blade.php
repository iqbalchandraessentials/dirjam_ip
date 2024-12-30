@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List Uraian Jabatan </h4>
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
                        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <label for="file">Upload Excel File:</label>
                        <input type="file" name="file" id="file" required>
                        <button type="submit" class="btn border-t-orange-400 btn-sm">Import</button>
                    </form>
                </div>


                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-Left">No.</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data as $x => $v)
                                    <tr>
                                        <td>{{ $x + 1 }}</td>
                                        <td>
                                            <a href="{{ route('uraian_jabatan.show', $v->uraianMasterJabatan->id) }}" title="View Detail">
                                                {{ $v['nama'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('export.pdf', $v->uraianMasterJabatan->id) }}"><i class="ti-printer"></i></a>
                                            <a href="{{route('uraianJabatan.draft', $v->id)}}" class="ml-3"> <i class="ti-view-list-alt"></i></a>
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

@endsection
