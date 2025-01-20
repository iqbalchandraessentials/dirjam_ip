<?php

namespace App\Http\Controllers;

use App\Exports\MappingKompetensiNonTeknisExport;
use App\Exports\MappingKompetensiTeknisExport;
use App\Exports\MasterKompetensiNonTeknisExport;
use App\Exports\MasterKompetensiTeknisExport;
use App\Models\IndikatorOutput;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanNonteknis;
use App\Models\KeterampilanTeknis;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MASTER_JABATAN_UNIT;
use App\Models\MasterIndikatorOutput;
use App\Models\MasterKompetensiNonteknis;
use App\Models\MasterKompetensiTeknis;
use App\Models\MasterPendidikan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterDataController extends Controller
{

// input, edit, delete master data 
// export excel uraian jabatan 
// test upload, validation, testing template jabatan
// pengabungan data jabatan existing dengan yang baru import data template
// filter per unit di uraian jabatan

// masterjabatan dihilangkan [oke]
// jenis jabatan diganti kelompok bisnis [oke]
// tugas pokok generik dan output pakai data yang batu dari master mbak suci [okee]
// kemampuan dan pengalaman yang a. (data yang lama) lalu b. c. nya diambil dari master data mbak suci [oke]
// spesifikasi jabatan nya kebalik pengalaman dan bidang studi nya [oke]
// dimensi jabatan disesuaikan dengan data yang ada di master mbak suci



    public function indikator() {
        $data = MasterIndikatorOutput::get();
        // dd($data);
        return view('pages.masterData.indikator.index', ['data' => $data]);
    }
    
    public function tugasPokokGenerik() {
        $data = TugasPokoUtamaGenerik::where('jenis','generik')->get();
        // dd($data);
        return view('pages.masterData.tugasPokokGenerik.index', ['data' => $data]);
    }
    
    public function masalahDanWewenang() {
        $masalahKompleksitasKerja = MasalahKompleksitasKerja::whereNotNull('jenis_jabatan')->get(); 
        $wewenangJabatan = WewenangJabatan::whereNotNull('jenis_jabatan')->get();
        $kemampuandanPengalaman = KemampuandanPengalaman::whereNotNull('jenis_jabatan')->get(); 
        return view('pages.masterData.masalahDanWewenang.index', [
            'masalahKompleksitasKerja' => $masalahKompleksitasKerja,
            'wewenangJabatan' => $wewenangJabatan,
            'kemampuandanPengalaman' => $kemampuandanPengalaman,
        ]);
    }

    public function masterKompetensiTeknis() {
        $data = MasterKompetensiTeknis::get();
        // dd($data);
        return view('pages.masterData.kompetensiTeknis.index', ['data' => $data]);
    }
    public function detailMasterKompetensiTeknis($id) {
        $data = MasterKompetensiTeknis::with('level')->find($id);
        // dd($data);
        return view('pages.masterData.kompetensiTeknis.show', ['data' => $data]);
    }
    public function exportMasterKompetensiTeknis()
    {
        return Excel::download(new MasterKompetensiTeknisExport, 'Master_Kompentensi_Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMappingKompetensiTeknis()
    {
        return Excel::download(new MappingKompetensiTeknisExport, 'Mapping_Kompentensi_Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMappingKompetensiNonTeknis()
    {
        return Excel::download(new MappingKompetensiNonTeknisExport, 'Mapping_Kompentensi_Non_Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }

    public function mappingkomptensiTeknis() {
        $data = KeterampilanTeknis::with('master')->get();
        return view('pages.masterData.kompetensiTeknis.mapping', ['data' => $data]);
    }
    public function masterKompetensiNonTeknis() {
        $data = MasterKompetensiNonteknis::get();
        return view('pages.masterData.kompetensiNonTeknis.index', ['data' => $data]);
    }
    public function exportMasterKompetensiNonTeknis()
    {
        return Excel::download(new MappingKompetensiNonTeknisExport, 'Mapping_Kompentensi_Non_Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function mappingkomptensiNonTeknis() {
        $data = KeterampilanNonteknis::get();
        return view('pages.masterData.kompetensiNonTeknis.mapping', ['data' => $data]);
    }
    public function pendidikan() {
        $data = MasterPendidikan::get();
        // dd($data);
        return view('pages.masterData.pendidikan.index', ['data' => $data]);
    }
    public function masterJabatan() {
        $data = MASTER_JABATAN_UNIT::get();
        // dd($data);
        return view('pages.masterData.masterJabatanUnit.index', ['data' => $data]);
    }


}
