<?php

namespace App\Exports;

use App\Models\MasterKompetensiNonteknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterKompetensiNonteknisExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterKompetensiNonteknis::all(['kode','nama','singkatan','jenis','definisi']);
    }
    public function headings(): array
    {
        return ['kode','nama','singkatan','jenis','definisi'];
    }
}
