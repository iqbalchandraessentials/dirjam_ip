<?php

namespace Database\Seeders;

use App\Models\MasterJenjangJabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterJenjangJabatanSeeder extends Seeder
{
    /**
     * untuk menjalankan
     * php artisan db:seed --class=MasterJenjangJabatanSeeder
     */
    public function run(): void
    {
        MasterJenjangJabatan::insert([
           ['kode' => 'PL', 'nama' =>	'Pelaksana'],
           ['kode' => 'PS', 'nama' =>	'Pelaksana Senior'],
           ['kode' => 'PD', 'nama' =>	'Penyelia Dasar'],
           ['kode' => 'PA', 'nama' =>	'Penyelia Atas'],
           ['kode' => 'EK', 'nama' =>	'Eksekutif'],
           ['kode' => 'ES', 'nama' =>	'Eksekutif Senior'],
           ['kode' => 'EU', 'nama' =>	'Eksekutif Utama'],
           ['kode' => 'BOD', 'nama' =>	'Board of Director'],
           ['kode' => 'MA', 'nama' =>	'Manajemen Atas'],
           ['kode' => 'MM', 'nama' =>	'Manajemen Menengah'],
           ['kode' => 'MD', 'nama' =>	'Manajemen Dasar'],
           ['kode' => 'SE', 'nama' =>	'Senior Expert'],
           ['kode' => 'EX', 'nama' =>	'Expert'],
           ['kode' => 'JE', 'nama' =>	'Junior Expert'],
           ['kode' => 'SSP', 'nama' =>	'Senior Specialist'],
           ['kode' => 'SPC', 'nama' =>	'Specialist'],
           ['kode' => 'G3', 'nama' =>	'Generalist 3'],
           ['kode' => 'G2', 'nama' =>	'Generalist 2'],
           ['kode' => 'G1', 'nama' =>	'Generalist 1'],
        ]);
    }
}
