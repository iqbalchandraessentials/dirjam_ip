@extends('master')

@section('title', 'Tambah Hak Akses | Direktori Jabatan')

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Tambah Hak Akses</h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                @include('components.notification')

                <!-- Blade Template HTML + AJAX + Modal -->
                <form class="form-inline" id="ldap-search-form">
                    <label class="sr-only" for="user">Name</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="user" name="user"
                        placeholder="Masukan Nama">
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>

                <div id="ldap-results" class="mt-4"></div>

                <!-- Bootstrap Modal -->
                <div class="modal fade" id="assignRoleModal" tabindex="-1" role="dialog"
                    aria-labelledby="assignRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form method="POST" class="form-horizontal" action="{{ route('users.store') }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Assign Role</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Photo</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="photo"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">NIPEG</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="nip"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="nama"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Jabatan</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="jabatan"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="email"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Unit</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="unit"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Departemen</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" id="department"></p>
                                        </div>
                                    </div>

                                    <hr />

                                    {{-- <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Unit</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2" name="unit" style="width: 100%">
                                                @foreach ($unit as $u)
                                                    <option value="{{ $u->UNIT_ID }}">{{ $u->UNIT_NAMA }}
                                                        ({{ $u->UNIT_KD }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Hak Akses</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="hak_akses" style="width: 100%">
                                                <option value="readonly">Read Only</option>
                                                <option value="admins">Super Admin</option>
                                                <option value="amu">Pengelola SDM HO</option>
                                                <option value="admin_unit">Pengelola SDM Unit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" id="userid" name="userid">
                                    <input type="hidden" id="name" name="name">
                                    <input type="hidden" id="nipeg" name="nipeg">
                                    <input type="hidden" id="email2" name="email">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
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
            $('#ldap-search-form').on('submit', function(e) {
                e.preventDefault();
                let user = $('#user').val();
                if (!user) return;

                $.ajax({
                    url: `/api/get-data-ldap/${encodeURIComponent(user)}`,
                    method: 'GET',
                    success: function(data) {
                        $('#ldap-results').empty();
                        if (data.result) {
                            for (let i = 0; i <= data.count; i++) {
                                const d = data[i];
                                const item = $(
                                    `<table class="table"><tbody><tr><td style="width:80px; vertical-align:top">
                                <img src="${d.photo}" alt="" class="img-thumbnail"></td>
                                <td><h4 class="nama" style="margin: 0; text-transform: capitalize; cursor:pointer" userid="${d.user_id}">${d.nama}</h4>
                                <small><span class="jabatan">${d.jabatan}</span><br>
                                <span class="department">${d.department}</span><br>
                                <span class="unit">${d.ou}</span><br>
                                <span class="nip" style="display:none">${d.nip}</span>
                                <span class="email">${d.mail}</span></small></td></tr></tbody></table>`
                                );
                                item.find('h4.nama').click(function() {
                                    $('#assignRoleModal').modal('show');
                                    $('#photo').html(
                                        `<img src='${d.photo}' class='img-thumbnail' style='width:80px'>`
                                        );
                                    $('#nip').text(d.nip);
                                    $('#nama').text(d.nama);
                                    $('#jabatan').text(d.jabatan);
                                    $('#email').text(d.mail);
                                    $('#unit').text(d.ou);
                                    $('#department').text(d.department);

                                    $('#userid').val(d.user_id);
                                    $('#name').val(d.nama);
                                    $('#nipeg').val(d.nip);
                                    $('#email2').val(d.mail);
                                });
                                $('#ldap-results').append(item);
                            }
                        } else {
                            $('#ldap-results').html('<p>Data tidak ditemukan.</p>');
                        }
                    },
                    error: function() {
                        $('#ldap-results').html('<p>Gagal mengambil data dari server.</p>');
                    }
                });
            });
        });
    </script>

@endsection
