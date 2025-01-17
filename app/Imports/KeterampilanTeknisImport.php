<?php

namespace App\Imports;

use App\Models\KeterampilanTeknis;
use Maatwebsite\Excel\Concerns\ToModel;

class KeterampilanTeknisImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KeterampilanTeknis([
            'master_jabatan' => $row['master_jabatan'],
            'kode' => $row['kode'],
            'kategori' => $row['kategori'],
            'level' => $row['level'],
            'master_detail_komptensi_id' => $row['kode'] . '.' . $row['level'],
        ]);
    }
}
