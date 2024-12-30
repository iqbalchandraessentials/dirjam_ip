@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Masalah dan Kompleksitas Kerja</h4>
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
                                            <th class="text-center">Definisi</th>
                                            <th class="text-center">Jenis Jabatan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($masalahKompleksitasKerja as $x => $v)
                                            <tr>
                                                <td>{{ $x + 1 }}</td>
                                                <td>{{ $v['definisi'] }}</td>
                                                <td class="text-center">{{ $v['jenis_jabatan'] }}</td>
                                                
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

        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Wewenang Jabatan</h4>
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
                                            <th class="text-center">Definisi</th>
                                            <th class="text-center">Jenis Jabatan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($wewenangJabatan as $x => $v)
                                            <tr>
                                                <td>{{ $x + 1 }}</td>
                                                <td>{{ $v['definisi'] }}</td>
                                                <td class="text-center">{{ $v['jenis_jabatan'] }}</td>
                                                
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

        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="box-title">Kemampuan dan Pengalaman</h4>
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
                                            <th class="text-center">Definisi</th>
                                            <th class="text-center">Jenis Jabatan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($kemampuandanPengalaman as $x => $v)
                                            <tr>
                                                <td>{{ $x + 1 }}</td>
                                                <td>{{ $v['definisi'] }}</td>
                                                <td class="text-center">{{ $v['jenis_jabatan'] }}</td>
                                                
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

@endsection