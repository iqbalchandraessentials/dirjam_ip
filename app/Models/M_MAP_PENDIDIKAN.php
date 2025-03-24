<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_MAP_PENDIDIKAN extends Model
{
    protected $table = 'MAP_PENDIDIKAN';

    public function getByJabatan($id = "")
    {
        return DB::table('MAP_PENDIDIKAN as mp')
            ->join('PENDIDIKAN as p', 'p.PENDIDIKAN_ID', '=', 'mp.PENDIDIKAN_ID')
            ->select('mp.*', 'p.*')
            ->where('mp.uraian_jabatan_id', $id)
            ->orderBy('mp.PENDIDIKAN_ID', 'DESC')
            ->get();
    }

    public function getBidang($mapPendidikanId)
    {
        return DB::table('MAP_BIDANG as mb')
            ->join('BIDANG_STUDI as bs', 'bs.BIDANG_STUDI_ID', '=', 'mb.BIDANG_STUDI_ID')
            ->select('mb.*', 'bs.BIDANG_STUDI')
            ->where('mb.MAP_PENDIDIKAN_ID', $mapPendidikanId)
            ->get();
    }
}
