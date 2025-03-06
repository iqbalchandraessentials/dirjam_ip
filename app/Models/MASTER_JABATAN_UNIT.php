<?php

namespace App\Models;

use App\Models\unit\M_UNIT;
use Illuminate\Database\Eloquent\Model;

class MASTER_JABATAN_UNIT extends Model
{
    protected $table = 'MASTER_JABATAN_UNIT';

    public function unit()
    {
        return $this->hasOne(M_UNIT::class, 'unit_kd', 'siteid');
    }
}
