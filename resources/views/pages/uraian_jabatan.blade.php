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
                               role="tab" aria-controls="basic-info" aria-selected="true">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="log-tab" data-toggle="tab" href="#log" 
                               role="tab" aria-controls="log" aria-selected="false">Attendance Log</a>
                        </li>
                    </ul>
                
                    <div class="tab-content" id="myTabContent">
                        {{-- Tab Content: Basic Info --}}
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataTables">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-left">Name</th>
                                                        <th class="text-center text-nowrap">Category</th>
                                                        <th class="text-left">Type</th>
                                                        <th class="text-left text-nowrap">Member</th>
                                                        <th class="text-left text-nowrap">Creator</th>
                                                        <th class="text-left text-nowrap">Last Post</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left text-nowrap">1</td>
                                                        <td class="text-center">Family</td>
                                                        <td class="text-center"> <span class="badge badge-primary"> Public </span></td>
                                                        <td class="text-center">23</td>
                                                        <td class="text-left">Will Smith</td>
                                                        <td class="text-left">23-05-2023</td>
                                                        <td class="text-left">23-05-2022</td>
                    
                                                        {{-- <td class="text-center">
                                                            <span data-toggle="modal" data-target="#modal-fill">
                                                                <i class="ti-eye"></i>
                                                            </span>
                                                        </td> --}}
                                                        <td class="text-center text-success">
                                                                <span class="btn btn-success btn-block btn-rounded">Active</span>
                                                            
                                                        </td>
                                                    </tr>
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
                                    <h1>Fitriani</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    @endsection
