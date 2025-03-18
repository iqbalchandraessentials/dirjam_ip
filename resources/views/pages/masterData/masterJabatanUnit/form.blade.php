@extends('master')

@section('title', 'Master Jabatan | Direktori Jabatan')

@section('content')
<div class="col-12">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-6 text-left">
                    <h4 class="box-title">{{ isset($jabatan) ? 'Edit' : 'Input' }} Master Jabatan </h4>
                </div>
                <div class="col-6 text-right">
                </div>
            </div>
        </div>
        @include('components.notification') 
            <div class="box-body">  
                <form method="POST" action="{{ isset($jabatan) ? route('master.jabatan.update') : route('master.jabatan.store') }}">
                    @csrf
                    <input type="text" value ="{{ isset($jabatan) ? $jabatan->id : '' }}" hidden name="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="master_jabatan" class="form-control" required value="{{ old('master_jabatan', $jabatan->master_jabatan ?? '') }}">
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label">Singkatan Jabatan</label>
                        <input type="text" name="singkatan_jabatan_clean" class="form-control" value="{{ old('singkatan_jabatan_clean', $jabatan->singkatan_jabatan_clean ?? '') }}">
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="aktif" class="form-control">
                            <option value="1" {{ (isset($jabatan) && $jabatan->aktif == 1) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ (isset($jabatan) && $jabatan->aktif == 0) ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label">Singkatan Jabatan Tambahan</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10%;">No</th>
                                    <th class="text-center">Singkatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $max_singkatan = 10; @endphp
                                @for ($i = 0; $i < $max_singkatan; $i++)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                            <input type="text" name="singkatan_jabatan[]" class="form-control" 
                                                value="{{ old('singkatan_jabatan.' . $i, $jabatan->singkatan[$i]->singkatan_jabatan ?? '') }}">
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
            
                    <div class="text-end">
                        <a href="{{ route('master.jabatan') }}" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection