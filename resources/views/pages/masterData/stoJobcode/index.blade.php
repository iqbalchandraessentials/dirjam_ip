@extends('master')

@section('title', 'Sto Jobcode | Direktori Jabatan')

@section('content')
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Sto Jobcode</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('export.stoJobcode') }}" class="btn btn-success">
                            <i class="ti-layout-grid4"></i><span class="ml-1"> Excell</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                {{-- Tab Content: Basic Info --}}
                <div class="row g-0">
                    <div class="col">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th> master_jabatan</th>
                                            <th> singkatan_jabatan</th>
                                            <th> singkatan_jabatan_clean</th>
                                            <th> jen_p21b</th>
                                            <th> jenjang</th>
                                            <th> direktorat</th>
                                            <th> divisi</th>
                                            <th> unit_nama</th>
                                            <th> location_code</th>
                                            <th> town_or_city</th>
                                            <th> jenis_pembangkit</th>
                                            <th> p22a</th>
                                            <th> nama_profesi</th>
                                            <th> kode_jabatan</th>
                                            <th> job_role</th>
                                            <th> re</th>
                                            <th> leveling</th>
                                            <th> structure</th>
                                            <th> nama_parent</th>
                                            <th> parent_name</th>
                                            <th> child_name</th>
                                            <th> nama_bawahan</th>
                                            <th> organization_desc</th>
                                            <th> fte</th>
                                            <th> pog_min</th>
                                            <th> pog_max</th>
                                            <th> max_person</th>
                                            <th> status</th>
                                            <th> valid_from</th>
                                            <th> valid_to</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
            ajax: "{{ route('master.stoJobcode') }}",
            columns: [
                { data:'master_jabatan'},
                { data:'singkatan_jabatan'},
                { data:'singkatan_jabatan_clean'},
                { data:'jen_p21b'},
                { data:'jenjang'},
                { data:'direktorat'},
                { data:'divisi'},
                { data:'unit_nama'},
                { data:'location_code'},
                { data:'town_or_city'},
                { data:'jenis_pembangkit'},
                { data:'p22a'},
                { data:'nama_profesi'},
                { data:'kode_jabatan'},
                { data:'job_role'},
                { data:'re'},
                { data:'leveling'},
                { data:'structure'},
                { data:'nama_parent'},
                { data:'parent_name'},
                { data:'child_name'},
                { data:'nama_bawahan'},
                { data:'organization_desc'},
                { data:'fte'},
                { data:'pog_min'},
                { data:'pog_max'},
                { data:'max_persons'},
                { data:'status'},
                { data:'valid_from'},
                { data:'valid_to'}
            ]
        });
    });
</script>

    
@endsection