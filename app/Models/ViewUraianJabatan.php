<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewUraianJabatan extends Model
{
    protected $table = 'VIEW_URAIAN_JABATAN';

    public function namaProfesi()
    {
        return $this->hasOne(M_PROFESI::class, 'kode_nama_profesi', 'nama_profesi');
    }

    public function jenjang_jabatan()
    {
        return $this->hasOne(MasterJenjangJabatan::class, 'kode', 'jen');
    }

    public function tugas_pokok_utama()
    {
        return $this->hasMany(M_AKTIVITAS::class, 'uraian_jabatan_id', 'template_id');
    }

    public function tugas_pokok_generik()
    {
        return $this->hasMany(PokoUtamaGenerik::class, 'jenis_jabatan', 'type');
    }

    public function spesifikasi_pendidikan()
    {
        
        return $this->hasMany(SpesifikasiPendidikan::class, 'uraian_master_jabatan_id', 'template_id');
    }

     public function tantangan()
    {
        return $this->hasMany(M_TANTANGAN::class, 'uraian_jabatan_id', 'template_id');
    }

    public function pengambilan_keputusan()
    {
        return $this->hasMany(M_PENGAMBILAN_KEPUTUSAN::class, 'uraian_jabatan_id', 'template_id');
    }
    
    public function kemampuan_dan_pengalaman()
    {   
        return $this->hasMany(KemampuandanPengalaman::class, 'uraian_master_jabatan_id', 'template_id');
    }

    public function hubungan_kerja()
    {   
        return $this->hasMany(M_KOMUNIKASI::class, 'uraian_jabatan_id', 'template_id');   
    }

    public function keterampilan_non_teknis()
    {   
        return $this->hasMany(KeterampilanNonteknis::class, 'master_jabatan', 'master_jabatan');
    }
    

}
