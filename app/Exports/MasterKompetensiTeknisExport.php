<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterKompetensiTeknisExport implements WithMultipleSheets
{
    use Exportable;
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
