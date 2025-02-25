<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_JABATAN extends Model
{
    use HasFactory;
    protected $table = 'VIEW_URAIAN_JABATAN';
    protected $table2 = 'JENJANG';
    // If you have a primary key other than 'id', specify it here
    protected $primaryKey = 'POSITION_ID'; // Or whatever your primary key is
    public $timestamps = false; // If you don't have created_at and updated_at columns

    public function getById($id)
    {
        return DB::table($this->table)
            ->select("$this->table.*", "$this->table2.*") // Use selectRaw if needed for complex selects
            ->join($this->table2, "$this->table2.JENJANG_KD", "=", "$this->table.JEN")
            ->where("$this->table.POSITION_ID", $id)
            ->first(); // Use first() to get a single object, not a collection
    }



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

    public function jenjangJabatan()
    {
        return $this->hasOne(MasterJenjangJabatan::class, 'kode', 'jen');
    }

    public function namaProfesi()
    {
        return $this->hasOne(M_PROFESI::class, 'kode_nama_profesi', 'nama_profesi');
    }
    public function keterampilanNonteknis()
    {
        return $this->hasMany(KeterampilanNonteknis::class, 'master_jabatan', 'nama');
    }
    public function KeterampilanTeknisEnabler()
    {
        return $this->hasMany(KeterampilanTeknis::class, 'master_jabatan', 'nama')->where('kategori','ENABLER');
    }
    public function KeterampilanTeknisCore()
    {
        return $this->hasMany(KeterampilanTeknis::class, 'uraian_master_jabatan_id', 'id');
    }

}
