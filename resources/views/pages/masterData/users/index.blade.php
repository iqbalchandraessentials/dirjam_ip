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
                        <!-- Button trigger modal -->
                        <a class="btn btn-success text-white mb-3" data-toggle="modal" data-target="#addModal"
                            rel="noopener noreferrer">
                            <i class="ti-plus me-1"></i><span class="ml-1"> Add</span>
                        </a>
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
                                                    <option value="" disabled selected>Select Role</option>
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
                <!-- Modal Tambah Data -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="user_id" class="form-label">User Id</label>
                                        <input type="text" class="form-control" id="user_id" name="user_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit">Unit</label>
                                        <select style="width: 100%;" class="form-control select2" name="unit">
                                            @foreach ($unit as $unit)
                                                <option value="{{ $unit->unit_kd }}">
                                                    {{ $unit->unit_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
