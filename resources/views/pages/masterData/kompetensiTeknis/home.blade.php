@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Master Kompetnsi Teknis</h4>
                        </div>
                    </div>
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
                                                <th class="text-center">Kode</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Name</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data as $x => $v)
                                                <tr>
                                                    <td>{{ $x + 1 }}</td>
                                                    <td class="text-center">
                                                    <a href="{{route('master.detailMasterKompetensiTeknis', $v['id'])}}">
                                                        {{ $v['kode'] }}
                                                    </a>    
                                                    </td>
                                                    <td class="text-center">{{ $v['nama'] }}</td>
                                                    <td class="text-center">{{ $v['name'] }}</td>
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