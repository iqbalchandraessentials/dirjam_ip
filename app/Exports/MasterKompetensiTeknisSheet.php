<?php

namespace App\Exports;

use App\Models\MasterKompetensiTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterKompetensiTeknisSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MasterKompetensiTeknis::all(['kode','nama','name']);
    }

    public function headings(): array
    {
        return ['kode','nama','name'];
    }
}
