<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasPokoUtamaGenerik extends Model
{
    protected $table = 'tugas_poko_utama_generiks';
    protected $fillable = [
        'uraian_master_jabatan_id',
        'aktivitas',
        'output',
        'jenis',
    ];
    protected $guarded = ['id'];
}
