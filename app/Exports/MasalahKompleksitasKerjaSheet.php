<?php

namespace App\Exports;

use App\Models\MasalahKompleksitasKerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasalahKompleksitasKerjaSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasalahKompleksitasKerja::select(['jenis_jabatan','definisi'])->whereNotNull('jenis_jabatan')->get();
    }
    
    public function headings(): array
    {
        return ['JENIS_JABATAN','DEFINISI'];
    }
    public function title(): string
    {
        return 'Masalah Kompleksitas Kerja';
    }
}
