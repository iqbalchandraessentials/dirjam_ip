<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKompetensiNonteknis extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'jenis',
        'definisi',
        'created_by'
    ];
    protected $dates = ['deleted_at'];
}
