<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_KEWENANGAN_JABATAN extends Model
{
    use HasFactory;
    protected $table = 'kewenangan_jabatan';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['KEWENANGAN_ID', 'URAIAN_JABATAN_ID', 'TIPE_KEWENANGAN'];

    public function kewenangan()
    {
        return $this->belongsTo(M_KEWENANGAN::class, 'KEWENANGAN_ID', 'KEWENANGAN_ID');
    }
}
