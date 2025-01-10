<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_KEWENANGAN extends Model
{
    use HasFactory;
    protected $table = 'kewenangan';
    protected $primaryKey = 'KEWENANGAN_ID';
    public $timestamps = false;

    protected $fillable = ['KEWENANGAN_ID', 'JUMLAH_KEWENANGAN'];
}



