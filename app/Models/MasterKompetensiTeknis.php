<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKompetensiTeknis extends Model
{
    // use SoftDeletes;
    
    protected $fillable = [
        'kode',
        'nama',
        'name',
        'created_by',
    ];
    protected $dates = ['deleted_at'];


    public function level()
    {
        return $this->hasMany(MasterDetailKomptensiTeknis::class, 'kode_master', 'kode');
    }
}
