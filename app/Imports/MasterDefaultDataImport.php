<?php

namespace App\Imports;

use App\Models\KemampuandanPengalaman;
use App\Models\MasalahKompleksitasKerja;
use App\Models\WewenangJabatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterDefaultDataImport implements WithMultipleSheets
{
    public function __construct()
    {
        // Hapus semua data di tabel MasterKompetensiTeknis dan MasterDetailKompetensiTeknis
        WewenangJabatan::whereNotNull('jenis_jabatan')->delete();
        KemampuandanPengalaman::whereNotNull('jenis_jabatan')->delete();
        MasalahKompleksitasKerja::whereNotNull('jenis_jabatan')->delete();
    }
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            0 => new MasalahKompleksitasKerjaImport(),
            1 => new WewenangJabatanImport(),
            2 => new KemampuanDanPengalamanImport(),
        ];
    }
}
