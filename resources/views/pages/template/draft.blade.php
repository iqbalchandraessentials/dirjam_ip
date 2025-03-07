@extends('master')

@section('title', 'Draft Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">DRAFT OF {{ $data->nama }}</h4>
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
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1; // Mulai nomor dari 1
                                            @endphp
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">
                                                    <a href="{{ route('template_jabatan.show', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => 'old']) }}">
                                                        {{ $data->nama }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('export.template_jabatan_Excel', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => 'old']) }}" class="btn btn-xs btn-info"><i class="ti-layout-grid4"></i></a>
                                                    <a href="{{ route('export.template_jabatan_PDF', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => 'old']) }}" class="btn btn-xs btn-success"><i class="ti-printer"></i></a>
                                                </td>
                                            </tr>
                                            @foreach ($data->draftUraianMasterJabatan as $v)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($v->created_at)->format('d-m-Y') }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('template_jabatan.show', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => $v->id]) }}">
                                                            {{ $v->nama }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('export.template_jabatan_Excel', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => $v->id]) }}" class="btn btn-xs btn-info"><i class="fa fa-table"></i></a>
                                                        <a href="{{ route('export.template_jabatan_PDF', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd, 'id' => $v->id]) }}" class="btn btn-xs btn-success"><i class="ti-printer"></i></a>
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
