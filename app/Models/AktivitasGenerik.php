<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasGenerik extends Model
{
    protected $table = 'AKTIVITAS_GENERIK';
    protected $fillable = [
        'uraian_jabatan_id',
        'aktivitas',
        'jenis_jabatan',
        'output',
        'jenis',
        'created_by'
    ];
    protected $guarded = ['id'];
}
