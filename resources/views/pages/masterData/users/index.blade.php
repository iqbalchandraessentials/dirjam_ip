@extends('master')

@section('title', 'Hak Akses | Direktori Jabatan')

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Hak Akses</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn btn-primary text-white mb-3" href="{{url('master_data/tambah-roles')}}">
                            <i class="ti-plus me-1"></i><span class="ml-1">Add</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">

                @include('components.notification')
                <table class="table table-bordered table-striped dataTables">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            {{-- <th>Unit</th> --}}
                            <th>Roles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)


                        <tr>
                            <td class="text-capitalize"> 
                                {{$user->nama_lengkap}}
                            </td>
                            {{-- <td> {{$user->unit_id}} </td> --}}
                            <td> {{$user->role}} </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
