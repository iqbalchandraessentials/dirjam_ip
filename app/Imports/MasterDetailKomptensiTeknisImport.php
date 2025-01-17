<?php

namespace App\Imports;

use App\Models\MasterDetailKomptensiTeknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterDetailKomptensiTeknisImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MasterDetailKomptensiTeknis([
            'kode_master'=> $row['kode_master'],
            'level'=> $row['level'],
            'perilaku'=> $row['perilaku'],
            'kode_master_level'=> $row['kode_master_level'],
            'created_by'=> Auth::user()->name,
        ]);
    }
    public function rules(): array
    {
        return [
            'kode_master' => 'required|string|max:50|exists:master_kompetensi_teknis,kode',
            'level' => 'required|integer|min:1|max:5',
            'perilaku' => 'required|string',
            'kode_master_level' => 'required|string',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'kode_master.required' => 'Kolom kode_master wajib diisi.',
            'kode_master.exists' => 'Kode master yang diimport tidak valid, pastikan kode tersebut sudah terdaftar di Master Kompetensi Teknis.',
            'level.required' => 'Kolom level wajib diisi.',
            'level.integer' => 'Kolom level harus berupa angka.',
            'level.min' => 'Kolom level minimal bernilai 1.',
            'level.max' => 'Kolom level maksimal bernilai 5.',
            'perilaku.required' => 'Kolom perilaku wajib diisi.',
            'kode_master_level.required' => 'Kolom kode_master_level wajib diisi.',
        ];
    }
}
