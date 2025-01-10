@extends('master')

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List Uraian Jabatan </h4>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th>Path</th>
                                    <th>Jabatan</th>
                                    <th>Klaster</th>
                                    <th>Direktorat</th>
                                    <th>Unit</th>
                                    <th>Jenjang</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jabatans as $key)
                                    @php
                                        $jab = str_replace(' ', '&nbsp;', $key->hierarchy);
                                        $a = str_repeat('&nbsp;', $key->leveling * 10);
                                        $mj = "$a&nbsp;($key->master_jabatan <small>$key->position_id</small>)";
                        
                                        $param = request()->getQueryString();
                                        $link = $key->status === '-' 
                                            ? url("uraian_jabatan",$key->position_id) 
                                            : url("uraian_jabatan",$key->uraian_jabatan_id);
                                        $link2 = $key->status === '-' 
                                            ? '' 
                                            : '<a href="' . url("summary/excel/{$key->uraian_jabatan_id}?$param") . '" class="btn btn-xs btn-success"><i class="fa fa-table"></i></a>';
                        
                                        $button = '';
                                        if ($key->status === '-') {
                                            $add = '<a href="' . $link . '" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i></a>';
                                            $button = $add;
                                        } else {
                                            $edit = '<a href="' . $link . '" class="btn btn-xs btn-success"><i class="fa fa-search"></i></a>';
                                            $print = '<a href="' . url("summary/generate/{$key->uraian_jabatan_id}?$param") . '" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>';
                                            $button = "$link2 $print $edit";
                        
                                            if (session('role') === 'admins' || session('role') === 'amu') {
                                                $delete = '<a href="' . url("uraian_jabatan/delete/{$key->uraian_jabatan_id}?$param") . '" 
                                                    class="btn btn-xs btn-danger" 
                                                    onclick="return confirm(\'Anda yakin ingin menghapus data ini?\')">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>';
                                                $button .= " $delete";
                                            }
                                        }
                        
                                        if (session('role') === 'readonly' && $key->status === '-') {
                                            $jab = str_replace(' ', '&nbsp;', $key->hierarchy);
                                            $button = $button === $add ? '' : $button;
                                        } else {
                                            $jab = '<a href="' . $link . '">' . str_replace(' ', '&nbsp;', $key->hierarchy) . '</a>';
                                        }
                                    @endphp
                        
                                    <tr>
                                        <td><small style="display:none">{{ $key->path }}</small></td>
                                        <td><small><b>{!! $jab !!}</b><br/>{!! $mj !!}</small></td>
                                        <td>{{ $key->klaster }}</td>
                                        <td>{{ $key->direktorat }}</td>
                                        <td><small>{{ $key->siteid }}</small></td>
                                        <td><small>{{ $key->jen }}</small></td>
                                        <td>{!! $button !!}</td>
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
