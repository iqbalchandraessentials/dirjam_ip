<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDetailKomptensiTeknis extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'kode_master',
        'level',
        'perilaku',
        'kode_master_level',
        'created_by',
    ];
    protected $dates = ['deleted_at'];
}
