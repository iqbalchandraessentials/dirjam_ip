@extends('master')

@section('title', 'Draft Jabatan | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">DRAFT: {{ $data->nama }}</h4>
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
                                                <th class="text-Left">No.</th>
                                                <th class="text-Left">created_at</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                             $no = 2;   
                                            @endphp
                                            <tr>
                                                <td>1</td>
                                                <td></td>
                                                <td>
                                                    <a href="{{ route('template_jabatan.show', ['encoded_name' => $encodedName, 'unit_kd' => $unit])}}">
                                                        {{$data->nama}}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('export.template_jabatan_Excel', ['encoded_name' => $encodedName, 'unit_kd' => $unit]) }}"><i class="ti-layout-grid4"></i></a>
                                                    <a href="{{ route('export.template_jabatan_PDF', ['encoded_name' => $encodedName, 'unit_kd' => $unit]) }}"><i class="ti-printer"></i></a>
                                                </td>
                                            </tr>
                                            @foreach ($data->draftUraianMasterJabatan as $v)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>{{ $v['created_at'] ?? '' }}</td>
                                                    <td>
                                                         <a href="{{ route('template_jabatan.show', ['encoded_name' => $encodedName, 'unit_kd' => $unit, 'id' => $v->id]) }}"> 
                                                        {{ $v['nama'] }}
                                                         </a> 
                                                    </td>
                                                    <td class="text-center">
                                                         <a href="{{ route('export.template_jabatan_Excel', ['encoded_name' => $encodedName, 'unit_kd' => $unit, 'id' => $v->id]) }}"><i class="ti-layout-grid4"></i></a>
                                                        <a href="{{ route('export.template_jabatan_PDF', ['encoded_name' => $encodedName, 'unit_kd' => $unit, 'id' => $v->id]) }}"><i class="ti-printer"></i></a> 
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
