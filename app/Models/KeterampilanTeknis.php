<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanTeknis extends Model
{
    protected $fillable = [
        'uraian_master_jabatan_id',
        'kode',
        'level',
        'kategori',
    ];
    public function master()
    {
        return $this->hasOne(MasterKompetensiTeknis::class, 'kode', 'kode');
    }

    public function detailMasterKompetensiTeknis()
    {
        return $this->hasOne(MasterDetailKomptensiTeknis::class, 'kode_master', 'kode')
                    ->whereColumn('level', 'level');
    }
}
