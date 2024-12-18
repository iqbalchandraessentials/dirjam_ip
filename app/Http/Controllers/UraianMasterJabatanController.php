<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\UraianMasterJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;

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
        $data = MasterJabatan::with('uraianMasterJabatan')->find($id);
        $tugaspokokGenerik = TugasPokoUtamaGenerik::where('jenis', 'generik')->where('jenis_jabatan', $data->jenis_jabatan)->get();      
        $masalahKompleksitasKerja = isset($data->uraianMasterJabatan)  && $data->uraianMasterJabatan->masalahKompleksitasKerja->isNotEmpty()
        ? $data->uraianMasterJabatan->masalahKompleksitasKerja
        : MasalahKompleksitasKerja::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $wewenangJabatan = isset($data->uraianMasterJabatan)  && $data->uraianMasterJabatan->wewenangJabatan->isNotEmpty()
        ? $data->uraianMasterJabatan->wewenangJabatan
        : WewenangJabatan::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $kemampuandanPengalaman = isset($data->uraianMasterJabatan)  && $data->uraianMasterJabatan->kemampuandanPengalaman->isNotEmpty()
        ? $data->uraianMasterJabatan->kemampuandanPengalaman
        : KemampuandanPengalaman::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $KeterampilanTeknis = $data->uraianMasterJabatan->first()->keterampilanTeknis;
        return view('pages.home', [
        'data' => $data,
        'tugaspokokGenerik' => $tugaspokokGenerik,
        'masalahKompleksitasKerja' => $masalahKompleksitasKerja,
        'wewenangJabatan' => $wewenangJabatan,
        'kemampuandanPengalaman' => $kemampuandanPengalaman,
        'KeterampilanTeknis' => $KeterampilanTeknis
    ]);
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
