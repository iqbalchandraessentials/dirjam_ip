<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class MasterJabatanUnitExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

    }
    public function headings(): array
    {
        return ['MASTER_JABATAN','SITEID'];
    }
}
