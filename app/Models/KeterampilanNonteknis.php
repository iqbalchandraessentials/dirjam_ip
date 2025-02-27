<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanNonteknis extends Model
{

    protected $table = 'keterampilan_nonteknis';

    protected $fillable = [
        'uraian_master_jabatan_id',
        'created_by',
        'kode',
        'kategori',
        'jenis',
        'master_jabatan',
    ];
    
    public function detail()
    {
        return $this->hasOne(MasterKompetensiNonteknis::class, 'kode', 'kode');
    }
}
