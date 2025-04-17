<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDefaultData extends Model
{
    protected $table = "MASTER_DEFAULT_DATA";

    protected $fillable = [
        "JENIS_JABATAN",
        "DEFINISI",
        "KATEGORI",
        "CREATED_BY",
    ];
    
}
