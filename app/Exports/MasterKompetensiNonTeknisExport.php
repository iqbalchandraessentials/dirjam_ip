<?php

namespace App\Exports;

use App\Models\MasterKompetensiNonTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterKompetensiNonTeknisExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterKompetensiNonTeknis::all(['kode','nama','singkatan','jenis','definisi']);
    }
    public function headings(): array
    {
        return ['kode','nama','singkatan','jenis','definisi'];
    }
}
