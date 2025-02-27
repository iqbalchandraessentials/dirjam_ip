<?php

namespace Database\Seeders;

use App\Models\KemampuandanPengalaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KemampuandanPengalamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KemampuandanPengalaman::insert([
           ['definisi' => 'Memahami proses bisnis PLN IP secara umum', 'jenis_jabatan' =>	'struktural'],
           ['definisi' => 'Memiliki kemampuan leadership dan dapat berkomunikasi dengan baik', 'jenis_jabatan' =>	'struktural'],
           ['definisi' => 'Memiliki kemampuan berkomunikasi dengan baik', 'jenis_jabatan' =>	'fungsional'],
           ['definisi' => 'Memiliki kemampuan bahasa Inggris (diutamakan aktif)', 'jenis_jabatan' =>	'struktural'],
           ['definisi' => 'Memiliki kemampuan bahasa Inggris Pasif', 'jenis_jabatan' =>	'fungsional'],
        ]);
    }
}
