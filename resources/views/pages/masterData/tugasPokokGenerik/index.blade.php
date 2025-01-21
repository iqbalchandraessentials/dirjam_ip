@extends('master')

@section('title', 'Tugas Pokok Generik | Direktori Jabatan')

@section('content')

    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Tugas Pokok Generik</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn btn-success text-white mb-3"
                        data-toggle="modal" data-target="#addModal" rel="noopener noreferrer">
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
                <div class="row g-0">
                    <div class="col">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-striped dataTables">
                                    <thead>
                                        <tr>
                                            <th class="text-Left">No.</th>
                                            <th class="text-center" width="40%">Aktivitas</th>
                                            <th class="text-center" width="30%">Output</th>
                                            <th class="text-center">Jenis jabatan</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x => $v)
                                            <tr>
                                                <td>{{ $x + 1 }}</td>
                                                <td>{{ $v['aktivitas'] }}</td>
                                                <td>{{ $v['output'] }}</td>
                                                <td>{{ $v['jenis_jabatan'] }}</td>
                                                <td class="text-center">
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-secondary btn-circle btn-xs" data-toggle="modal"
                                                        data-target="#editModal" data-id="{{ $v['id'] }}"
                                                        data-aktivitas="{{ $v['aktivitas'] }}"
                                                        data-output="{{ $v['output'] }}"
                                                        data-jenis="{{ $v['jenis_jabatan'] }}">
                                                        <i class="ti-pencil fa-lg"></i>
                                                    </button>

                                                    <!-- Tombol Delete -->
                                                    <button class="btn btn-secondary btn-circle btn-xs" data-toggle="modal"
                                                        data-target="#deleteModal" data-id="{{ $v['id'] }}">
                                                        <i class="ti-trash fa-lg"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Modal Tambah Data -->
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                                    aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('master.TugasPokokGenerikStore') }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" value="generik" name="jenis">
                                                    <div class="form-group">
                                                        <label for="jenis_jabatan">Jenis Jabatan</label>
                                                        <select class="form-control" style="width: 100%;" id="jenis_jabatan" name="jenis_jabatan" required>
                                                            <option selected disabled>Pilih</option>
                                                            <option value="struktural">Struktural</option>
                                                            <option value="fungsional">Fungsional</option>
                                                        </select>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <label for="aktivitas">Aktivitas</label>
                                                        <textarea rows="6" class="form-control text-left" id="aktivitas" name="aktivitas" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="output">Output</label>
                                                        <textarea  class="form-control text-left" id="output" name="output" required rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Edit Data -->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('master.TugasPokokGenerikUpdate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="edit-id" name="id">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" value="generik" name="jenis">
                                                    <div class="form-group">
                                                        <label for="jenis_jabatan">Jenis Jabatan</label>
                                                        <select class="form-control" style="width: 100%;" id="edit-jenis_jabatan" name="jenis_jabatan" required>
                                                            <option selected disabled>Pilih</option>
                                                            <option value="struktural">Struktural</option>
                                                            <option value="fungsional">Fungsional</option>
                                                        </select>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <label for="edit-aktivitas">Aktivitas</label>
                                                            <textarea rows="6" class="form-control" id="edit-aktivitas" name="aktivitas" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit-output">Output</label>
                                                        <textarea  class="form-control" id="edit-output" name="output" required rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Hapus Data -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('master.TugasPokokGenerikDestroy') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="delete-id" name="id">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

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
            // Modal Edit
            $('#editModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Tombol yang memicu modal
                const id = button.data('id'); // Ambil data-id
                const aktivitas = button.data('aktivitas'); // Ambil data-aktivitas
                const output = button.data('output'); // Ambil data-output
                const jenis = button.data('jenis'); // Ambil data-jenis

                // Isi nilai pada input di modal
                $(this).find('#edit-id').val(id);
                $(this).find('#edit-aktivitas').val(aktivitas);
                $(this).find('#edit-output').val(output);
                $(this).find('#edit-jenis_jabatan').val(jenis);
            });

            // Modal Delete
            $('#deleteModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Tombol yang memicu modal
                const id = button.data('id'); // Ambil data-id

                // Isi nilai pada input hidden di modal
                $(this).find('#delete-id').val(id);
            });
        });
    </script>
@endsection
