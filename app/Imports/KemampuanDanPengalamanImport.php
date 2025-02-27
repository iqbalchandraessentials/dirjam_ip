<?php

namespace App\Imports;

use App\Models\KemampuanDanPengalaman;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KemampuanDanPengalamanImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KemampuanDanPengalaman([
            'jenis_jabatan' => $row['jenis_jabatan'],
            'definisi' => $row['definisi'],
            'created_by' => Auth::user()->name,
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
