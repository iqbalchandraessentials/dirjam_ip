@extends('master')

@section('title', 'User Management | Direktori Jabatan')

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">User Management</h4>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn-success mb-3">
                            <i class="ti-plus" style="margin-right: 5px;"></i> Add
                        </button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <table class="table table-bordered table-striped dataTables">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Roles</th>
                            <th style="width: 350px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->unit_kd }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>
                                <td>
                                    <!-- Assign Role Form -->
                                    <div class="d-inline-block me-2" style="width: 100%;">
                                        <form action="{{ route('users.assignRole', $user->id) }}" method="POST"
                                            class="assign-role-form">
                                            @csrf
                                            <div class="input-group">
                                                <!-- Tambahkan kelas w-100 untuk lebar penuh -->
                                                <select name="role" class="form-select" style="width: 250px" required>
                                                    <option value="" disabled selected >Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-secondary btn-sm ml-1">Assign</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Submit form with confirmation for Assign Role
            $('.assign-role-form').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to assign this role?')) {
                    this.submit();
                }
            });

            // Submit form with confirmation for Assign Permission
            $('.assign-permission-form').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to assign this permission?')) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
