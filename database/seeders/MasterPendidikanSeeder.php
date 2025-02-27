<?php

namespace Database\Seeders;

use App\Models\MasterPendidikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterPendidikanSeeder extends Seeder
{
    /**
     * untuk menjalankan
     * php artisan db:seed --class=MasterPendidikanSeeder
     */
    public function run(): void
    {
        MasterPendidikan::insert([
            ['nama' => 'SMK/STM', 'pengalaman' => '9','jenjang_jabatan' => 'MD',	'created_by' => 'iqbal.chandra'],
            ['nama' => 'SMK/STM', 'pengalaman' => '6','jenjang_jabatan' => 'G2',	'created_by' => 'iqbal.chandra'],
            ['nama' => 'SMK/STM','pengalaman' => '4.5','jenjang_jabatan' => 'G1','created_by' => 'iqbal.chandra',],
            ['nama' => 'SMK/STM', 'pengalaman' => '7.5','jenjang_jabatan' => 'G3',	'created_by' => 'iqbal.chandra'],
            ['nama' => 'D3', 'pengalaman' => '3', 'jenjang_jabatan' => 'G2', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'D3', 'pengalaman' => '7.5'	,'jenjang_jabatan' => 'MM',	'created_by' => 'iqbal.chandra'],
            ['nama' => 'D3', 'pengalaman' => '6', 'jenjang_jabatan' => 'MD', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'D3', 'pengalaman' => '0', 'jenjang_jabatan' => 'G1', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'D3', 'pengalaman' => '4.5', 'jenjang_jabatan' => 'G3', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '0', 'jenjang_jabatan' => 'G1', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '3', 'jenjang_jabatan' => 'G3', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '6', 'jenjang_jabatan' => 'MM', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '4.5'	,'jenjang_jabatan' => 'MD',	'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '7.5'	,'jenjang_jabatan' => 'MA',	'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '6', 'jenjang_jabatan' => 'MM', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S1', 'pengalaman' => '0', 'jenjang_jabatan' => 'G2', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S2', 'pengalaman' => '0', 'jenjang_jabatan' => 'G2', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S2', 'pengalaman' => '3', 'jenjang_jabatan' => 'MD', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S2', 'pengalaman' => '1.5', 'jenjang_jabatan' => 'G3', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S2', 'pengalaman' => '6', 'jenjang_jabatan' => 'MA', 'created_by' => 'iqbal.chandra'],
            ['nama' => 'S2', 'pengalaman' => '4.5'	,'jenjang_jabatan' => 'MM',	'created_by' => 'iqbal.chandra'],
        ]);
    }
}
