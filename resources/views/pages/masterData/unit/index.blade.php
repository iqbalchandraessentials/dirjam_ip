@extends('master')

@section('title', 'Master Unit | Direktori Jabatan')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Master Unit</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Direktorat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $x => $v)
                                    <tr>
                                        <td class="text-center">{{ $v['unit_kd'] }}</td>
                                        <td class="text-center">{{ $v['unit_nama'] }}</td>
                                        <td class="text-center">{{ $v['direktorat_desc'] }}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
