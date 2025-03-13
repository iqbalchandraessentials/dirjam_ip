@extends('master')

@section('title', 'Draft Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">DRAFT OF {{ $master_jabatan }}</h4>
                </div>
                <div class="box-body">
                    {{-- Tab Content: Basic Info --}}
                    <div class="row g-0">
                        <div class="col">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped dataTables">
                                        <thead>
                                            <tr>
                                                <th class="text-left">No.</th>
                                                <th class="text-center">Created At</th>
                                                <th class="text-center">Dibuat Oleh</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1; 
                                                $encodedName = base64_encode($master_jabatan);
                                            @endphp
                                            @foreach ($data as $v)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('template_jabatan.show', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => $v->uraian_jabatan_id]) }}">
                                                            {{ \Carbon\Carbon::parse($v->waktu_dibuat)->format('d-m-Y') }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                            {{ $v->dibuat_oleh }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('export.template_jabatan_Excel', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => $v->uraian_jabatan_id]) }}" class="btn btn-xs btn-info"><i class="fa fa-table"></i></a>
                                                        <a href="{{ route('export.template_jabatan_PDF', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => $v->uraian_jabatan_id]) }}" class="btn btn-xs btn-success"><i class="ti-printer"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
