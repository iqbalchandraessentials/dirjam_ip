@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')
    <h2>User List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
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
@endsection
