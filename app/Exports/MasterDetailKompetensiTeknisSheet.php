<?php

namespace App\Exports;

use App\Models\MasterDetailKomptensiTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterDetailKompetensiTeknisSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MasterDetailKomptensiTeknis::all(['kode_master','level','perilaku','kode_master_level']);
    }

    public function headings(): array
    {
        return ['kode_master','level','perilaku','kode_master_level'];
    }
}
