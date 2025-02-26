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
                                            <th>No</th>
                                            <th>Singkatan Jabatan</th>
                                            <th>Jenis Pembangkit</th>
                                            <th>Singkatan Jabatan Clean</th>
                                            <th>Kode Jabatan</th>
                                            <th>People Group ID</th>
                                            <th>Org ID</th>
                                            <th>Leveling</th>
                                            <th>Structure</th>
                                            <th>Person ID Parent</th>
                                            <th>Nama Parent</th>
                                            <th>NiPEG Parent</th>
                                            <th>Email Parent</th>
                                            <th>Path</th>
                                            <th>Parent Path</th>
                                            <th>Status</th>
                                            <th>ID</th>
                                            <th>Valid From</th>
                                            <th>Valid To</th>
                                            <th>Parent Name</th>
                                            <th>Parent Position ID</th>
                                            <th>Child Position ID</th>
                                            <th>Child Name</th>
                                            <th>Person ID Bawahan</th>
                                            <th>Nama Bawahan</th>
                                            <th>NiPEG Bawahan</th>
                                            <th>Email Bawahan</th>
                                            <th>Master Jabatan</th>
                                            <th>Organization ID</th>
                                            <th>Organization Desc</th>
                                            <th>Max Persons</th>
                                            <th>FTE</th>
                                            <th>Job ID</th>
                                            <th>Jenis Jabatan</th>
                                            <th>Jen P21B</th>
                                            <th>Jenjang</th>
                                            <th>Subordinate Position ID</th>
                                            <th>Flag Definitif</th>
                                            <th>Direktorat</th>
                                            <th>Divisi</th>
                                            <th>Location Code</th>
                                            <th>Town or City</th>
                                            <th>P22A</th>
                                            <th>POG Min</th>
                                            <th>POG Max</th>
                                            <th>Unit KD</th>
                                            <th>Unit KD Rev</th>
                                            <th>Unit Nama</th>
                                            <th>RE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data akan otomatis diisi oleh DataTables -->
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
                { data: null, render: (data, type, row, meta) => meta.row + 1 }, // No Urut
                { data: 'singkatan_jabatan' },
                { data: 'jenis_pembangkit' },
                { data: 'singkatan_jabatan_clean' },
                { data: 'kode_jabatan' },
                { data: 'people_group_id' },
                { data: 'org_id' },
                { data: 'leveling' },
                { data: 'structure' },
                { data: 'person_id_parent' },
                { data: 'nama_parent' },
                { data: 'nipeg_parent' },
                { data: 'email_parent' },
                { data: 'path' },
                { data: 'parent_path' },
                { data: 'status' },
                { data: 'id' },
                { data: 'valid_from' },
                { data: 'valid_to' },
                { data: 'parent_name' },
                { data: 'parent_position_id' },
                { data: 'child_position_id' },
                { data: 'child_name' },
                { data: 'person_id_bawahan' },
                { data: 'nama_bawahan' },
                { data: 'nipeg_bawahan' },
                { data: 'email_bawahan' },
                { data: 'master_jabatan' },
                { data: 'organization_id' },
                { data: 'organization_desc' },
                { data: 'max_persons' },
                { data: 'fte' },
                { data: 'job_id' },
                { data: 'jenis_jabatan' },
                { data: 'jen_p21b' },
                { data: 'jenjang' },
                { data: 'subordinate_position_id' },
                { data: 'flag_definitif' },
                { data: 'direktorat' },
                { data: 'divisi' },
                { data: 'location_code' },
                { data: 'town_or_city' },
                { data: 'p22a' },
                { data: 'pog_min' },
                { data: 'pog_max' },
                { data: 'unit_kd' },
                { data: 'unit_kd_rev' },
                { data: 'unit_nama' },
                { data: 're' }
            ]
        });
    });
    </script>
    
@endsection