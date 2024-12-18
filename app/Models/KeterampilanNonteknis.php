<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanNonteknis extends Model
{
    protected $fillable = [
        'uraian_master_jabatan_id',
        'kode',
        'kategori',
        'jenis',
    ];
    public function detail()
    {
        return $this->hasOne(MasterKompetensiNonteknis::class, 'kode', 'kode');
    }
}
