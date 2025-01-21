<?php

namespace App\Exports;

use App\Models\MASTER_JABATAN_UNIT;
use Maatwebsite\Excel\Concerns\FromCollection;

class MasterJabatanUnitExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MASTER_JABATAN_UNIT::all();
    }
    public function headings(): array
    {
        return ['MASTER_JABATAN','SITEID'];
    }
}
