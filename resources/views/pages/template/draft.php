@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

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

                                            @foreach ($data->draftUraianMasterJabatan as $x => $v)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td>{{ $v['created_at'] }}</td>
                                                    <td><a
                                                            href="{{ route('uraian_jabatan_template.show', $v->id) }}">{{ $v['nama'] }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('uraian_jabatan_template.export_excel', $v->id) }}"><i class="ti-layout-grid4"></i></a>
                                                        <a href="{{ route('uraian_jabatan_template.export_pdf', $v->id) }}"><i class="ti-printer"></i></a>
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
