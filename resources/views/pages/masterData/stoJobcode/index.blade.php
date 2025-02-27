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
                                            <th> KODE_JABATAN </th>
                                            <th> JOB_ROLE </th>
                                            <th> LEVELING </th>
                                            <th> STRUCTURE </th>
                                            <th> PERSON_ID_PARENT </th>
                                            <th> NAMA_PARENT </th>
                                            <th> NIPEG_PARENT </th>
                                            <th> EMAIL_PARENT </th>
                                            <th> PATH </th>
                                            <th> PARENT_PATH </th>
                                            <th> STATUS </th>
                                            <th> ID </th>
                                            <th> VALID_FROM </th>
                                            <th> VALID_TO </th>
                                            <th> PARENT_NAME </th>
                                            <th> PARENT_POSITION_ID </th>
                                            <th> CHILD_POSITION_ID </th>
                                            <th> CHILD_NAME </th>
                                            <th> PERSON_ID_BAWAHAN </th>
                                            <th> NAMA_BAWAHAN </th>
                                            <th> NIPEG_BAWAHAN </th>
                                            <th> EMAIL_BAWAHAN </th>
                                            <th> MASTER_JABATAN </th>
                                            <th> ORGANIZATION_ID </th>
                                            <th> ORGANIZATION_DESC </th>
                                            <th> MAX_PERSONS </th>
                                            <th> FTE </th>
                                            <th> JOB_ID </th>
                                            <th> JENIS_JABATAN </th>
                                            <th> JEN_P21B </th>
                                            <th> JENJANG </th>
                                            <th> SUBORDINATE_POSITION_ID </th>
                                            <th> FLAG_DEFINITIF </th>
                                            <th> DIREKTORAT </th>
                                            <th> DIVISI </th>
                                            <th> LOCATION_CODE </th>
                                            <th> TOWN_OR_CITY </th>
                                            <th> P22A </th>
                                            <th> POHON_BISNIS </th>
                                            <th> POHON_PROFESI </th>
                                            <th> DAHAN_PROFESI </th>
                                            <th> KODE_NAMA_PROFESI </th>
                                            <th> NAMA_PROFESI </th>
                                            <th> nama_profesi2 </th>
                                            <th> POG_MIN </th>
                                            <th> POG_MAX </th>
                                            <th> SINGKATAN_JABATAN </th>
                                            <th> JENIS_PEMBANGKIT </th>
                                            <th> SINGKATAN_JABATAN_CLEAN </th>
                                            <th> UNIT_KD </th>
                                            <th> UNIT_KD_REV </th>
                                            <th> UNIT_NAMA </th>
                                            <th> RE </th>
                                            <th> PEOPLE_GROUP_ID </th>
                                            <th> ORG_ID </th>
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
                // { data: null, render: (data, type, row, meta) => meta.row + 1 },
                { data:'kode_jabatan' },
                { data:'job_role' },
                { data:'leveling' },
                { data:'structure' },
                { data:'person_id_parent' },
                { data:'nama_parent' },
                { data:'nipeg_parent' },
                { data:'email_parent' },
                { data:'path' },
                { data:'parent_path' },
                { data:'status' },
                { data:'id' },
                { data:'valid_from' },
                { data:'valid_to' },
                { data:'parent_name' },
                { data:'parent_position_id' },
                { data:'child_position_id' },
                { data:'child_name' },
                { data:'person_id_bawahan' },
                { data:'nama_bawahan' },
                { data:'nipeg_bawahan' },
                { data:'email_bawahan' },
                { data:'master_jabatan' },
                { data:'organization_id' },
                { data:'organization_desc' },
                { data:'max_persons' },
                { data:'fte' },
                { data:'job_id' },
                { data:'jenis_jabatan' },
                { data:'jen_p21b' },
                { data:'jenjang' },
                { data:'subordinate_position_id' },
                { data:'flag_definitif' },
                { data:'direktorat' },
                { data:'divisi' },
                { data:'location_code' },
                { data:'town_or_city' },
                { data:'p22a' },
                { data:'pohon_bisnis' },
                { data:'pohon_profesi' },
                { data:'dahan_profesi' },
                { data:'kode_nama_profesi' },
                { data:'nama_profesi' },
                { data:'nama_profesi2' },
                { data:'pog_min' },
                { data:'pog_max' },
                { data:'singkatan_jabatan' },
                { data:'jenis_pembangkit' },
                { data:'singkatan_jabatan_clean' },
                { data:'unit_kd' },
                { data:'unit_kd_rev' },
                { data:'unit_nama' },
                { data:'re' },
                { data:'people_group_id' },
                { data:'org_id' }
            ]
        });
    });
    </script>
    
@endsection