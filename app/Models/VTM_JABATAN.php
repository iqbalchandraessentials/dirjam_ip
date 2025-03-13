<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VTM_JABATAN extends Model
{
    protected $table = "V_TM_JABATAN";

    public function namaProfesi()
    {
        return $this->hasOne(M_PROFESI::class, 'kode_nama_profesi', 'nama_profesi');
    }

    public function jenjangJabatan()
    {
        return $this->hasOne(MasterJenjangJabatan::class, 'kode', 'jen');
    }
}
