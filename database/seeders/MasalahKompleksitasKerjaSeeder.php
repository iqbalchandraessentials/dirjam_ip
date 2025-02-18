<?php

namespace Database\Seeders;

use App\Models\MasalahKompleksitasKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasalahKompleksitasKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasalahKompleksitasKerja::insert([
            ['definisi' => 'Perubahan strategi dan regulasi (internal maupun eksternal)', 'jenis_jabatan'	=>'Struktural'],
            ['definisi' => 'Perubahan strategi dan regulasi (internal maupun eksternal)', 'jenis_jabatan'	=>'Fungsional'],
            ['definisi' => 'Faktor eksternal (perubahan teknologi dan regulasi) ', 'jenis_jabatan'	=>'Struktural'],
            ['definisi' => 'Faktor eksternal (perubahan teknologi dan regulasi) ', 'jenis_jabatan'	=>'Fungsional'],
        ]);
    }
}
