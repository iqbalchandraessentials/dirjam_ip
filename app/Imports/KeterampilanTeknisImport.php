<?php

namespace App\Imports;

use App\Models\KeterampilanTeknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KeterampilanTeknisImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
     * Konstruksi kelas, truncate table jika diperlukan.
     */
    public function __construct()
    {
        // Hati-hati dengan truncate, pastikan ini memang diinginkan
        KeterampilanTeknis::truncate();
    }

    /**
     * Memasukkan data ke model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new KeterampilanTeknis([
            'master_jabatan' => $row['master_jabatan'],
            'kode' => $row['kode'],
            'level' => $row['level'],
            'master_detail_kompetensi_id' => $row['master_detail_kompetensi_id'],
            'kategori' => $row['kategori'],
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
            'master_detail_kompetensi_id' => 'required|string',
            'level' => 'required|integer|min:1|max:5',
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
            'master_detail_kompetensi_id.required' => 'Kolom master_detail_kompetensi_id wajib diisi.',
            'master_detail_kompetensi_id.exists' => 'Master detail kompetensi yang diimport tidak valid.',
            'level.required' => 'Kolom level wajib diisi.',
            'level.integer' => 'Kolom level harus berupa angka.',
            'level.min' => 'Kolom level minimal bernilai 1.',
            'level.max' => 'Kolom level maksimal bernilai 5.',
            'kategori.required' => 'Kolom kategori wajib diisi.',
        ];
    }
}
