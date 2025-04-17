<?php

namespace App\Exports;

use App\Models\MappingTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MappingKompetensiTeknisExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MappingTeknis::whereNotNull('master_jabatan')->get([
            'master_jabatan',
            'kode',
            'level',
            'master_detail_kompetensi_id',
            'kategori'
        ]);
    }
    // PLNip24#
    public function headings(): array
    {
        return [
        'master_jabatan',
        'kode',
        'level',
        'master_detail_kompetensi_id',
        'kategori'
        ];
    }
}
