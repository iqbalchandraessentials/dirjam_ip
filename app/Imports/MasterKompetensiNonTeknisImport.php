<?php

namespace App\Imports;

use App\Models\MasterKompetensiNonTeknis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterKompetensiNonTeknisImport implements ToModel,WithValidation, WithHeadingRow
{
    public function __construct()
    {
        MasterKompetensiNonTeknis::query()->delete();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Debug isi $row setelah header dikenali
        // dd($row);

        return new MasterKompetensiNonTeknis([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'singkatan' => $row['singkatan'],
            'jenis' => $row['jenis'],
            'definisi' => $row['definisi'],
            'created_by' => Session::get('user')['nama'] ?? 'SYSTEM',
        ]);
    }
    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:50|unique:master_kompetensi_nonteknis,kode',
            'definisi' => 'required|string|min:10',
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
