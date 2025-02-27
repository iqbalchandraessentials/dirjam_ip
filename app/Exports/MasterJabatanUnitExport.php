<?php

namespace App\Exports;

use App\Models\MASTER_JABATAN_UNIT;
use App\Models\ViewUraianJabatan;
use Maatwebsite\Excel\Concerns\FromCollection;

class MasterJabatanUnitExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $data = MASTER_JABATAN_UNIT::select('master_jabatan', 'siteid')->distinct()->get();
    }
    public function headings(): array
    {
        return ['MASTER_JABATAN','SITEID'];
    }
}
