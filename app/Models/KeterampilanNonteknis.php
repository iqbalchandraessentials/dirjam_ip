<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeterampilanNonteknis extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'uraian_master_jabatan_id',
        'created_by',
        'kode',
        'kategori',
        'jenis',
        'master_jabatan',
    ];
    // Pastikan Anda memiliki kolom deleted_at di tabel yang sesuai
    protected $dates = ['deleted_at'];
    
    public function detail()
    {
        return $this->hasOne(MasterKompetensiNonteknis::class, 'kode', 'kode');
    }
}
