<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSingkatanJabatan extends Model
{
    protected $table = 'MST_JABATAN_SING_TB';
    protected $primaryKey = 'master_jabatan';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'singkatan_jabatan',
        'master_jabatan',
        'aktif',
    ];
}
