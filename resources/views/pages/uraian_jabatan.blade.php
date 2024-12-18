@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List Job Description</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info"
                                role="tab" aria-controls="basic-info" aria-selected="true">List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="log-tab" data-toggle="tab" href="#log" role="tab"
                                aria-controls="log" aria-selected="false">Summary</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        {{-- Tab Content: Basic Info --}}
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel"
                            aria-labelledby="basic-info-tab">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="box-body">
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label for="file">Upload Excel File:</label>
                                            <input type="file" name="file" id="file" required>
                                            <button type="submit">Import</button>
                                        </form>


                                        <div class="table-responsive">
                                            <table class="table table-striped dataTables">
                                                <thead>
                                                    <tr>
                                                        <th class="text-Left">No.</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-Left">action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $x => $v)
                                                    <td>{{$x+1}}</td>
                                                    <td>{{$v['nama']}}</td>
                                                    <td>
                                                        <a href="{{ route('uraian_jabatan.show', $v->id) }}" title="View Detail">  <i class="ti-eye"></i>
                                                        </a>
                                                    </td>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab Content: Attendance Log --}}
                        <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <h1>Summary</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
