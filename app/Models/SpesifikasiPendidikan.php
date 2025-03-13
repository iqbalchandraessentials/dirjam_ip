<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpesifikasiPendidikan extends Model
{
    protected $fillable = [
        'URAIAN_MASTER_JABATAN_ID',
        'pendidikan',
        'pengalaman',
        'bidang_studi',
    ];
}
