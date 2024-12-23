<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJabatan extends Model
{
    protected $fillable = [
    'nama',
    'aktif',
    'unit_kode',
    'jenis_jabatan',
    'jenjang_kode',
    ];

    public function uraianMasterJabatan()
    {
        return $this->hasOne(UraianMasterJabatan::class, 'master_jabatan_id', 'id')->latestOfMany();
    }
    
    public function draftUraianMasterJabatan()
    {
        return $this->hasMany(UraianMasterJabatan::class, 'master_jabatan_id', 'id');
    }



}
