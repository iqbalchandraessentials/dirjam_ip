@extends('master')

@section('title', 'Komptensi Teknis | ' . $data['kode'])

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
                    @include('components.notification')
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
                                                <td class="text-center"> <span class="badge bg-dark"> {{ $v['level'] }}
                                                    </span></td>
                                                <td class="text-left">{{ $v['perilaku'] }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-xs btnEdit"><i
                                                            class="ti-pencil"></i></button>
                                                    <a href=" {{ route('master.kompetensi.delete', $v['id']) }} "
                                                        class="btn btn-danger btn-xs btnDelete"><i class="ti-trash"></i></a>
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
                @include('pages.masterData.kompetensiTeknis.partial.modal')
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#btnAdd').click(function() {
                $('#modalKompetensi').modal('show');
                $('#modalLabel').text('Tambah Kompetensi Teknis');
                $('#formKompetensi').attr('action', '{{ route('master.kompetensi.store') }}');
                $('#formKompetensi')[0].reset();
                $('#kompetensi_id').val('');
            });

            $('.btnEdit').click(function() {
                let row = $(this).closest('tr');
                let id = row.find('.btnEdit').data('id');
                let level = row.find('td:eq(0)').text().trim();
                let perilaku = row.find('td:eq(1)').text().trim();

                $('#modalKompetensi').modal('show');
                $('#modalLabel').text('Edit Kompetensi Teknis');
                $('#formKompetensi').attr('action', '{{ route('master.kompetensi.update') }}');
                $('#kompetensi_id').val(id);
                $('#level').val(level);
                $('#perilaku').val(perilaku);
                $('#kode_master_level').val("{{ $data['kode'] }}" + '.' + level);
            });

            $('#level').change(function() {
                let level = $(this).val();
                $('#kode_master_level').val("{{ $data['kode'] }}" + level);
            });
        });
    </script>
@endsection
