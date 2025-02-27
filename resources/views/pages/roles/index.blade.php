@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')


{{-- <div class="box">
    <div class="box-header">
        <div class="row">
            <div class="col-6 text-left">
                <h4 class="box-title">List of Users</h4>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped dataTables">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($user->getAllPermissions() as $permission)
                                    <span class="badge badge-secondary">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                    <i class="ti-pencil"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for Editing User Roles and Permissions -->
                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserLabel{{ $user->id }}">Edit Roles and Permissions for {{ $user->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('users.updateRolesPermissions', $user->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <!-- Role Selection -->
                                            <div class="form-group">
                                                <label for="roles">Roles</label>
                                                @foreach ($roles as $role)
                                                    <div class="form-check">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            name="roles[]" 
                                                            value="{{ $role->name }}" 
                                                            id="role-{{ $user->id }}-{{ $role->id }}" 
                                                            {{ $user->roles->contains($role) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="role-{{ $user->id }}-{{ $role->id }}">
                                                            {{ $role->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Permission Selection -->
                                            <div class="form-group">
                                                <label for="permissions">Permissions</label>
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            name="permissions[]" 
                                                            value="{{ $permission->name }}" 
                                                            id="permission-{{ $user->id }}-{{ $permission->id }}" 
                                                            {{ $user->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission-{{ $user->id }}-{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> --}}



    {{-- <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-6 text-left">
                    <h4 class="box-title">List of User</h4>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped dataTables">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Roles</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span>{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($user->permissions as $permission)
                                        <span>{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <!-- Assign Role Form -->
                                    <form action="{{ route('users.assignRole', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <select name="role" required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit">Assign Role</button>
                                    </form>
            
                                    <!-- Assign Permission Form -->
                                    <form action="{{ route('users.assignPermission', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <select name="permission" required>
                                            <option value="">Select Permission</option>
                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit">Assign Permission</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}


     <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List of Role</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#createRoleModal">
                                <i class="ti-plus" style="margin-right: 5px;"></i> Add Role
                            </button>                                                      
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    {{-- <th>Permissions</th> --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        {{-- <td>
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge badge-primary">{{ $permission->name }}</span>
                                            @endforeach
                                        </td> --}}
                                        <td>
                                            <!-- Edit button to add/remove permissions -->
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPermissionsModal{{ $role->id }}">
                                                <i class="ti-pencil"></i>
                                            </button>
                        
                                            <!-- Form to delete the role -->
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                        
                                    <!-- Modal for editing permissions -->
                                    {{-- <div class="modal fade" id="editPermissionsModal{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="editPermissionsLabel{{ $role->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPermissionsLabel{{ $role->id }}">Edit Permissions for {{ $role->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('roles.updatePermissions', $role->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                    
                                                        @foreach ($permissions as $permission)
                                                            <div class="form-check">
                                                                <input 
                                                                    class="form-check-input" 
                                                                    type="checkbox" 
                                                                    name="permissions[]" 
                                                                    value="{{ $permission->name }}"
                                                                    id="permission-{{ $role->id }}-{{ $permission->id }}"
                                                                    {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                                                <label 
                                                                    class="form-check-label" 
                                                                    for="permission-{{ $role->id }}-{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                    
                                                        <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createRoleLabel">Create New Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('roles.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <!-- Input for Role Name -->
                                    <div class="form-group">
                                        <label for="roleName">Role Name</label>
                                        <input type="text" name="name" id="roleName" class="form-control" placeholder="Enter role name" required>
                                    </div>
                
                                    <!-- Checkbox list for Permissions -->
                                    {{-- <div class="form-group">
                                        <label for="permissions">Assign Permissions</label>
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="permissions[]" 
                                                    value="{{ $permission->name }}" 
                                                    id="permission-{{ $permission->id }}">
                                                <label 
                                                    class="form-check-label" 
                                                    for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        {{--  --}}
        {{-- <div class="col-sm-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List of Permission</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#createPermissionModal">
                                <i class="ti-plus" style="margin-right: 5px;"></i> Add Permission
                            </button>                            
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
        </div> --}}
        {{-- <div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPermissionLabel">Create New Permission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="permissionName">Permission Name</label>
                                <input type="text" name="name" id="permissionName" class="form-control" placeholder="Enter permission name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
        
    </div>

    <script>
        $(document).ready(function () {
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('input[type="checkbox"]').prop('checked', function () {
                    return $(this).attr('checked') === 'checked';
                });
            });
        });

    </script>

@endsection
