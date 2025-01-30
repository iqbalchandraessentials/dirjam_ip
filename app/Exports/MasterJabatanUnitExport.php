<?php

namespace App\Exports;

use App\Models\ViewUraianJabatan;
use Maatwebsite\Excel\Concerns\FromCollection;

class MasterJabatanUnitExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewUraianJabatan::all();
    }
    public function headings(): array
    {
        return ['MASTER_JABATAN','SITEID'];
    }
}
