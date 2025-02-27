<?php

namespace App\Exports;

use App\Models\KeterampilanNonteknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MappingKompetensiNonTeknisExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KeterampilanNonteknis::all([
        'master_jabatan',
        'kode',
        'kategori',
        'jenis']);
    }
    public function headings(): array
    {
        return [
        'master_jabatan',
        'kode',
        'kategori',
        'jenis'];
    }
}
