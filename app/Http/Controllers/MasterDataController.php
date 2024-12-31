<?php

namespace App\Http\Controllers;

use App\Models\IndikatorOutput;
use App\Models\KemampuandanPengalaman;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterIndikatorOutput;
use App\Models\MasterKompetensiNonteknis;
use App\Models\MasterKompetensiTeknis;
use App\Models\MasterPendidikan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function indikator() {
        $data = MasterIndikatorOutput::get();
        // dd($data);
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

    public function masterKompetensiTeknis() {
        $data = MasterKompetensiTeknis::get();
        // dd($data);
        return view('pages.masterData.kompetensiTeknis.home', ['data' => $data]);
    }
    public function detailMasterKompetensiTeknis($id) {
        $data = MasterKompetensiTeknis::with('level')->find($id);
        // dd($data);
        return view('pages.masterData.kompetensiTeknis.show', ['data' => $data]);
    }


    public function masterKompetensiNonTeknis() {
        $data = MasterKompetensiNonteknis::get();
        
        return view('pages.masterData.kompetensiNonTeknis.home', ['data' => $data]);
    }

    public function pendidikan() {
        $data = MasterPendidikan::get();
        // dd($data);
        return view('pages.masterData.pendidikan.home', ['data' => $data]);
    }

}
