<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsentrasi extends Model
{
    protected $table = 'konsentrasi';
    protected $primaryKey = 'konsentrasi_id';
    public $timestamps = false;
    protected $fillable = [
        'konsentrasi',
        'bidang_studi_id'
    ];
}
