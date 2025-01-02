<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewUraianJabatan extends Model
{
    protected $table = 'VIEW_URAIAN_JABATAN';

    public function namaProfesi()
    {
        return $this->hasOne(M_PROFESI::class, 'KODE_NAMA_PROFESI', 'nama_profesi');
    }

    public function jenjangJabatan()
    {
        return $this->hasOne(MasterJenjangJabatan::class, 'kode', 'jenjang_kode');
    }

}
