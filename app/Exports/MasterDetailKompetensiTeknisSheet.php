<?php

namespace App\Exports;

use App\Models\DetailKomptensiTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterDetailKompetensiTeknisSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return DetailKomptensiTeknis::all(['kode_master','level','perilaku','kode_master_level']);
    }

    public function headings(): array
    {
        return ['kode_master','level','perilaku','kode_master_level'];
    }

    public function title(): string
    {
        return 'Master Detail Komptensi Teknis';
    }

}
