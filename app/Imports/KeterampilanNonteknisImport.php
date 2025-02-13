<?php

namespace App\Imports;

use App\Models\KeterampilanNonteknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class KeterampilanNonteknisImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected $master_jabatan;
    protected $masterKompetensiNonyTeknis;

    public function __construct()
    {
        // Hapus semua data sebelum mengambil referensi dari tabel lain
        KeterampilanNonteknis::truncate();
        
        // Kemudian ambil data referensi dari tabel lain
        $this->master_jabatan = DB::table('master_jabatan')->pluck('master_jabatan')->toArray();
        $this->masterKompetensiNonyTeknis = DB::table('master_kompetensi_nonteknis')->pluck('kode')->toArray();
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
   
    public function rules(): array
    {
        return [
            // 'master_jabatan' => ['required', 'string', function ($attribute, $value, $fail) {
            //     if (!in_array($value, $this->master_jabatan)) {
            //         $fail("The $attribute is invalid.");
            //     }
            // }],
            'kode' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) {
                if (!in_array($value, $this->masterKompetensiNonyTeknis)) {
                    $fail("The $attribute is invalid.");
                }
            }],
            'kategori' => 'required|string',
        ];
    }
    public function batchSize(): int
    {
        return 1000; // Memproses data per 1000 baris
    }

    public function chunkSize(): int
    {
        return 1000; // Membaca file dalam chunk 1000 baris
    }
}
