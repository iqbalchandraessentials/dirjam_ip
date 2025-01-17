@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Pendidikan</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-success mb-3">
                                <i class="ti-plus" style="margin-right: 5px;"></i> Add Data
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-Left">No.</th>
                                    <th class="text-left">Pendidikan</th>
                                    <th class="text-center">Pengalaman</th>
                                    <th class="text-center">Jenjang Jabtan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $x => $v)
                                <tr>
                                    <td>{{ $x + 1 }}</td>
                                    <td>{{$v->nama}}</td>
                                    <td class="text-center">{{$v->pengalaman}}</td>
                                    <td class="text-center">{{$v->jenjang_jabatan}}</td>
                                    <td class="text-center">
                                        <a  class="btn btn-secondary btn-circle btn-xs  "><i
                                                class="ti-pencil fa-lg"></i></a> <a
                                            class="btn text-white btn-secondary btn-circle btn-xs  "><i
                                                class="ti-trash fa-lg"></i></a></td>
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
