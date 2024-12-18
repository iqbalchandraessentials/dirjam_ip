<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKompetensiTeknis extends Model
{
    
    public function level()
    {
        return $this->hasOne(MasterKompetensiTeknis::class, 'kode', 'kode');
    }
}
