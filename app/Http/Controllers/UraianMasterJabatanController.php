<?php

namespace App\Http\Controllers;

use App\Models\KeterampilanTeknis;
use App\Models\UraianMasterJabatan;
use Illuminate\Http\Request;

class UraianMasterJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = UraianMasterJabatan::get();
    //     $data = UraianMasterJabatan::with([
    //     'tugasPokoUtamaGenerik',
    //     'hubunganKerja',
    //     'masalahKompleksitasKerja',
    //     'wewenangJabatan',
    //     'spesifikasiPendidikan',
    //     'kemampuandanPengalaman',
    //     'keterampilanNonteknis',
    //     'KeterampilanTeknis',
    // ])->get();
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
    public function show($id)
    {
        $data = UraianMasterJabatan::with([
        'tugasPokoUtamaGenerik',
        'hubunganKerja',
        'masalahKompleksitasKerja',
        'wewenangJabatan',
        'spesifikasiPendidikan',
        'kemampuandanPengalaman',
        'keterampilanNonteknis',
        'KeterampilanTeknis',
        ])->where('id', $id)->first();        
        return view('pages.home', ['data'=>$data]);
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
