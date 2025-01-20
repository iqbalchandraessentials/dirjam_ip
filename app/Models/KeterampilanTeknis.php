<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeterampilanTeknis extends Model
{
    protected $fillable = [
        'uraian_master_jabatan_id',
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori',
        'created_by'
    ];
    
    public function master()
    {
        return $this->hasOne(MasterKompetensiTeknis::class, 'kode', 'kode');
    }

    public function detailMasterKompetensiTeknis()
    {
        return $this->hasOne(MasterDetailKomptensiTeknis::class, 'kode_master_level', 'master_detail_kompetensi_id');
    }
    public function uraianJabatan()
    {
        return $this->hasOne(UraianMasterJabatan::class, 'id', 'uraian_master_jabatan_id');
    }
}