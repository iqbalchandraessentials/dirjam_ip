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
                    <button type="button" id="btnAdd" class="btn btn-info mb-3">
                        <i class="ti-plus" style="margin-right: 5px;"></i> Add
                    </button>
                </div>
            </div>
        </div>
        <div class="box-body">
            @include('components.notification')
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Kelompok Profesi</th>
                            <th class="text-center">Nama Profesi</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
         @include('pages.masterData.dimensiFinansial.partial.modal')
        </div>
    </div>
@endsection

@section('script')
    <script>
       $(document).ready(function() {

        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.getNatureOfImpact') }}",
            columns: [
                { data: 'kode_profesi', name: 'kode_profesi', className: "text-center" },
                { data: 'nama_profesi', name: 'nama_profesi', className: "text-center" },
                { data: 'jenis', name: 'jenis', className: "text-center" },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
            ]
        });

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
