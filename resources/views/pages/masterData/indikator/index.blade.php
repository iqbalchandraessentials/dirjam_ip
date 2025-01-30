@extends('master')

@section('title', 'Master Indikator | Direktori Jabatan')

@section('content')
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Indikator dan Output</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" id="btnAdd" class="btn btn-success mb-3">
                                <i class="ti-plus" style="margin-right: 5px;"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-left">No.</th>
                                    <th class="text-center">Indikator dan Output</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="data-table">
                                @foreach ($data as $x => $v)
                                    <tr data-id="{{ $v->id }}">
                                        <td>{{ $x + 1 }}</td>
                                        <td class="text-center">{{ $v->nama }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-secondary btn-xs btnEdit"  data-id="{{ $v->id }}"  data-nama="{{ $v->nama }}"><i class="ti-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" id="btnDelete"><i class="ti-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                            <input type="hidden" id="indikatorId" name="id">
                                            <div class="form-group">
                                                <label for="nama">Nama Indikator</label>
                                                <input type="text" class="form-control" id="nama" name="nama" required>
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
                        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="POST" id="formDelete">
                                    @csrf
                                    @method('DELETE')
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

            </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Tambah Data
        $('#btnAdd').click(function () {
            $('#formSave')[0].reset(); // Reset form
            $('#indikatorId').val(''); // Reset ID indikator
            $('#formSave').attr('action', `{{ route('master.storeIndikator') }}`); // Set action untuk tambah
            $('#modalFormLabel').text('Tambah Indikator'); // Set judul modal
            $('#modalForm').modal('show'); // Tampilkan modal
        });

        // Edit Data
        $(document).on('click', '.btnEdit', function () {
            // Ambil data dari atribut data-* di tombol
            let id = $(this).data('id');
            let nama = $(this).data('nama');

            // Isi data ke form
            $('#indikatorId').val(id); // Isi input hidden dengan ID indikator
            $('#nama').val(nama); // Isi input nama dengan data dari atribut
            $('#formSave').attr('action', `{{ route('master.updateIndikator') }}`); // Set action untuk update
            $('#modalFormLabel').text('Edit Indikator'); // Set judul modal
            $('#modalForm').modal('show'); // Tampilkan modal
        });

        


        // Delete Data
        $('#btnDelete').click(function () {
            let id = $(this).closest('tr').data('id');
            $('#formDelete').attr('action', `{{ url('master_data/indikator') }}/${id}`);
            $('#modalDelete').modal('show');
        });
    });
</script>


@endsection
