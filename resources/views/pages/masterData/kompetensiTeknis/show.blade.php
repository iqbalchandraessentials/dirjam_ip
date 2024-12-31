@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">
                            <table >
                                <thead>
                                    <tr>
                                        <td> Kode </td> 
                                        <td>:</td>
                                        <td class="text-left">{{ $data['kode'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td class="text-left">{{ $data['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Name</td>
                                        <td>:</td>
                                        <td class="text-left">{{ $data['name'] }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </h4>
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
                                                <th class="text-center">level</th>
                                                <th class="text-center">Perilaku</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data->level as $x => $v)
                                                <tr>
                                                    <td class="text-center">{{ $v['level'] }}</td>
                                                    <td class="text-left">{{ $v['perilaku'] }}</td>
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
