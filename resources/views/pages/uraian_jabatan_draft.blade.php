@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List draft of <br> {{$data->nama}}</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                        {{-- Tab Content: Basic Info --}}
                            <div class="row g-0">
                                <div class="col">
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataTables">
                                                <thead>
                                                    <tr>
                                                        <th class="text-Left">No.</th>
                                                        <th class="text-Left">created_at</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($data->draftUraianMasterJabatan as $x => $v)
                                                    <tr>
                                                        <td>{{$x+1}}</td>
                                                        <td>{{$v['created_at']}}</td>
                                                        <a href="{{ route('uraian_jabatan.show', $v->id) }}" title="View Detail"> </a>
                                                        <td>{{$v['nama']}}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('export.pdf', $v->id) }}" ><i class="ti-printer"></i></a>
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

@endsection
