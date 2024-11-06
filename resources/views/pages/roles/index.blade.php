@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List of Role</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm"
                                                style="padding: 5px 10px; display: inline-flex; align-items: center;">
                                                <i class="ti-pencil" style="margin-right: 5px;"></i>
                                            </a>

                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    style="padding: 5px 10px; display: inline-flex; align-items: center;"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="ti-trash" style="margin-right: 5px;"></i> 
                                                </button>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
{{--  --}}

<div class="col-sm-12 col-lg-6">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-6 text-left">
                    <h4 class="box-title">List of Permission</h4>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped dataTables">
                    <thead>
                        <tr>
                            <th>Permission Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('permissions.edit', $role->id) }}"
                                        class="btn btn-warning btn-sm"
                                        style="padding: 5px 10px; display: inline-flex; align-items: center;">
                                        <i class="ti-pencil" style="margin-right: 5px;"></i>
                                    </a>

                                    <form action="{{ route('permissions.destroy', $role->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            style="padding: 5px 10px; display: inline-flex; align-items: center;"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="ti-trash" style="margin-right: 5px;"></i> 
                                        </button>
                                    </form>
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
