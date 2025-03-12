<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KemampuandanPengalaman extends Model
{
    protected $table = 'KEMAMPUAN_DAN_PENGALAMAN';
    protected $fillable = [
        'uraian_master_jabatan_id',
        'definisi',
        'jenis_jabatan',
        'created_by'
    ];
}


