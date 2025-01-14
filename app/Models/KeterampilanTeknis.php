<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeterampilanTeknis extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'uraian_master_jabatan_id',
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori'
    ];
    protected $guarded = ['id'];
    public function master()
    {
        return $this->hasOne(MasterKompetensiTeknis::class, 'kode', 'kode');
    }

    public function detailMasterKompetensiTeknis()
    {
        return $this->hasOne(MasterDetailKomptensiTeknis::class, 'kode_master_level', 'master_detail_kompetensi_id');
    }
}