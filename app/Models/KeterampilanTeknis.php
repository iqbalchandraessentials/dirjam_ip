<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanTeknis extends Model
{
    protected $fillable = [
        'uraian_master_jabatan_id',
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori',
    ];
    public function master()
    {
        return $this->hasOne(MasterKompetensiTeknis::class, 'kode', 'kode');
    }

    public function detailMasterKompetensiTeknis()
    {
        return $this->hasOne(MasterDetailKomptensiTeknis::class, 'kode_master', 'master_detail_kompetensi_id');
    }
}