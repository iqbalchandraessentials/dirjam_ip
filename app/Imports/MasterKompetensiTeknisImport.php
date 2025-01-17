<?php

namespace App\Imports;

use App\Models\MasterKompetensiTeknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterKompetensiTeknisImport implements ToModel, WithHeadingRow
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
        return [
            'kode' => 'required|string|max:50|unique',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'kode.required' => 'Kolom kode wajib diisi.',
            'kode.unique' => 'Kode master yang diimport tidak unique.',
        ];
    }
}
