<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HubunganKerja extends Model
{
    protected $fillable = [
        'uraian_jabatan_id',
        'komunikasi',
        'tujuan',
        'jenis',
    ];
}
