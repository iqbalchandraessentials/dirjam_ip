<?php

namespace App\Exports;

use App\Models\MasterKompetensiTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterKompetensiTeknisExport implements WithMultipleSheets
{
    /**
     * Return an array of sheets.
     */
    public function sheets(): array
    {
        return [
            new MasterKompetensiTeknisSheet(),
            new MasterDetailKompetensiTeknisSheet(),
        ];
    }
}
