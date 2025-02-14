<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeterampilanTeknis extends Model
{
    // use SoftDeletes;
    
    protected $fillable = [
        'uraian_master_jabatan_id',
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori',
        'master_jabatan',
        'created_by'
    ];
    // Pastikan Anda memiliki kolom deleted_at di tabel yang sesuai
    protected $dates = ['deleted_at'];
    
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