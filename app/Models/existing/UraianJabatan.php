<?php

namespace App\Models\existing;

use Illuminate\Database\Eloquent\Model;

class UraianJabatan extends Model
{
    protected $table = 'uraian_jabatan';
    protected $primaryKey = 'URAIAN_JABATAN_ID';
    protected $keyType = 'string'; 
    public $timestamps = false; 

    protected $fillable = [
        'fungsi_utama',
        'dibuat_oleh',
        'active_flag',
        'waktu_dibuat',
        'nama_template',
        'unit_kd',
        'sign4_id'
    ];

}
