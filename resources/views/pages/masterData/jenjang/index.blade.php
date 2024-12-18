@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Jenjang</h4>
                        </div>
                        <div class="col-6 text-left">
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
                                    <th class="text-left">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Level</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center">Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sorting_1">2</td>
                                    <td>PS</td>
                                    <td>Pelaksana Senior</td>
                                    <td>BS</td>
                                    <td></td>
                                    <td></td>
                                    <td><a class="btn btn-warning btn-circle btn-xs  ">
                                        <i class="ti-pencil"></i>
                                    </a>
                                 </td>
                                </tr>
                                <tr>
                                    <td class="sorting_1">3</td>
                                    <td>PD</td>
                                    <td>Penyelia Dasar</td>
                                    <td>SP</td>
                                    <td></td>
                                    <td></td>
                                    <td><a class="btn btn-warning btn-circle btn-xs  ">
                                        <i class="ti-pencil"></i>
                                    </a>
                                 </td>
                                </tr>
                                <tr>
                                    <td class="sorting_1">4</td>
                                    <td>PA</td>
                                    <td>Penyelia Atas</td>
                                    <td>SY</td>
                                    <td></td>
                                    <td></td>
                                    <td><a class="btn btn-warning btn-circle btn-xs  ">
                                        <i class="ti-pencil"></i>
                                    </a>
                                 </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
