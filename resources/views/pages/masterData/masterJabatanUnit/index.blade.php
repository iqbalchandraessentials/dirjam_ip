@extends('master')

@section('title', 'Master Jabatan dan Unit | Direktori Jabatan')

@section('content')
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Master Jabatan</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('export.jabatan_unit') }}" class="btn btn-success">
                            <i class="ti-layout-grid4"></i><span class="ml-1"> Excell</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row g-0">
                    <div class="col">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>                                
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
        $(document).ready(function () {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master.jabatan') }}", // Ganti dengan route ke fungsi `masterJabatan`
                columns: [
                    { data: 'master_jabatan', name: 'master_jabatan', className: 'text-capitalize' },
                    { data: 'unit_nama', name: 'unit_nama' }
                ],
            });
        });

    </script>
@endsection