@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Pendidikan</h4>
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
                                    <th class="text-left">Pendidikan</th>
                                    <th class="text-center">Waktu Dibuat</th>
                                    <th class="text-center">Waktu Diubah</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sorting_1">1</td>
                                    <td>S1</td>
                                    <td>2016-01-19 14:31:09</td>
                                    <td>2016-01-19 14:31:09</td>
                                    <td><a  class="btn btn-warning btn-circle btn-xs  "><i
                                                class="ti-pencil fa-lg"></i></a> <a
                                            class="btn btn-danger btn-circle btn-xs  "><i
                                                class="ti-trash fa-lg"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
