<?php

namespace App\Imports;

use App\Models\KeterampilanNonteknis;
use Maatwebsite\Excel\Concerns\ToModel;

class KeterampilanNonteknisImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KeterampilanNonteknis([
            //
        ]);
    }
}
