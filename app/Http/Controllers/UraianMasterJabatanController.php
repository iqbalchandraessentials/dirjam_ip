<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\UraianMasterJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use PDF; // Import PDF facade

class UraianMasterJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = MasterJabatan::has('uraianMasterJabatan')->get();
        return view('pages.uraian_jabatan', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    function getRelatedOrFallback($data, $relation, $fallbackModel, $conditions = [])
    {
        if (isset($data->uraianMasterJabatan)) {
            $firstRelation = $data->uraianMasterJabatan->$relation ?? null;
            if ($firstRelation && isset($firstRelation)) {
                return $firstRelation;
            }
        }

        return $fallbackModel::where($conditions)->get();
    }

    public function show($id)
    {
        $data = UraianMasterJabatan::with(['masterJabatan','keterampilanTeknis'])->find($id);
        // dd($data);
        $tugaspokokGenerik = TugasPokoUtamaGenerik::where('jenis', 'generik')->where('jenis_jabatan', $data->masterJabatan->jenis_jabatan)->get();      
        $masalahKompleksitasKerja = isset($data)  && $data->masalahKompleksitasKerja->isNotEmpty()
        ? $data->masalahKompleksitasKerja
        : MasalahKompleksitasKerja::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $wewenangJabatan = isset($data)  && $data->wewenangJabatan->isNotEmpty()
        ? $data->wewenangJabatan
        : WewenangJabatan::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $kemampuandanPengalaman = isset($data)  && $data->kemampuandanPengalaman->isNotEmpty()
        ? $data->kemampuandanPengalaman
        : KemampuandanPengalaman::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $data = UraianMasterJabatan::with(['masterJabatan','keterampilanTeknis.detailMasterKompetensiTeknis'])->find($id);
        $core = $data->keterampilanTeknisCore;
        $enabler = $data->keterampilanTeknisEnabler;
        $keterampilanTeknis = $core->merge($enabler);

      
        // dd($keterampilanTeknis);

        return view('pages.home', [
        'data' => $data,
        'tugaspokokGenerik' => $tugaspokokGenerik,
        'masalahKompleksitasKerja' => $masalahKompleksitasKerja,
        'wewenangJabatan' => $wewenangJabatan,
        'kemampuandanPengalaman' => $kemampuandanPengalaman,
        'keterampilanTeknis' => $keterampilanTeknis
    ]);
    }


    public function exportPdf($id)
    {
        $data = UraianMasterJabatan::with('masterJabatan')->find($id);
        // dd($data);
        $tugaspokokGenerik = TugasPokoUtamaGenerik::where('jenis', 'generik')->where('jenis_jabatan', $data->jenis_jabatan)->get();      
        $masalahKompleksitasKerja = isset($data)  && $data->masalahKompleksitasKerja->isNotEmpty()
        ? $data->masalahKompleksitasKerja
        : MasalahKompleksitasKerja::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $wewenangJabatan = isset($data)  && $data->wewenangJabatan->isNotEmpty()
        ? $data->wewenangJabatan
        : WewenangJabatan::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $kemampuandanPengalaman = isset($data)  && $data->kemampuandanPengalaman->isNotEmpty()
        ? $data->kemampuandanPengalaman
        : KemampuandanPengalaman::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $core = $data->keterampilanTeknisCore;
        $enabler = $data->keterampilanTeknisEnabler;
        $KeterampilanTeknis = $core->merge($enabler);

        // Membuat PDF dari view
        $pdf = PDF::loadView('pages.pdf_report', [
            'data' => $data,
            'tugaspokokGenerik' => $tugaspokokGenerik,
            'masalahKompleksitasKerja' => $masalahKompleksitasKerja,
            'wewenangJabatan' => $wewenangJabatan,
            'kemampuandanPengalaman' => $kemampuandanPengalaman,
            'KeterampilanTeknis' => $KeterampilanTeknis
        ]);

        // Mengatur filename
        $name = "Uraian-Jabatan-". $data->nama . date('d-m-Y H-i-s') . ".pdf";
        return $pdf->download($name);
    }
    
    public function draft($id) {
        $data =  MasterJabatan::find($id);
        // dd($data);
        return view('pages.uraian_jabatan_draft',  ['data'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UraianMasterJabatan $uraianMasterJabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UraianMasterJabatan $uraianMasterJabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UraianMasterJabatan $uraianMasterJabatan)
    {
        //
    }
}
