<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengambilanKeputusan extends Model
{
    protected $table = 'PENGAMBILAN_KEPUTUSAN';
    protected $primaryKey = 'PENGAMBILAN_KEPUTUSAN_ID';
    public $timestamps = false; // Jika tidak ada created_at dan updated_at
    public $incrementing = true;// jika AKTIVITAS_ID auto increment.

    protected $fillable = [
        'uraian_jabatan_id',
        'pengambilan_keputusan',
        'dibuat_oleh',
        'waktu_dibuat'
    ];
}
