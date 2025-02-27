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
                    @include('components.notification')
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
                                            <button class="btn btn-primary btn-xs btnEdit"  data-id="{{ $v->id }}"  data-nama="{{ $v->nama }}"><i class="ti-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs btnDelete" data-id="{{ $v->id }}"><i class="ti-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       @include('pages.masterData.indikator.partial.modal')
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
            $('#formSave').attr('action', `{{ route('master.indikator.store') }}`); // Set action untuk tambah
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
            $('#formSave').attr('action', `{{ route('master.indikator.update') }}`); // Set action untuk update
            $('#modalFormLabel').text('Edit Indikator'); // Set judul modal
            $('#modalForm').modal('show'); // Tampilkan modal
        });
       // Delete Data
       $(document).on('click', '.btnDelete', function () {
            let id = $(this).data('id');
            console.log('ID yang dikirim:', id); // Debugging
            $('#deleteId').val(id); // Isi input hidden dengan ID
            $('#modalDelete').modal('show');
        });
    });
</script>


@endsection
