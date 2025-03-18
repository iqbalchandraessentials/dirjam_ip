<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJabatan extends Model
{
    protected $table = 'MST_JABATAN_TB';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false; 

    protected $fillable = [
        'id', 'master_jabatan', 'singkatan_jabatan_clean', 'aktif'
    ];

    public function singkatan()
    {
        return $this->hasMany(MasterSingkatanJabatan::class, 'master_jabatan', 'master_jabatan');
    }

}
