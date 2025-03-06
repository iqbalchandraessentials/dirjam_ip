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
                    {{-- @if (auth()->user()->hasRole(['SuperAdmin'])) --}}
                    <form action="{{ route('uraian_jabatan.filter') }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="unit" class="mr-3 mb-0">Unit:</label>
                                        <select class="form-control select2" name="unit">
                                            @if(isset($selectUnit))
                                            <option selected disabled>{{$selectUnit}}</option>
                                            @endif
                                            @foreach ($unitOptions as $unit)
                                                <option value="{{ $unit->unit_kd }}" 
                                                    {{ old('unit', request('unit')) == $unit->unit_kd ? 'selected' : '' }}>
                                                    ({{ $unit->unit_kd }})
                                                    {{ $unit->unit_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary ml-2"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- @endif --}}
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th>Path</th>
                                    <th>Jabatan</th>
                                    <th>Unit</th>
                                    <th>Jenjang</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($jabatans as $key)
                                @php
                                    $a = str_repeat('&nbsp;', $key->leveling * 10);
                                    $mj = "$a&nbsp;($key->master_jabatan <small>$key->position_id</small>)";
                                    $link = $key->status === '-'
                                        ? url('uraian_jabatan', $key->position_id)
                                        : url('uraian_jabatan', $key->uraian_jabatan_id);
                                    $jab = '<a href="' . $link . '">' . str_replace(' ', '&nbsp;', $key->hierarchy) . '</a>';
                                    $link2 = $key->status === '-'
                                        ? ''
                                        : '<a href="' . route('export.uraian_jabatan_Excel', $key->uraian_jabatan_id) . '" class="btn btn-xs btn-success"><i class="fa fa-table"></i></a>';
                                
                                    $edit = '<a href="' . $link . '" class="btn btn-xs btn-success"><i class="fa fa-search"></i></a>';
                                    $print = '<a href="' . route('export.uraian_jabatan_PDF', $key->uraian_jabatan_id) . '" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>';
                                    $button = "$link2 $print";
                                @endphp
                                    <tr>
                                        <td><small style="display:none">{{ $key->path }}</small></td>
                                        <td><small><b>{!! $jab !!}</b><br />{!! $mj !!}</small></td>
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
