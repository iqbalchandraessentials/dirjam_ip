<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_AKTIVITAS extends Model
{
    protected $table = 'AKTIVITAS';
    protected $primaryKey = 'AKTIVITAS_ID';
    public $timestamps = false; // Jika tidak ada created_at dan updated_at
    public $incrementing = true;// jika AKTIVITAS_ID auto increment.
    protected $fillable = [
        'uraian_jabatan_id',
        'aktivitas',
        'output',
        'dibuat_oleh',
        'waktu_dibuat'
    ];


}
