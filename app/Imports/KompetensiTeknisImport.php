<?php

namespace App\Imports;

use App\Models\MasterDetailKomptensiTeknis;
use App\Models\MasterKompetensiTeknis;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KompetensiTeknisImport implements WithMultipleSheets
{
    public function __construct()
    {
        // Hapus semua data di tabel MasterKompetensiTeknis dan MasterDetailKompetensiTeknis
        MasterKompetensiTeknis::truncate();
        MasterDetailKomptensiTeknis::truncate();
    }

    public function sheets(): array
    {
        return [
            // Sheet pertama di-handle oleh MasterKompetensiTeknisImport
            0 => new MasterKompetensiTeknisImport(),

            // Sheet kedua di-handle oleh MasterDetailKompetensiTeknisImport
            1 => new MasterDetailKomptensiTeknisImport(),
        ];
    }
}