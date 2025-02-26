<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsentrasi extends Model
{
    protected $table = 'konsentrasi';

    protected $fillable = [
        'konsentrasi',
        'bidang_studi_id'
    ];
}
