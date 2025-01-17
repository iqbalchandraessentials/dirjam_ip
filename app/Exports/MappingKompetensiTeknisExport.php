<?php

namespace App\Exports;

use App\Models\KeterampilanTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;

class MappingKompetensiTeknisExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KeterampilanTeknis::all([
        'master_jabatan_id',
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori'
    ]);
    }
    // PLNip24#
    public function headings(): array
    {
        return [
        'master_jabatan_id',
        'kode',
        'master_detail_kompetensi_id',
        'level',
        'kategori'];
    }
}
