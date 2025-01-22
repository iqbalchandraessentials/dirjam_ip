<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MasterDataController extends Controller
{

// input, edit, delete master data 
// export excel uraian jabatan 
// pengabungan data jabatan existing dengan yang baru import data template
// filter per unit di uraian jabatan

// test upload, validation, testing template jabatan [oke]
// masterjabatan dihilangkan [oke]
// jenis jabatan diganti kelompok bisnis [oke]
// tugas pokok generik dan output pakai data yang batu dari master mbak suci [okee]
// kemampuan dan pengalaman yang a. (data yang lama) lalu b. c. nya diambil dari master data mbak suci [oke]
// spesifikasi jabatan nya kebalik pengalaman dan bidang studi nya [oke]
// dimensi jabatan disesuaikan dengan data yang ada di master mbak suci [oke]



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
    public function TugasPokokGenerikStore(Request $request) {
        // dd($request->all());
        $request->validate([
            'aktivitas' => 'required|string',
            'output' => 'required|string',
            'jenis_jabatan' => 'required|string',
            
        ]);
        TugasPokoUtamaGenerik::create([
            'aktivitas' => $request->aktivitas,
            'output' => $request->output,
            'jenis_jabatan' => $request->jenis_jabatan,
            'jenis' => $request->jenis,
            'created_by' => Auth::user()->nama,
        ]);
        return redirect()->route('master.tugasPokokGenerik')->with('success', 'Data berhasil ditambahkan.');
    }
    public function TugasPokokGenerikUpdate(Request $request)
    {
        $request->validate([
            'aktivitas' => 'required|string',
            'output' => 'required|string',
            'jenis_jabatan' => 'required|string',
        ]);

        $data = TugasPokoUtamaGenerik::findOrFail($request->id);
        $data->update([
            'aktivitas' => $request->aktivitas,
            'output' => $request->output,
            'jenis_jabatan' => $request->jenis_jabatan,
            'jenis' => $request->jenis,
            'created_by' => Auth::user()->nama,
        ]);
        return redirect()->route('master.tugasPokokGenerik')->with('success', 'Data berhasil diperbarui.');
    }
    public function TugasPokokGenerikDestroy(Request $request)
    {
        $data = TugasPokoUtamaGenerik::findOrFail($request->id);;
        $data->delete();
        return redirect()->route('master.tugasPokokGenerik')->with('success', 'Data berhasil dihapus.');
    }
    
    public function defaultMasterData() {
        $masalahKompleksitasKerja = MasalahKompleksitasKerja::whereNotNull('jenis_jabatan')->get(); 
        $wewenangJabatan = WewenangJabatan::whereNotNull('jenis_jabatan')->get();
        $kemampuandanPengalaman = KemampuandanPengalaman::whereNotNull('jenis_jabatan')->get(); 
        return view('pages.masterData.defaultMasterData.index', [
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
    public function masterKompetensiNonTeknis() {
        $data = MasterKompetensiNonteknis::get();
        return view('pages.masterData.kompetensiNonTeknis.index', ['data' => $data]);
    }
   
    public function mappingkomptensiNonTeknis(Request $request)
    {
        if ($request->ajax()) {
            $data = KeterampilanNonteknis::with('detail')->select('keterampilan_nonteknis.*');
            return DataTables::of($data)
                ->addColumn('nama_kompetensi', function ($row) {
                    return $row->detail->nama ?? '-';
                })
                ->make(true);
        }

        return view('pages.masterData.kompetensiNonTeknis.mapping');
    }
    public function mappingkomptensiTeknis(Request $request)
    {
        if ($request->ajax()) {
            $data = KeterampilanTeknis::with('master')->select('keterampilan_teknis.*');
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan ini untuk menambahkan nomor indeks ke data
                ->editColumn('master_jabatan', function ($row) {
                    return $row['master_jabatan'] ?: ($row['uraianJabatan']['nama'] ?? '-');
                })
                ->editColumn('master.nama', function ($row) {
                    return strtoupper($row->master->nama ?? '-');
                })
                ->make(true);
        }
    
        return view('pages.masterData.kompetensiTeknis.mapping');
    }
   
    public function masterJabatan(Request $request)
    {
        if ($request->ajax()) {
            $data = MASTER_JABATAN_UNIT::select('master_jabatan', 'siteid');
            return DataTables::of($data)
                ->addIndexColumn() // Menambahkan kolom nomor urut
                ->make(true);
        }
        return view('pages.masterData.masterJabatanUnit.index');
    }
    
    public function pendidikan() {
        $data = MasterPendidikan::get();
        // dd($data);
        return view('pages.masterData.pendidikan.index', ['data' => $data]);
    }
     // Menyimpan data baru
     public function createPendidikan(Request $request)
     {
         $request->validate([
             'nama' => 'required|string',
             'pengalaman' => 'required|string',
             'jenjang_jabatan' => 'required|string',
         ]);
 
         MasterPendidikan::create([
             'nama' => $request->nama,
             'pengalaman' => $request->pengalaman,
             'jenjang_jabatan' => $request->jenjang_jabatan,
             'created_by' => Auth::user()->nama,
         ]);
 
         return redirect()->route('master.pendidikan')->with('success', 'Data pendidikan berhasil ditambahkan.');
     }
 
     // Memperbarui data
     public function updatePendidikan(Request $request)
     {
         $request->validate([
             'nama' => 'required|string',
             'pengalaman' => 'required|string',
             'jenjang_jabatan' => 'required|string',
         ]);
 
         $pendidikan = MasterPendidikan::findOrFail($request->id);
         $pendidikan->update([
             'nama' => $request->nama,
             'pengalaman' => $request->pengalaman,
             'jenjang_jabatan' => $request->jenjang_jabatan,
             'created_by' => Auth::user()->nama,
         ]);
 
         return redirect()->route('master.pendidikan')->with('success', 'Data pendidikan berhasil diupadate.');
     }
 
     // Menghapus data
     public function deletePendidikan(Request $request)
     {
         $pendidikan = MasterPendidikan::findOrFail($request->id);
         $pendidikan->delete();
 
         return redirect()->route('master.pendidikan')->with('success', 'Data pendidikan berhasil dihapus.');
     }
   


}
