<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpesifikasiPendidikan extends Model
{
    protected $fillable = [
        'uraian_master_jabatan_id',
        'pendidikan',
        'pengalaman',
        'bidang_studi',
    ];
}