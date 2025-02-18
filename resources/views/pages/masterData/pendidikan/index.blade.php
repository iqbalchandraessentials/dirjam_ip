@extends('master')

@section('title', 'Master Pendidikan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Pendidikan</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" id="btnCreate" class="btn btn-success mb-3">
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
                        <!-- Tabel Data -->
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">Jenjang Jabatan</th>
                                    <th class="text-center">Pendidikan</th>
                                    <th class="text-center">Pengalaman</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $data)
                                    <tr>
                                        <td class="text-center">{{ $data->jenjang_jabatan }}</td>
                                        <td class="text-center">{{ $data->nama }}</td>
                                        <td class="text-center">{{ $data->pengalaman }}</td>
                                        <td class="text-center">
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-secondary btn-circle btn-xs edit-btn"
                                                data-id="{{ $data->id }}" data-nama="{{ $data->nama }}"
                                                data-pengalaman="{{ $data->pengalaman }}"
                                                data-jenjang="{{ $data->jenjang_jabatan }}">
                                                <i class="ti-pencil fa-lg"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-secondary btn-circle btn-xs delete-btn"
                                                data-id="{{ $data->id }}" data-nama="{{ $data->nama }}">
                                                <i class="ti-trash fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @include('pages.masterData.pendidikan.partial.modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Handle Create Button
            $('#btnCreate').click(function() {
                $('#modalFormLabel').text('Tambah Data');
                $('#formSave').attr('action', '/master_data/pendidikan/create');
                $('#formSave')[0].reset();
                $('#dataId').val('');
                $('#modalForm').modal('show');
            });

            // Handle Edit Button
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const pengalaman = $(this).data('pengalaman');
                const jenjang = $(this).data('jenjang');

                $('#modalFormLabel').text('Edit Data');
                $('#formSave').attr('action', `/master_data/pendidikan/update`);
                $('#dataId').val(id);
                $('#nama').val(nama);
                $('#pengalaman').val(pengalaman);
                $('#jenjang_jabatan').val(jenjang);
                $('#modalForm').modal('show');
            });

            // Handle Delete Button
            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                $('#deleteNama').text(nama);
                $('#deleteId').val(id);
                $('#modalDelete').modal('show');
            });
        });
    </script>
@endsection
