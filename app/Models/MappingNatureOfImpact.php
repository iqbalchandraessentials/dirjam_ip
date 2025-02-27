<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingNatureOfImpact extends Model
{
    protected $fillable = [
        'kode_profesi',
        'jenis',
        'created_by'
    ];

    public function namaProfesi()
    {
        return $this->hasOne(M_PROFESI::class, 'kode_nama_profesi', 'kode_profesi');
    }

}
