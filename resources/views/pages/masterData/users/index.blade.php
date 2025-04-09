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
                        {{-- <a class="btn btn-info text-white mb-3" href="{{route('roles.index')}}">
                            <i class="ti-eye me-1"></i><span class="ml-1">Roles</span>
                        </a> --}}
                        <a class="btn btn-primary text-white mb-3" href="{{url('master_data/tambah-roles')}}">
                            <i class="ti-plus me-1"></i><span class="ml-1">Add</span>
                        </a>
                        {{-- <a class="btn btn-primary text-white mb-3" data-toggle="modal" data-target="#addModal"
                            rel="noopener noreferrer">
                            <i class="ti-plus me-1"></i><span class="ml-1"> Add</span>
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="box-body">

                @include('components.notification')
                <table class="table table-bordered table-striped dataTables">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Roles</th>
                            {{-- <th style="width: 350px;">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)


                        <tr>
                            <td class="text-capitalize"> 
                                {{$user->nama_lengkap}}
                            </td>
                            <td> {{$user->unit_id}} </td>
                            <td> {{$user->role}} </td>
                        </tr>

                            {{-- <tr>
                                <td class="text-uppercase"> 
                                    <a href="#" class="edit-user-btn"
                                        data-user="{{ json_encode($user) }}">{{ $user->name }}</a>
                                </td>
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
                                                <button type="submit" class="btn btn-primary btn-sm ml-1">Assign</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr> --}}
                        @endforeach
                    </tbody>
                </table>
               {{-- @include('pages.masterData.users.partial.modal') --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script>
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

            // edit
            $('.edit-user-btn').click(function() {
                let user = $(this).data('user');

                $('#edit_user_id').val(user.id); // Menggunakan ID asli user untuk update
                $('#edit_name').val(user.name);
                $('#edit_userId').val(user.user_id); // User ID tetap sebagai username
                $('#edit_email').val(user.email);
                $('#edit_unit_kd').val(user.unit_kd);

                $('#editUserModal').modal('show');
            });
        });
    </script> --}}
@endsection
