<?php

namespace App\Models\existing;

use App\Models\Aktivitas;
use App\Models\KemampuandanPengalaman;
use App\Models\Komunikasi;
use App\Models\PengambilanKeputusan;
use App\Models\SpesifikasiPendidikan;
use App\Models\Tantangan;
use Illuminate\Database\Eloquent\Model;

class UraianJabatan extends Model
{
    protected $table = 'uraian_jabatan';
    protected $primaryKey = 'uraian_jabatan_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false; 

    protected $fillable = [
        'fungsi_utama',
        'dibuat_oleh',
        'active_flag',
        'waktu_dibuat',
        'nama_template',
        'unit_kd',
        'sign4_id',
        'template_flag',
        'status',
        'periode_date',
        'anggaran',
        'accountability',
        'nature_impact'
    ];

    public function tugas_pokok_utama()
    {
        return $this->hasMany(Aktivitas::class, 'uraian_jabatan_id', 'uraian_jabatan_id');
    }

    public function spesifikasi_pendidikan()
    {
        
        return $this->hasMany(SpesifikasiPendidikan::class, 'uraian_jabatan_id', 'uraian_jabatan_id');
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
        return $this->hasMany(KemampuandanPengalaman::class, 'uraian_jabatan_id', 'uraian_jabatan_id');
    }

    public function hubungan_kerja()
    {   
        return $this->hasMany(Komunikasi::class, 'uraian_jabatan_id', 'uraian_jabatan_id');   
    }
}

