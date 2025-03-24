<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokoUtamaGenerik extends Model
{
    protected $table = 'pokok_utama_generiks';
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
