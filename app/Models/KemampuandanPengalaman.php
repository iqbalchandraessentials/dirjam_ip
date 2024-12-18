<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KemampuandanPengalaman extends Model
{
    protected $table = 'kemampuandan_pengalaman';
    protected $fillable = [
        'uraian_master_jabatan_id',
        'definisi',
    ];
}


