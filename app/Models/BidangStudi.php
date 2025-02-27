<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangStudi extends Model
{
    protected $table = 'bidang_studi';

    protected $fillable = [
        'bidang_studi'
    ];

    public function konsentrasi()
    {
        return $this->hasMany(Konsentrasi::class, 'bidang_studi_id', 'bidang_studi_id');
    }
}
