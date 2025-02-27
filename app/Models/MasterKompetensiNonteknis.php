<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKompetensiNonteknis extends Model
{
    
    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'jenis',
        'definisi',
        'created_by'
    ];

    public $incrementing = true;
    protected $primaryKey = 'ID';
    protected $keyType = 'int';

    
}
