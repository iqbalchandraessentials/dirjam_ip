@extends('master')

@section('title', 'Dimensi Finansial | Direktori Jabatan')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-6 text-left">
                    <h4 class="box-title">Mapping Nature OF Impact</h4>
                </div>
                <div class="col-6 text-right">
                    <button type="button" id="btnAdd" class="btn btn-success mb-3">
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
            <div class="table-responsive">
                <table class="table table-striped dataTables">
                    <thead>
                        <tr>
                            <th class="text-left">No.</th>
                            <th class="text-center">Kelompok Profesi</th>
                            <th class="text-center">Nama Profesi</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody id="data-table">
                        @foreach ($data as $x => $v)
                            <tr data-id="{{ $v->id }}">
                                <td>{{ $x + 1 }}</td>
                                <td class="text-center">{{ $v->kode_profesi }}</td>
                                <td class="text-center">{{ $v->namaProfesi->nama_profesi ?? $v->kode_profesi }}</td>
                                <td class="text-center">{{ $v->jenis }}</td>
                                <td class="text-right">
                                    <button class="btn btn-secondary btn-xs btnEdit" 
                                        data-id="{{ $v->id }}" 
                                        data-kode_profesi="{{ $v->kode_profesi }}" 
                                        data-jenis="{{ $v->jenis }}">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs btnDelete" data-id="{{ $v->id }}">
                                        <i class="ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Modal Create/Edit --}}
            <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="POST" id="formSave">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFormLabel">Tambah/Edit Indikator</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="kode_profesi">Kelompok Profesi</label>
                                <select class="form-control" name="kode_profesi" id="kode_profesi" required>
                                    <option selected disabled>Pilih</option>
                                    @foreach ($option as $v)
                                        <option value="{{ $v->kode_nama_profesi }}">({{ $v->kode_nama_profesi }}) {{$v->nama_profesi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select class="form-control" name="jenis" id="jenis" required>
                                    <option selected disabled>Pilih</option>
                                    <option value="Prime">Prime</option>
                                    <option value="Share">Share</option>
                                    <option value="Contributory">Contributory</option>
                                    <option value="Remote">Remote</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            <!-- Modal Delete -->
            <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('master.natureOfImpact.delete') }}" method="POST" id="formDelete">
                        @csrf
                        <input type="hidden" name="id" id="deleteId">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDeleteLabel">Hapus Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
       $(document).ready(function() {
            $('.select2').select2(); // Inisialisasi Select2

            // Tambah Data
            $('#btnAdd').click(function() {
                $('#formSave')[0].reset();
                $('#id').val('');
                $('#kode_profesi').val('').trigger('change');
                $('#jenis').val('');

                $('#formSave').attr('action', `{{ route('master.natureOfImpact.store') }}`);
                $('#modalFormLabel').text('Tambah Nature Of Impact');
                $('#modalForm').modal('show');
            });

            // Edit Data
            $(document).on('click', '.btnEdit', function() {
                let id = $(this).data('id');
                let kode_profesi = $(this).data('kode_profesi');
                let jenis = $(this).data('jenis');

                $('#id').val(id);
                $('#kode_profesi').val(kode_profesi).trigger('change'); // Pastikan Select2 update
                $('#jenis').val(jenis);

                $('#formSave').attr('action', `{{ route('master.natureOfImpact.update', ':id') }}`.replace(':id', id));
                $('#modalFormLabel').text('Edit Nature Of Impact');
                $('#modalForm').modal('show');
            });

      
            // Delete Data
            $(document).on('click', '.btnDelete', function() {
                let id = $(this).data('id');
                console.log('ID yang dikirim:', id); // Debugging
                $('#deleteId').val(id); // Isi input hidden dengan ID
                $('#modalDelete').modal('show');
            });
        });
    </script>


@endsection
