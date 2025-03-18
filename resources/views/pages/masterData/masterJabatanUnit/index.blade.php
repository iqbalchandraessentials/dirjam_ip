@extends('master')

@section('title', 'Master Jabatan | Direktori Jabatan')

@section('content')
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">MASTER JABATAN</h4>
                    </div>
                    <div class="col-6 text-right">
                        {{-- <a href="{{ route('export.jabatan_unit') }}" class="btn btn-success">
                            <i class="ti-layout-grid4"></i><span class="ml-1"> Excell</span>
                        </a> --}}
                        <a href="{{ route('master.jabatan.form') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
            @include('components.notification')
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTables">
                        <thead>
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Singkatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.jabatan') }}",
            columns: [
                { data: 'master_jabatan', name: 'master_jabatan' },
                { data: 'singkatan_jabatan_clean', name: 'singkatan_jabatan_clean' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection