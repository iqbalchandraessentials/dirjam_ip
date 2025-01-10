<?php

namespace App\Http\Controllers;

use App\Models\M_AKTIVITAS;
use App\Models\M_AKTIVITAS_GENERIK;
use App\Models\M_JABATAN;
use App\Models\M_KEWENANGAN;
use App\Models\M_KEWENANGAN_JABATAN;
use App\Models\M_KOMUNIKASI;
use App\Models\M_MAP_PENDIDIKAN;
use App\Models\M_PENGAMBILAN_KEPUTUSAN;
use App\Models\M_TANTANGAN;
use App\Models\M_URAIAN_JABATAN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UraianJabatanController extends Controller
{

    public function index()
    {
        $jabatans = M_JABATAN::get(); 
        $data['locked'] = false;
        $data["id"] = "";
        $data["exist"] = false;
        $data["data"] = $data;
        return view('pages.uraian_jabatan.index', ['jabatans' => $jabatans]);

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

     public function getPendidikanByJabatanId($id)
    {
        return DB::table('MAP_PENDIDIKAN as mp')
            ->join('pendidikan as p', 'p.pendidikan_id', '=', 'mp.pendidikan_id')
            ->select('mp.*', 'p.*')
            ->where('mp.uraian_jabatan_id', $id)
            ->orderBy('mp.pendidikan_id', 'DESC')
            ->get();
    }


    public function show(string $id)
    {
        $data = M_URAIAN_JABATAN::where('URAIAN_JABATAN_ID', $id)->firstOrFail(); 
        $jabatan = M_JABATAN::where('POSITION_ID', $data->position_id)->firstOrFail();
        $data['aktivitas'] = M_AKTIVITAS::where('uraian_jabatan_id',$id)->get();
        $data['aktivitas_generik'] = M_AKTIVITAS_GENERIK::where('JENIS',$jabatan->type)->get();
        $mapPendidikan = new M_MAP_PENDIDIKAN();
        $data['pendidikan'] = $mapPendidikan->getByJabatan($id);
        $data['komunikasi_internal'] = M_KOMUNIKASI::where('LINGKUP_FLAG', 'internal')->where('URAIAN_JABATAN_ID', $id)->orderBy('URUTAN')->get();
        $data['komunikasi_external'] = M_KOMUNIKASI::where('LINGKUP_FLAG', 'external')->where('URAIAN_JABATAN_ID', $id)->orderBy('URUTAN')->get();
        $data["tantangan"] = M_TANTANGAN::where('URAIAN_JABATAN_ID',$id)->get();
        $data["pengambilan_keputusan"] = M_PENGAMBILAN_KEPUTUSAN::where('URAIAN_JABATAN_ID', $id)->orderBy('URUTAN')->get();
        $kwn = $this->kwn();
        $results = M_KEWENANGAN_JABATAN::with('kewenangan')
            ->where('URAIAN_JABATAN_ID', $id)
            ->get();
        // Kelompokkan hasil berdasarkan TIPE_KEWENANGAN
        $kewenanganData = [];
        foreach ($results as $result) {
            $kewenanganData[$result->TIPE_KEWENANGAN] = $result->kewenangan->JUMLAH_KEWENANGAN ?? "";
        }
        // Siapkan data output
        $data['kwn'] = [];
        foreach ($kwn as $key => $value) {
            $data[$key] = $kewenanganData[$key] ?? "";
        }

        // dd($data);

        return view('pages.uraian_jabatan.show', ['data' => $data, 'jabatan' => $jabatan]);

        // $data["rekomendasi"] = $this->m_rekomendasi->getByJabatan($id);


    }

    public function kwn() {
        return [
            "kewenangan_pengadaan" => "Kewenangan Pengadaan",
            "jumlah_anggaran"      => "Kewenangan Anggaran",
            "nilai_aset"           => "Kewenangan Nilai Asset",
            "ang_op"               => "Kewenangan Anggaran Operasi",
            "ang_cp"               => "Kewenangan Anggaran Investasi",
            "pendapatan"           => "Nilai Pendapatan",
            "labarugi"             => "Laba Rugi",
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
