<?php

namespace Database\Seeders;

use App\Models\WewenangJabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WewenangJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WewenangJabatan::insert([
            ['definisi' => 'Pengambilan keputusan terkait permasalahan teknis yang dialami di kegiatan sehari-hari, dan tidak berada di luar tanggung jawab yang sudah ditentukan.', 'jenis_jabatan' =>	'struktural'],
            ['definisi' => 'Memberikan rekomendasi terkait ide atau usulan program kerja sesuai tanggung jawab pekerjaan.', 'jenis_jabatan' =>	'struktural'],
            ['definisi' => 'Memberikan rekomendasi terkait ide atau usulan program kerja sesuai tanggung jawab pekerjaan.', 'jenis_jabatan' =>	'fungsional'],
            ['definisi' => 'Mewakili bidang atau bagian sesuai jabatannya', 'jenis_jabatan' =>	'struktural'],
            ['definisi' => 'Mewakili bidang atau bagian sesuai jabatannya', 'jenis_jabatan' =>	'fungsional'],

        ]);
    }
}
