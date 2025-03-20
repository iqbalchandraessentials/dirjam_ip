<?php

namespace App\Models\existing;

use App\Models\Aktivitas;
use App\Models\KemampuandanPengalaman;
use App\Models\PengambilanKeputusan;
use App\Models\SpesifikasiPendidikan;
use App\Models\Tantangan;
use Illuminate\Database\Eloquent\Model;

class UraianJabatan extends Model
{
    protected $table = 'uraian_jabatan';
    protected $primaryKey = 'URAIAN_JABATAN_ID';
    protected $keyType = 'string'; 
    public $timestamps = false; 

    protected $fillable = [
        'fungsi_utama',
        'dibuat_oleh',
        'active_flag',
        'waktu_dibuat',
        'nama_template',
        'unit_kd',
        'sign4_id'
    ];

    public function tugas_pokok_utama()
    {
        return $this->hasMany(Aktivitas::class, 'uraian_jabatan_id', 'uraian_jabatan_id');
    }

    public function spesifikasi_pendidikan()
    {
        
        return $this->hasMany(SpesifikasiPendidikan::class, 'uraian_master_jabatan_id', 'uraian_jabatan_id');
    }

     public function tantangan()
    {
        return $this->hasMany(Tantangan::class, 'uraian_jabatan_id', 'uraian_jabatan_id');
    }

    public function pengambilan_keputusan()
    {
        return $this->hasMany(PengambilanKeputusan::class, 'uraian_jabatan_id', 'uraian_jabatan_id');
    }
    
    public function kemampuan_dan_pengalaman()
    {   
        return $this->hasMany(KemampuandanPengalaman::class, 'uraian_master_jabatan_id', 'uraian_jabatan_id');
    }
}

