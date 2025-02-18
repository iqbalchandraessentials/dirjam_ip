<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKomptensiTeknis extends Model
{
    protected $table = 'detail_komptensi_teknis';
    protected $fillable = [
        'kode_master',
        'level',
        'perilaku',
        'kode_master_level',
        'created_by',
    ];
}
