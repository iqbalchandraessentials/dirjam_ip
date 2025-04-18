<?php

namespace App\Imports;

use App\Models\WewenangJabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WewenangJabatanImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $jenis_jabatan = $row['jenis_jabatan'] == 'struktural' ? 'S' : 'F';
        return new WewenangJabatan([
            'jenis_jabatan' => $jenis_jabatan,
            'definisi' => $row['definisi'],
            'created_by' => Session::get('user')['nama'] ?? 'SYSTEM',
        ]);
    }
    public function rules(): array
    {
    return [
        'jenis_jabatan' => 'required|string|in:struktural,fungsional',
        'definisi' => 'required|string',
    ];
    }
    public function customValidationMessages()
    {
        return [
            'jenis_jabatan.required' => 'Kolom jenis jabatan wajib diisi.',
            'jenis_jabatan.in' => 'jenis jabatan yang diimport tidak sesuai.',
            'definisi.required' => 'Kolom jenis jabatan wajib diisi.',
        ];
    }
}
