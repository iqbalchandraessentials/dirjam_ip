@extends('master')

@section('title', 'Master Bidang Studi | Direktori Jabatan')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-6 text-left">
                    <h4 class="box-title">Master Bidang Studi</h4>
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
                <table class="table table-striped dataTables">
                    <thead>
                        <tr>
                            {{-- <th>No.</th> --}}
                            <th class="text-center">Bidang Studi</th>
                            <th class="text-center">Konsentrasi</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="data-table">
                        @foreach ($data as $x => $v)
                            <tr data-id="{{ $v->bidang_studi_id }}">
                                {{-- <td>{{ $x + 1 }}</td> --}}
                                <td class="text-center">{{ $v->bidang_studi }}</td>
                                <td>
                                    <ol>
                                        @foreach ($v->konsentrasi as $t)
                                            <li>{{ $t->konsentrasi }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-xs btnEdit" 
                                        data-id="{{ $v->bidang_studi_id }}"
                                        data-nama="{{ $v->bidang_studi }}"
                                    {{--     data-konsentrasi="{{ $v->konsentrasi->pluck('konsentrasi')->implode(',') }}" --}}
                                        >
                                        <i class="ti-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger  btn-xs" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $v->bidang_studi_id }}">
                                        <i class="ti-trash fa-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{--  --}}
            <!-- Modal Form -->
         <!-- Modal Form -->
            <div class="modal fade" id="modalForm" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Form Bidang Studi</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="formBidangStudi" method="POST">
                                @csrf
                                <input type="hidden" id="bidang_id" name="id">
                                <input type="hidden" name="_method" id="formMethod" value="POST">

                                <div class="form-group">
                                    <label>Bidang Studi</label>
                                    <input type="text" class="form-control" id="bidang_studi" name="bidang_studi" required>
                                </div>
                                <div class="form-group">
                                    <label>Konsentrasi (Pisahkan dengan koma)</label>
                                    <input type="text" class="form-control" id="konsentrasi" name="konsentrasi">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{--  --}}
            <!-- Modal Hapus Data -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('master.bidangStudi.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" id="delete-id" name="id">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
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
                $('#btnAdd').click(function() {
                    $('#modalForm').modal('show');
                    $('#modalTitle').text('Tambah Bidang Studi');
                    $('#formBidangStudi').attr('action', "{{ route('master.bidangStudi.store') }}");
                    $('#formMethod').val('POST');
                    $('#formBidangStudi')[0].reset();
                });

                $('.btnEdit').click(function() {
                    $('#modalForm').modal('show');
                    $('#modalTitle').text('Edit Bidang Studi');
                    $('#formBidangStudi').attr('action', "{{ route('master.bidangStudi.update') }}");
                    let id = $(this).data('id');
                    let nama = $(this).data('nama');
                    $('#bidang_id').val(id);
                    $('#bidang_studi').val(nama);
                });

            // Hapus data
            $('#deleteModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                $(this).find('#delete-id').val(id);
            });
        });
    </script>


@endsection
