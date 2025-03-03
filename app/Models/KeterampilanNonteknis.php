<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanNonteknis extends Model
{

    protected $table = 'keterampilan_nonteknis';

    protected $fillable = [
        'master_jabatan',
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
