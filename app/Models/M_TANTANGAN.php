<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_TANTANGAN extends Model
{
    protected $table = 'TANTANGAN';
    protected $primaryKey = 'TANTANGAN_ID';
    public $timestamps = false; // Jika tidak ada created_at dan updated_at
    public $incrementing = true;// jika AKTIVITAS_ID auto increment.

    protected $fillable = [
        'uraian_jabatan_id',
        'tantangan',
        'dibuat_oleh',
        'waktu_dibuat'
    ];

}
