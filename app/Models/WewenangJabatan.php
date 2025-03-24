<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WewenangJabatan extends Model
{
    protected $fillable = [
        'uraian_jabatan_id',
        'definisi',
        'jenis_jabatan',
        'created_by'
    ];
}
