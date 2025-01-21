<?php

namespace App\Imports;

use App\Models\KeterampilanNonteknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KeterampilanNonteknisImport implements ToModel, WithValidation, WithHeadingRow
{
    public function __construct()
    {
        // Hati-hati dengan truncate, pastikan ini memang diinginkan
        KeterampilanNonteknis::truncate();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KeterampilanNonteknis([
            'kode' => $row['kode'],
            'kategori' => $row['kategori'],
            'jenis' => $row['jenis'],
            'master_jabatan' => $row['master_jabatan'],
            'created_by' => Auth::user()->name,
        ]);
    }
    /**
     * Aturan validasi untuk data.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'master_jabatan' => 'required|string|exists:master_jabatan_unit,master_jabatan',
            'kode' => 'required|string|max:50|exists:master_kompetensi_teknis,kode',
            'kategori' => 'required|string',
        ];
    }

    /**
     * Pesan kustom untuk validasi.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'master_jabatan.required' => 'Kolom master_jabatan wajib diisi.',
            'master_jabatan.exists' => 'Master jabatan yang diimport tidak valid.',
            'kode.required' => 'Kolom kode wajib diisi.',
            'kode.exists' => 'Kode yang diimport tidak valid.',
            'kategori.required' => 'Kolom kategori wajib diisi.',
        ];
    }
}
