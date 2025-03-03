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

class KeterampilanNonteknisImport implements ToModel, WithValidation, WithHeadingRow
{
    protected $master_jabatan;
    protected $masterKompetensiNonTeknis;

    // public function __construct()
    // {
    //     KeterampilanNonteknis::truncate();
        
    //     $this->master_jabatan = DB::table('mst_jabatan')->pluck('master_jabatan')->toArray();
    //     $this->masterKompetensiNonTeknis = DB::table('master_kompetensi_nonteknis')->pluck('kode')->toArray();
    // }
    
    public function model(array $row)
    {
        return new KeterampilanNonteknis([
            'kode' => $row['kode'],
            'kategori' => $row['kategori'],
            'jenis' => $row['jenis'],
            'master_jabatan' => $row['master_jabatan'],
            'created_by' => Auth::user()->name ?? 'system',
        ]);
    }

   
    public function rules(): array
    {
        return [
            'kategori' => 'required|string',
        ];
    }

}