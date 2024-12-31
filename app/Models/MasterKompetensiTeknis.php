<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKompetensiTeknis extends Model
{
    
    public function level()
    {
        return $this->hasMany(MasterDetailKomptensiTeknis::class, 'kode_master', 'kode');
    }
}
