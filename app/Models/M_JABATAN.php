<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_JABATAN extends Model
{
    protected $table = 'VIEW_URAIAN_JABATAN';
    public function getKlaster($cond = "")
    {
        $query = DB::table($this->table); // Buat query builder baru di dalam metode
    
        if (!empty($cond)) {
            $query->whereRaw($cond);
        }
    
        $query->select(DB::raw('DISTINCT(' . $this->table . '.KLASTER)'))
              ->whereNotNull($this->table . '.KLASTER')
              ->where($this->table . '.KLASTER', '!=', '')
              ->orderBy($this->table . '.KLASTER', 'asc');
    
        return $query->get();
    }
    
    public function getAll($cond = "")
    {
        $query = DB::table($this->table); // Buat query builder baru di dalam metode
    
        if (!empty($cond)) {
            $query->whereRaw($cond);
        }
    
        $query->select("$this->table.*");
    
        return $query->get();
    }
    
}
