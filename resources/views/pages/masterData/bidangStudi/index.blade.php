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
                                    <th>No.</th>
                                    <th class="text-center">Bidang Studi</th>
                                    <th class="text-center">Konsentrasi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="data-table">
                                @foreach ($data as $x => $v)
                                <tr data-id="{{ $v->id }}">
                                    <td>{{ $x + 1 }}</td>
                                    <td class="text-center">{{ $v->bidang_studi }}</td>
                                    <td>
                                        <ol>
                                            @foreach ($v->konsentrasi as $t)
                                            <li>{{ $t->konsentrasi }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-xs btnEdit" data-id="{{ $v->id }}" data-nama="{{ $v->bidang_studi }}" data-konsentrasi="{{ $v->konsentrasi->pluck('konsentrasi')->implode(',') }}">
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
                    {{--  --}}
                    <!-- Modal Form -->
                        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Bidang Studi</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formBidangStudi">
                                            <input type="hidden" id="bidang_id" name="id">
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
                </div>
            </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#btnAdd').click(function() {
            $('#modalForm').modal('show');
            $('#formBidangStudi')[0].reset();
            $('#bidang_id').val('');
        });
    
        $('.btnEdit').click(function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let konsentrasi = $(this).data('konsentrasi');
    
            $('#bidang_id').val(id);
            $('#bidang_studi').val(nama);
            $('#konsentrasi').val(konsentrasi);
            $('#modalForm').modal('show');
        });
    
        $('#formBidangStudi').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = $('#bidang_id').val() ? "{{ route('master.bidangStudi.update') }}" : "{{ route('master.bidangStudi.store') }}";
    
            $.post(url, formData, function(response) {
                location.reload();
            });
        });
    
        $('.btnDelete').click(function() {
            let id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus?')) {
                $.post("{{ route('master.bidangStudi.delete') }}", { id: id, _token: "{{ csrf_token() }}" }, function(response) {
                    location.reload();
                });
            }
        });
    });
</script>


@endsection
