<?php

namespace App\Imports;

use App\Models\KeterampilanTeknis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class KeterampilanTeknisImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected $master_jabatan;
    protected $masterKompetensiTeknis;

    public function __construct()
    {
        KeterampilanTeknis::query()->delete();
        $this->master_jabatan = DB::table('v_tm_jabatan')->pluck('master_jabatan')->toArray();
        $this->masterKompetensiTeknis = DB::table('master_kompetensi_teknis')->pluck('kode')->toArray();
    }

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
    
    public function rules(): array
    {
        return [
            'master_jabatan' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!in_array($value, $this->master_jabatan)) {
                    $fail("The $attribute is invalid.");
                }
            }],
            'kode' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) {
                if (!in_array($value, $this->masterKompetensiTeknis)) {
                    $fail("The $attribute is invalid.");
                }
            }],
            'master_detail_kompetensi_id' => 'required|string',
            'level' => 'required|integer|min:1|max:5',
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
