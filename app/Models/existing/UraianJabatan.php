<?php

namespace App\Models\existing;

use Illuminate\Database\Eloquent\Model;

class UraianJabatan extends Model
{
    protected $table = 'uraian_jabatan';

    protected $fillable = [
        'fungsi_utama',
        'diubah_oleh'
    ];

    protected $primaryKey = 'URAIAN_JABATAN_ID';
    protected $keyType = 'string'; 
    public $timestamps = false; 

}
