<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingNonTeknis extends Model
{
    protected $table = 'MAPPING_NON_TEKNIS';

    protected $fillable = [
        'master_jabatan',
        'jenis_pembangkit',
        'kode',
        'kategori',
        'jenis',
        'created_by',
    ];
    
    public function detail()
    {
        return $this->hasOne(MasterKompetensiNonteknis::class, 'kode', 'kode');
    }
}
