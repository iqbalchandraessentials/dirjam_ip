<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UraianMasterJabatan extends Model
{
    protected $table = 'uraian_master_jabatans';
    protected $fillable = [
        'master_jabatan_id',
        'nama',
        'unit_id',
        'jenis_jabatan',
        'fungsi_utama',
        'anggaran',
        'accountability',
        'nature_impact',
    ];

    

    public function tugasPokoUtamaGenerik()
    {
        return $this->hasMany(TugasPokoUtamaGenerik::class, 'uraian_master_jabatan_id', 'id');
    }
    public function hubunganKerja()
    {
        return $this->hasMany(HubunganKerja::class, 'uraian_master_jabatan_id', 'id');
    }
    public function masalahKompleksitasKerja()
    {
        return $this->hasMany(MasalahKompleksitasKerja::class, 'uraian_master_jabatan_id', 'id');
    }
    public function wewenangJabatan()
    {
        return $this->hasMany(WewenangJabatan::class, 'uraian_master_jabatan_id', 'id');
    }
    public function spesifikasiPendidikan()
    {
        return $this->hasMany(SpesifikasiPendidikan::class, 'uraian_master_jabatan_id', 'id');
    }
    public function kemampuandanPengalaman()
    {
        return $this->hasMany(KemampuandanPengalaman::class, 'uraian_master_jabatan_id', 'id');
    }
    public function keterampilanNonteknis()
    {
        return $this->hasMany(KeterampilanNonteknis::class, 'uraian_master_jabatan_id', 'master_jabatan_id');
    }
    public function KeterampilanTeknisEnabler()
    {
        return $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'master_jabatan_id');
    }
    public function KeterampilanTeknisCore()
    {
        return $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'id');
    }

    public function keterampilanTeknis()
    {
        $enabler = $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'master_jabatan_id');
        $core = $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'id');
        
        return $enabler->union($core);
    }
}