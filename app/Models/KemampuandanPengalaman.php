<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KemampuandanPengalaman extends Model
{
    protected $table = 'kemampuan_dan_pengalaman';
    protected $fillable = [
        'uraian_master_jabatan_id',
        'definisi',
        'jenis_jabatan',
        'created_by'
    ];
}


