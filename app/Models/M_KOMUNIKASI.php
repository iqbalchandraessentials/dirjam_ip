<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_KOMUNIKASI extends Model
{
    protected $table = 'KOMUNIKASI';
    public function getByJabatan($id = "", $lingkup = "")
    {
        $query = DB::table($this->table)
            ->select(
                "{$this->table}.*",
                DB::raw("TO_CHAR(WAKTU_DIBUAT, 'YYYY-MM-DD HH24:MI:SS') AS WAKTU_DIBUAT"),
                DB::raw("TO_CHAR(WAKTU_DIUBAH, 'YYYY-MM-DD HH24:MI:SS') AS WAKTU_DIUBAH")
            )
            ->where('URAIAN_JABATAN_ID', $id)
            ->orderBy('URUTAN');
        if (!empty($lingkup)) {
            $query->where('LINGKUP_FLAG', $lingkup);
        }

        return $query->get();
    }
}
