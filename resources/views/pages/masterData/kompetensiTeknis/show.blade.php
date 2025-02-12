@extends('master')

@section('title', 'Komptensi Teknis | ' . $data['kode'] )

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="table-resposive">
                        <table class="table">
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
                    </div>
                </div>
                <div class="box-body">
                    <div class="row g-0">
                        <div class="col">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Level</th>
                                                <th class="text-center">Perilaku</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data->level as $x => $v)
                                                <tr>
                                                    <td class="text-center"> <span class="badge bg-dark"> {{ $v['level'] }} </span></td>
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
