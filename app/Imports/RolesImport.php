<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Role as ModelsRole;

class RolesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ModelsRole([
            'name' => $row[0], // Sesuaikan dengan struktur kolom di Excel Anda
        ]);
    }
}
