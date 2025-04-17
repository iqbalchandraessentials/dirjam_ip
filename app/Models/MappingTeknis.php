<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingTeknis extends Model
{
    protected $fillable = [
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori',
        'master_jabatan',
        'jenis_pembangkit',
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
        return $this->hasOne(DetailKomptensiTeknis::class, 'kode_master_level', 'master_detail_kompetensi_id');
    }
}
