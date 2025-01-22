@extends('master')

@section('title', 'Master Bidang Studi | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Bidang Studi</h4>
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
                                    <th class="text-left">Bidang Studi</th>
                                    <th class="text-center">Konsentrasi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Administrasi</td>
                                    <td>
                                        <ol style="font-size:smaller">
                                            <li>ADMINISTRASI BISNIS</li>
                                            <li>ADMINISTRASI BISNIS PERKANTORAN</li>
                                            <li>ADMINISTRASI LOGISTIK</li>
                                            <li>ADMINISTRASI NEGARA</li>
                                            <li>ADMINISTRASI NIAGA</li>
                                            <li>ADMINISTRASI NIAGA DAN KESEKRETARIATAN</li>
                                            <li>ADMINISTRASI PERKANTORAN</li>
                                            <li>ADMINISTRASI PERUSAHAAN</li>
                                            <li>ILMU ADMINISTRASI</li>
                                            <li>ILMU ADMINISTRASI BISNIS</li>
                                            <li>ILMU ADMINISTRASI NIAGA</li>
                                            <li>ILMU KESEKRETARIATAN</li>
                                            <li>KESEKRETARIATAN</li>
                                            <li>KESEKRETARIATAN DAN ADMINISTRASI PERKANTORAN</li>
                                            <li>SEKRETARI</li>
                                        </ol>
                                    </td>
                                    <td><a class="btn btn-warning btn-circle btn-xs ">
                                        <i class="ti-pencil"></i></a> 
                                        <a class="btn btn-danger btn-circle btn-xs  ">
                                            <i class="ti-trash"></i></a>
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
