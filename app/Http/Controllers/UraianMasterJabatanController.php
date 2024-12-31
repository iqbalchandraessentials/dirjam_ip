<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\UraianMasterJabatan;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF; // Import PDF facade

class UraianMasterJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = MasterJabatan::has('uraianMasterJabatan')->get();
        return view('pages.uraian_jabatan', ['data' => $data]);
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
        $data = UraianMasterJabatan::with(['masterJabatan', 'keterampilanTeknis'])->find($id);

        $data['jabatans'] = ViewUraianJabatan::select('uraian_jabatan_id', 'parent_position_id', 'jabatan', 'position_id', 'NAMA_PROFESI', 'DESCRIPTION', 'JEN', 'ATASAN_LANGSUNG')
        ->where('MASTER_JABATAN', $data['nama'])
        ->get();
    
        $jabatans = $data["jabatans"];
        foreach ($jabatans as $v) {
            $x = ViewUraianJabatan::select(['jabatan', 'type', 'DESCRIPTION', 'BAWAHAN_LANGSUNG', 'TOTAL_BAWAHAN', 'NAMA_PROFESI', 'ATASAN_LANGSUNG'])
                ->where('position_id', $v->position_id)
                ->first();
            $v->jabatan = $x;
        
            // Pastikan method sto menghasilkan HTML
            $v->sto = $this->sto($v['parent_position_id'], $v['position_id']);
        }
    

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
        $data = UraianMasterJabatan::with(['masterJabatan', 'keterampilanTeknis.detailMasterKompetensiTeknis'])->find($id);
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
            'keterampilanTeknis' => $keterampilanTeknis,
            'jabatans' => $jabatans,

        ]);
    }




    public function sto($id = "", $now = "")
{
    // Ambil data jabatan saat ini
    $currentPosition = DB::table('IP_URJAB_ATASAN_LANGSUNG')->where('position_id', $now)->first();

    if (!$currentPosition) {
        return response()->json(['html' => '<p>Data tidak ditemukan.</p>']);
    }

    // Ambil data jabatan anak berdasarkan parent_position_id
    $childPositions = DB::table('IP_URJAB_ATASAN_LANGSUNG')->where('parent_position_id', $now)->get();

    // Proses jabatan struktural
    $structuralPositions = $childPositions->where('jenis_jabatan', 'Struktural')->pluck('child_name', 'position_id');

    $total = $structuralPositions->count();
    $half = floor($total / 2);

    $colspan = ($total % 2 == 0) ? "colspan='2'" : ($total === 2 ? "colspan='3'" : "");
    $cellWidth = $total > 0 ? ceil(100 / $total) : 100;

    $html = "<table style='text-align:center;' cellspacing='0' cellpadding='0'>";

    // Parent Position
    if ($currentPosition->parent_position_id) {
        $html .= "<tr>";
        $html .= $total > 1 ? "<td colspan='$half'></td>" : "";
        $html .= "<td $colspan width='$cellWidth%'>
                    <div style='padding:5px; border:1px solid #ccc; font-size:7px;'>
                        {$currentPosition->parent_name}
                    </div>
                  </td>";
        $html .= $total > 1 ? "<td colspan='$half'></td>" : "";
        $html .= "</tr>";

        $html .= "<tr>";
        $html .= $total > 1 ? "<td colspan='$half'></td>" : "";
        $html .= "<td $colspan>
                    <div style='height:30px; width:1px; margin:auto; background:#ccc;'></div>
                  </td>";
        $html .= $total > 1 ? "<td colspan='$half'></td>" : "";
        $html .= "</tr>";
    }

    // Current Position
    $html .= "<tr>";
    $html .= $total > 1 ? "<td colspan='$half'></td>" : "";
    $html .= "<td $colspan width='$cellWidth%'>
                <div style='padding:5px; border:1px solid #ccc; background:#eaf9fc; font-size:7px;'>
                    {$currentPosition->child_name}
                </div>
              </td>";
    $html .= $total > 1 ? "<td colspan='$half'></td>" : "";
    $html .= "</tr>";

    // Child Positions
    $html .= "<tr>";
    foreach ($structuralPositions as $positionId => $childName) {
        $highlightStyle = ($positionId === $now) ? "background:#c4f5ff;" : "";
        $html .= "<td width='$cellWidth%' valign='top'>
                    <div style='padding:5px; border:1px solid #ccc; font-size:7px; $highlightStyle'>
                        $childName
                    </div>
                  </td>";
    }
    $html .= "</tr>";

    $html .= "</table>";

    return  $html;
}




    public function exportPdf($id)
    {
        $data = UraianMasterJabatan::with('masterJabatan')->find($id);
        $data['jabatans'] = ViewUraianJabatan::select('uraian_jabatan_id', 'jabatan', 'position_id', 'NAMA_PROFESI', 'DESCRIPTION', 'JEN', 'ATASAN_LANGSUNG')->where('MASTER_JABATAN', $data['nama'])->get();

        $jabatans = $data["jabatans"];
        foreach ($jabatans as $v) {
            $x = ViewUraianJabatan::select(['jabatan', 'type', 'DESCRIPTION', 'BAWAHAN_LANGSUNG', 'TOTAL_BAWAHAN', 'NAMA_PROFESI', 'ATASAN_LANGSUNG'])->where('position_id', $v->position_id)->first();
            $v->jabatan = $x;
            $v->sto = $this->sto($v['parent_position_id'], $v['position_id']);
        }
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
            'KeterampilanTeknis' => $KeterampilanTeknis,
            'jabatans' => $jabatans,
        ]);

        // Mengatur filename
        $name = "Uraian-Jabatan-" . $data->nama . date('d-m-Y H-i-s') . ".pdf";
        return $pdf->download($name);
    }

    public function draft($id)
    {
        $data =  MasterJabatan::find($id);
        // dd($data);
        return view('pages.uraian_jabatan_draft',  ['data' => $data]);
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
