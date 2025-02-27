<?php

namespace App\Imports;

use App\Models\MasterKompetensiTeknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterKompetensiTeknisImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MasterKompetensiTeknis([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'name' => $row['name'],
            'created_by' => Auth::user()->name,
        ]);
    }
    public function rules(): array
    {
    return ['kode' => 'required|string|max:50|unique:master_kompetensi_teknis,kode',];
    }
    public function customValidationMessages()
    {
        return [
            'kode.required' => 'Kolom kode wajib diisi.',
            'kode.unique' => 'Kode master yang diimport tidak unique.',
        ];
    }
}
