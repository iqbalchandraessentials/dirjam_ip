<?php

namespace Database\Seeders;

use App\Models\MasterIndikatorOutput;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterIndikatorOutputSeeder extends Seeder
{
    /**
     * untuk menjalankan
     * php artisan db:seed --class=MasterIndikatorOutputSeeder
     */
    public function run(): void
    {
        MasterIndikatorOutput::insert([
            ['nama' => '%akurasi'],
            ['nama' => '%kesalahan'],
            ['nama' => '%kesesuaian SOP'],
            ['nama' => '%validitas'],
            ['nama' => 'Account'],
            ['nama' => 'Akreditasi'],
            ['nama' => 'Asset APP'],
            ['nama' => 'BBTU'],
            ['nama' => 'BTU'],
            ['nama' => 'Bobot'],
            ['nama' => 'Buah'],
            ['nama' => 'Buah/kVA'],
            ['nama' => 'COD'],
            ['nama' => 'Dokumen'],
            ['nama' => 'GWh'],
            ['nama' => 'HOP'],
            ['nama' => 'Hari/Plg'],
            ['nama' => 'Jam/Unit'],
            ['nama' => 'Jam/kms'],
            ['nama' => 'Jurusan'],
            ['nama' => 'Kajian'],
            ['nama' => 'Kali'],
            ['nama' => 'Kali Koreksi'],
            ['nama' => 'Kali/ plg'],
            ['nama' => 'Kali/100 kms'],
            ['nama' => 'Kali/1000 plg'],
            ['nama' => 'Kali/unit'],
            ['nama' => 'Kategori'],
            ['nama' => 'Kategori Proper'],
            ['nama' => 'Kawasan/Area'],
            ['nama' => 'Kilo Liter'],
            ['nama' => 'Kontrak'],
            ['nama' => 'Lab'],
            ['nama' => 'Laporan'],
            ['nama' => 'Level'],
            ['nama' => 'Lokasi'],
            ['nama' => 'MMBTU'],
            ['nama' => 'MMBTU/KWh'],
            ['nama' => 'MT'],
            ['nama' => 'MVA'],
            ['nama' => 'MVAr'],
            ['nama' => 'MW'],
            ['nama' => 'MWH Jual/Peg'],
            ['nama' => 'MWH Produksi/Peg'],
            ['nama' => 'MWh'],
            ['nama' => 'MWh Jual/Pegawai'],
            ['nama' => 'MWh Salur / Pegawai'],
            ['nama' => 'MWh produksi/ Pegawai'],
            ['nama' => 'Man month'],
            ['nama' => 'Menit/plg'],
            ['nama' => 'Meter kubik'],
            ['nama' => 'Modul'],
            ['nama' => 'Orang'],
            ['nama' => 'Paket'],
            ['nama' => 'Pegawai'],
            ['nama' => 'Pegawai/Bulan'],
            ['nama' => 'Pelaksanaan / Pegawai'],
            ['nama' => 'Penyulang'],
            ['nama' => 'Peralatan'],
            ['nama' => 'Point'],
            ['nama' => 'Project'],
            ['nama' => 'Proyek'],
            ['nama' => 'RLB'],
            ['nama' => 'Rayon'],
            ['nama' => 'Rp (Juta)'],
            ['nama' => 'Rp (Triliun)'],
            ['nama' => 'Rp/Plg'],
            ['nama' => 'Rp/kWh'],
            ['nama' => 'SLO'],
            ['nama' => 'Sertifikasi'],
            ['nama' => 'Set'],
            ['nama' => 'Skala'],
            ['nama' => 'Skor'],
            ['nama' => 'Titik Sambung'],
            ['nama' => 'Ton'],
            ['nama' => 'Tongkang/hari'],
            ['nama' => 'Unit'],
            ['nama' => 'Unit/MVA'],
            ['nama' => 'Unit/MW'],
            ['nama' => 'kCal'],
            ['nama' => 'kCal/MSCF'],
            ['nama' => 'kCal/kWh'],
            ['nama' => 'kCal/kg'],
            ['nama' => 'kVA'],
            ['nama' => 'kali/plg'],
            ['nama' => 'kg/kWh'],
            ['nama' => 'kms'],
        ]);
    }
}
