<?php

namespace App\Http\Controllers;

use App\Models\IndikatorOutput;
use App\Models\KemampuandanPengalaman;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterIndikatorOutput;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function indikator() {
        $data = MasterIndikatorOutput::get();
        return view('pages.masterData.indikator.home', ['data' => $data]);
    }
    
    public function tugasPokokGenerik() {
        $data = TugasPokoUtamaGenerik::where('jenis','generik')->get();
        // dd($data);
        return view('pages.masterData.tugasPokokGenerik.home', ['data' => $data]);
    }
    
    public function masalahDanWewenang() {
        $masalahKompleksitasKerja = MasalahKompleksitasKerja::whereNotNull('jenis_jabatan')->get(); 
        $wewenangJabatan = WewenangJabatan::whereNotNull('jenis_jabatan')->get(); 
        $kemampuandanPengalaman = KemampuandanPengalaman::whereNotNull('jenis_jabatan')->get(); 
        return view('pages.masterData.masalahDanWewenang.home', [
            'masalahKompleksitasKerja' => $masalahKompleksitasKerja,
            'wewenangJabatan' => $wewenangJabatan,
            'kemampuandanPengalaman' => $kemampuandanPengalaman,
        ]);
    }


}
