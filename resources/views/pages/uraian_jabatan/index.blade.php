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

                    <form action="{{ route('filter-jabatan') }}" method="GET" class="form-horizontal">

                        <div class="d-flex justify-content-center">
                            <div class="row">
                                {{-- <div class="col-4">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="unit" class="mr-3 mb-0">Unit:</label>
                                        <select class="form-control select2" name="unit" style="width: 100%;">
                                            <option selected disabled>All</option>
                                            @foreach ($unitOptions as $unit)
                                                <option value="{{ $unit->kode }}">
                                                    {{ $unit->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="jenjang" class="mr-3 mb-0">Jenjang:</label>
                                        <select class="form-control select2" name="jenjang" style="width: 100%;">
                                            <option selected disabled>All</option>
                                            @foreach ($jenjangOptions as $jenjang)
                                                <option value="{{ $jenjang->kode }}">
                                                    {{ $jenjang->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>
                            </div> --}}
                            {{--  --}}
                                {{-- <div class="col">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="jenjang" class="mr-3 mb-0">Unit</label>
                                            <select class="select2" style="width: 100%" multiple name="unit[]">
                                                @foreach ($unitOptions as $unit)
                                                    <option value="{{ $unit->kode }}"
                                                        {{ in_array($unit, request('unit', [])) ? 'selected' : '' }}>
                                                        {{ $unit->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div> --}}
                                {{-- <div class="col">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="jenjang" class="mr-3 mb-0">Jenjang</label>
                                            <select class="select2" style="width: 100%" multiple name="jenjang[]">
                                                @foreach ($jenjangOptions as $jenjang)
                                                    <option value="{{ $jenjang->kode }}"
                                                        {{ in_array($jenjang, request('jenjang', [])) ? 'selected' : '' }}>
                                                        {{ $jenjang->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-auto">
                                    <div class="form-group">
                                            <button type="submit" class="btn btn-primary ml-2"><i class="ti-search"></i></button>
                                        </div>
                                    </div> --}}
                            </div>
                        </div>
                    </form>


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
                            <tbody id="tableBody">
                                @foreach ($jabatans as $key)
                                    @php
                                        $jab = str_replace(' ', '&nbsp;', $key->hierarchy);
                                        $a = str_repeat('&nbsp;', $key->leveling * 10);
                                        $mj = "$a&nbsp;($key->master_jabatan <small>$key->position_id</small>)";

                                        $param = request()->getQueryString();
                                        $link =
                                            $key->status === '-'
                                                ? url('uraian_jabatan', $key->position_id)
                                                : url('uraian_jabatan', $key->uraian_jabatan_id);
                                        $link2 =
                                            $key->status === '-'
                                                ? ''
                                                : '<a href="' .
                                                    url("summary/excel/{$key->uraian_jabatan_id}?$param") .
                                                    '" class="btn btn-xs btn-success"><i class="fa fa-table"></i></a>';

                                        $button = '';
                                        if ($key->status === '-') {
                                            $add =
                                                '<a href="' .
                                                $link .
                                                '" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i></a>';
                                            $button = $add;
                                        } else {
                                            $edit =
                                                '<a href="' .
                                                $link .
                                                '" class="btn btn-xs btn-success"><i class="fa fa-search"></i></a>';
                                            $print =
                                                '<a href="' .
                                                route('uraian_jabatan.export_pdf', $key->uraian_jabatan_id) .
                                                '" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>';
                                            $button = "$link2 $print";

                                            if (session('role') === 'admins' || session('role') === 'amu') {
                                                $delete =
                                                    '<a href="' .
                                                    url("uraian_jabatan/delete/{$key->uraian_jabatan_id}?$param") .
                                                    '" 
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
                                            $jab =
                                                '<a href="' .
                                                $link .
                                                '">' .
                                                str_replace(' ', '&nbsp;', $key->hierarchy) .
                                                '</a>';
                                        }
                                    @endphp

                                    <tr>
                                        <td><small style="display:none">{{ $key->path }}</small></td>
                                        <td><small><b>{!! $jab !!}</b><br />{!! $mj !!}</small></td>
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
