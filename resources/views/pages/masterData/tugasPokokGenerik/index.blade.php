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
                        <a class="btn btn-info text-white mb-3"
                        data-toggle="modal" data-target="#addModal" rel="noopener noreferrer">
                            <i class="ti-plus me-1"></i><span class="ml-1"> Add</span>
                        </a>
                    </div>

                </div>
            </div>
            <div class="box-body">
                @include('components.notification')
                <div class="row g-0">
                    <div class="col">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-striped dataTables">
                                    <thead>
                                        <tr>
                                            {{-- <th class="text-Left">No.</th> --}}
                                            <th class="text-center" width="40%">Aktivitas</th>
                                            <th class="text-center" width="30%">Output</th>
                                            <th class="text-center">Jenis jabatan</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x => $v)
                                            <tr>
                                                {{-- <td>{{ $x + 1 }}</td> --}}
                                                <td>{{ $v['aktivitas'] }}</td>
                                                <td>{{ $v['output'] }}</td>
                                                <td>{{ $v['jenis_jabatan'] }}</td>
                                                <td class="text-center">
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-primary  btn-xs" data-toggle="modal"
                                                        data-target="#editModal" data-id="{{ $v['id'] }}"
                                                        data-aktivitas="{{ $v['aktivitas'] }}"
                                                        data-output="{{ $v['output'] }}"
                                                        data-jenis="{{ $v['jenis_jabatan'] }}">
                                                        <i class="ti-pencil fa-lg"></i>
                                                    </button>
                                                    <!-- Tombol Delete -->
                                                    <button class="btn btn-danger  btn-xs" data-toggle="modal"
                                                        data-target="#deleteModal" data-id="{{ $v['id'] }}">
                                                        <i class="ti-trash fa-lg"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('pages.masterData.tugasPokokGenerik.partial.modal')
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
            $('#editModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); 
                const id = button.data('id'); 
                const aktivitas = button.data('aktivitas'); 
                const output = button.data('output'); 
                const jenis = button.data('jenis'); 
                $(this).find('#edit-id').val(id);
                $(this).find('#edit-aktivitas').val(aktivitas);
                $(this).find('#edit-output').val(output);
                $(this).find('#edit-jenis_jabatan').val(jenis);
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); 
                const id = button.data('id');                 
                $(this).find('#delete-id').val(id);
            });
        });
    </script>
@endsection
