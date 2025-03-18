<?php

namespace App\Exports;

use App\Models\KemampuandanPengalaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class KemampuanDanPengalamanSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KemampuandanPengalaman::select(['jenis_jabatan','definisi'])->whereNotNull('jenis_jabatan')->get();
    }
    public function headings(): array
    {
        return ['JENIS_JABATAN','DEFINISI'];
    }
    
    public function title(): string
    {
        return 'Kemampuan dan Pengalaman';
    }
}
