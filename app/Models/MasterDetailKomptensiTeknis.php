<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDetailKomptensiTeknis extends Model
{
    protected $fillable = [
        'kode_master',
        'level',
        'perilaku',
        'kode_master_level',
        'created_by',
    ];
}
