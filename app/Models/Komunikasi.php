<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komunikasi extends Model
{
    protected $table = 'KOMUNIKASI';
    protected $primaryKey = 'KOMUNIKASI_ID';
    public $timestamps = false; 
    public $incrementing = true;

    protected $fillable = [
        'uraian_jabatan_id',
        'subjek',
        'tujuan',
        'lingkup_flag',
        'dibuat_oleh',
        'waktu_dibuat'
    ];
}

