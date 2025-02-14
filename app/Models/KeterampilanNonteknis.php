<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeterampilanNonteknis extends Model
{
    // use SoftDeletes;
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
