<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKompetensiNonteknis extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'definisi'
    ];
}
