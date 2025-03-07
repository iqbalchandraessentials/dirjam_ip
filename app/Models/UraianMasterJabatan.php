<?php

namespace App\Models;

use App\Models\unit\M_UNIT;
use Illuminate\Database\Eloquent\Model;

class UraianMasterJabatan extends Model
{
    protected $table = 'uraian_master_jabatans';
    protected $fillable = [
        'master_jabatan_id',
        'nama',
        'unit_kd',
        'fungsi_utama',
        'anggaran',
        'accountability',
        'nature_impact',
        'created_by',
    ];

    function masterJabatan() {
        return $this->belongsTo(MasterJabatan::class, 'master_jabatan_id', 'id');
    }
    function unit() {
        return $this->hasOne(M_UNIT::class, 'unit_kd', 'unit_kd');
    }
    public function PokoUtamaGenerik()
    {
        return $this->hasMany(PokoUtamaGenerik::class, 'uraian_master_jabatan_id', 'id');
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
        return $this->hasMany(KeterampilanNonteknis::class, 'master_jabatan', 'nama');
    }
    public function KeterampilanTeknisEnabler()
    {
        return $this->hasMany(KeterampilanTeknis::class, 'master_jabatan', 'nama')->where('kategori','ENABLER');
    }
    public function KeterampilanTeknisCore()
    {
        return $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'id');
    }
    public function keterampilanTeknis()
    {
        $core = $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'id');
        $enabler = $this->hasMany(KeterampilanTeknis::class, 'master_jabatan', 'nama')->where('kategori','ENABLER');
        return $core->union($enabler);
    }
}
