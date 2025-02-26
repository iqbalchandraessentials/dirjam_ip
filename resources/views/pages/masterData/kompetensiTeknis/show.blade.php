@extends('master')

@section('title', 'Komptensi Teknis | ' . $data['kode'] )

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="table-resposive">
                        <table class="table">
                            <thead>
        
                    <tr>
                        <td> Kode </td> 
                        <td>:</td>
                        <td class="text-left">{{ $data['kode'] }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td class="text-left">{{ $data['nama'] }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td class="text-left">{{ $data['name'] }}</td>
                    </tr>
                </thead>
            </table>
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
                    <div class="col-12 text-right">
                        <button type="button" id="btnAdd" class="btn btn-info mb-3">
                            <i class="ti-plus" style="margin-right: 5px;"></i> Add
                        </button>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Level</th>
                                                <th class="text-center">Perilaku</th>
                                                <th class="">action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data->level as $x => $v)
                                                <tr>
                                                    <td class="text-center"> <span class="badge bg-dark"> {{ $v['level'] }} </span></td>
                                                    <td class="text-left">{{ $v['perilaku'] }}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-xs btnEdit"><i class="ti-pencil"></i></button>
                                                        <a href=" {{route('master.kompetensi.delete', $v['id'])}} " class="btn btn-danger btn-xs btnDelete"><i class="ti-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <!-- Modal -->
                    <div class="modal fade" id="modalKompetensi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Form Kompetensi Teknis</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formKompetensi" method="POST">
                                    @csrf
                                    <input type="hidden" id="kompetensi_id" name="id">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Kode Master</label>
                                            <input type="text" class="form-control" id="kode_master" name="kode_master" value="{{ $data['kode'] }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Level</label>
                                            <select class="form-control" id="level" name="level" required>
                                                <option value="">Pilih Level</option>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Perilaku</label>
                                            <textarea class="form-control" id="perilaku" name="perilaku" rows="4" required></textarea>
                                        </div>
                                        <input type="hidden" id="kode_master_level" name="kode_master_level">
                                        <input type="hidden" id="created_by" name="created_by" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                {{--  --}}

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
    $('#btnAdd').click(function () {
        $('#modalKompetensi').modal('show');
        $('#modalLabel').text('Tambah Kompetensi Teknis');
        $('#formKompetensi').attr('action', '{{ route("master.kompetensi.store") }}');
        $('#formKompetensi')[0].reset();
        $('#kompetensi_id').val('');
    });

    $('.btnEdit').click(function () {
        let row = $(this).closest('tr');
        let id = row.find('.btnEdit').data('id');
        let level = row.find('td:eq(0)').text().trim();
        let perilaku = row.find('td:eq(1)').text().trim();

        $('#modalKompetensi').modal('show');
        $('#modalLabel').text('Edit Kompetensi Teknis');
        $('#formKompetensi').attr('action', '{{ route("master.kompetensi.update") }}');
        $('#kompetensi_id').val(id);
        $('#level').val(level);
        $('#perilaku').val(perilaku);
        $('#kode_master_level').val("{{ $data['kode'] }}" + '.' + level);
    });

    $('#level').change(function () {
        let level = $(this).val();
        $('#kode_master_level').val("{{ $data['kode'] }}" + level);
    });
});

    </script>
@endsection
