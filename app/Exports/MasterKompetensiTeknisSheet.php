<?php

namespace App\Exports;

use App\Models\MasterKompetensiTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterKompetensiTeknisSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return MasterKompetensiTeknis::all(['kode','nama','name']);
    }

    public function headings(): array
    {
        return ['kode','nama','name'];
    }
    public function title(): string
    {
        return 'Master Kompetensi Teknis';
    }
}
