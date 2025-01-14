<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_URAIAN_JABATAN extends Model
{
    protected $table = 'URAIAN_JABATAN';

    function get($id) {
        $query = DB::table($this->table)
            ->select(
                "{$this->table}.*",
        DB::raw("TO_CHAR(WAKTU_DIBUAT,'YYYY-MM-DD HH24:MI:SS') AS WAKTU_DIBUAT", false),
        DB::raw("TO_CHAR(WAKTU_DIBUAT,'DD-MM-YYYY HH24:MI:SS') AS WAKTU", false),
        DB::raw("TO_CHAR(WAKTU_DIUBAH,'YYYY-MM-DD HH24:MI:SS') AS WAKTU_DIUBAH", false),
            )->
        where("URAIAN_JABATAN_ID", $id);
        return $query->get();
    }

    
}
