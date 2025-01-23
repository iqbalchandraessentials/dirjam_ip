<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\MasterPendidikan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\UraianMasterJabatan;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class TemplateJabatanController extends Controller
{
    
    public function index()
    {
        $data = MasterJabatan::has('uraianMasterJabatan')->get();
        return view('pages.template.index', ['data' => $data]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $data = $this->getDatas($id);
        return view('pages.template.show', [
            'data' => $data,
        ]);
    }

    public function draft($id)
    {
        $data =  MasterJabatan::find($id);
        // dd($data);
        return view('pages.template.draft',  ['data' => $data]);
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

    public function getDatas($id){
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
        }
        $data['struktur_organisasi'] = $this->sto($jabatans[0]['parent_position_id'], $jabatans[0]['position_id']);
        $data['tugas_pokok_generik'] = TugasPokoUtamaGenerik::where('jenis', 'generik')
            ->where('jenis_jabatan', $data->masterJabatan->jenis_jabatan)
            ->get();
        $data['masalah_kompleksitas_kerja'] = isset($data) && $data->masalahKompleksitasKerja->isNotEmpty()
            ? $data->masalahKompleksitasKerja
            : MasalahKompleksitasKerja::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $data['wewenang_jabatan'] = isset($data) && $data->wewenangJabatan->isNotEmpty()
            ? $data->wewenangJabatan
            : WewenangJabatan::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $data['kemampuan_dan_pengalaman'] = isset($data) && $data->kemampuandanPengalaman->isNotEmpty()
            ? $data->kemampuandanPengalaman
            : KemampuandanPengalaman::where('jenis_jabatan', $data->jenis_jabatan)->get();
        $core = $data->keterampilanTeknisCore;
        $enabler = $data->keterampilanTeknisEnabler;
        $data['keterampilan_teknis'] = $core->merge($enabler);
        $data['spesifikasiPendidikan'] = $data['spesifikasiPendidikan'];
        foreach ($data['spesifikasiPendidikan'] as $key => $item) {
            $masterPendidikan = MasterPendidikan::where('nama', $item['pendidikan'])
                ->where('jenjang_jabatan', $data['jabatans'][0]['jen'])
                ->first();
            
            // Menambahkan pengalaman ke dalam array
            $data['spesifikasiPendidikan'][$key]['pengalaman'] = $masterPendidikan ? $masterPendidikan->pengalaman : '-';
        }
        return $data;
    }

    public function sto($id = "", $now = "")
    {
        $query = DB::table('IP_URJAB_ATASAN_LANGSUNG')
            ->where('position_id', $now)
            ->first();

        if ($query && $query->jenis_jabatan == "Struktural") {
            $childQuery = DB::table('IP_URJAB_ATASAN_LANGSUNG')
                ->where('parent_position_id', $now)
                ->get();

            $jabatans = [];
            foreach ($childQuery as $key) {
                if ($key->jenis_jabatan == "Struktural") {
                    $jabatans[$key->position_id] = $key->child_name;
                }
            }

            $query2 = DB::table('IP_URJAB_ATASAN_LANGSUNG')
                ->where('position_id', $now)
                ->first();

            $n = count($jabatans);
            $m = floor($n / 2);

            $jns = $n % 2 == 0 ? "genap" : "ganjil";
            $m = $jns == "genap" ? $m - 1 : $m;
            $head = $jns == "genap" ? "colspan='2'" : ($n == 2 ? "colspan='3'" : "");
            $width = $n > 0 ? ceil(100 / $n) : 100;

            $html = "";
            if ($query2) {
                $html .= "<table style='text-align:center;' cellspacing='0' cellpadding='0'>";

                if ($query2->parent_position_id != "") {
                    $html .= "<tr>";
                    $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                    $html .= "<td $head width='$width%'>";
                    $html .= "<div style='padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px;'>";
                    $html .= $query2->parent_name;
                    $html .= "</div></td>";
                    $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                    $html .= "</tr>";

                    $html .= "<tr>";
                    $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                    $html .= "<td $head><div><div style='height:30px; width:1px; margin:0 auto; background:#ccc'></div></div></td>";
                    $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                    $html .= "</tr>";
                }

                $html .= "<tr>";
                $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                $html .= "<td $head width='$width%'>";
                $html .= "<div style='padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; background:#eaf9fc; font-size:7px'>";
                $html .= $query2->child_name;
                $html .= "</div></td>";
                $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                $html .= "</tr>";
                $html .= "<tr>";
                $x = 0;
                $posz = [];

                foreach ($childQuery as $key) {
                    if ($key->jenis_jabatan != "Struktural") {
                        $style = $key->position_id == $now
                            ? "font-weight:bold; text-decoration:underline"
                            : "";
                        $posz[] = "<li style='text-align:left; font-size:7px; $style'>{$key->child_name}</li>";
                        $x++;
                    }
                }

                $wid = $x > 3 ? (($x - 3) * 8) + 30 : 30;

                $html .= "<td $head><div><div style='height:{$wid}px; width:1px; margin:0 auto; background:#ccc'>";
                if ($n == 0 && $posz) {
                    $html .= "<div style='position:absolute;width:300px'><ol style='margin-left:-20px;'>";
                    $html .= implode('', $posz);
                    $html .= "</ol></div>";
                }
                $html .= "</div></div></td>";

                if ($n > 1) {
                    $html .= "<td colspan='$m'><div><ol style='margin-left:-80px;'>";
                    $html .= implode('', $posz);
                    $html .= "</ol></div></td>";
                }
                $html .= "</tr>";

                $html .= "<tr>";
                $i = 1;
                foreach ($childQuery as $key) {
                    if ($key->jenis_jabatan == "Struktural") {
                        $html .= "<td width='$width%' valign='top'>";
                        $html .= "<table cellspacing='0' cellpadding='0' style='height:30px; width:100%;'>";
                        $html .= "<tr>";
                        $html .= $i == 1
                            ? "<td width='50%'>&nbsp;</td>"
                            : "<td width='50%' style='border-top: 1px #ccc solid; text-align:right'>&nbsp;</td>";
                        $html .= $i == $n
                            ? "<td width='50%' style='border-left: 1px #ccc solid;'>&nbsp;</td>"
                            : "<td width='50%' style='border-top: 1px #ccc solid; border-left: 1px #ccc solid'>&nbsp;</td>";
                        $html .= "</tr></table></td>";
                        $i++;
                    }
                }
                $html .= "</tr>";

                $html .= "<tr>";
                foreach ($childQuery as $key) {
                    if ($key->jenis_jabatan == "Struktural") {
                        $style = $key->position_id == $now
                            ? "background:#c4f5ff"
                            : "";
                        $html .= "<td width='$width%' valign='top'>";
                        $html .= "<div style='padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px; $style'>";
                        $html .= $key->child_name;
                        $html .= "</div></td>";
                    }
                }
                $html .= "</tr>";
                $html .= "</table>";
            }

            return $html;
        } else
            // Ambil data jabatan berdasarkan parent_position_id
            $q = DB::table('IP_URJAB_ATASAN_LANGSUNG')->where('parent_position_id', $id)->get();

        $jabatans = [];

        // Loop untuk menentukan jabatan struktural
        foreach ($q as $key) {
            if ($key->jenis_jabatan == 'Struktural') {
                $jabatans[$key->position_id] = $key->child_name;
            }
        }

        // Ambil data berdasarkan position_id
        $q2 = DB::table('IP_URJAB_ATASAN_LANGSUNG')->where('position_id', $now)->first();

        // Tentukan nilai n dan m untuk pengaturan tabel
        $n = count($jabatans);
        $m = floor($n / 2);

        $jns = ($n % 2 == 0) ? 'genap' : 'ganjil';
        $m = ($jns == 'genap') ? $m - 1 : $m;
        $head = ($jns == 'genap') ? "colspan='2'" : ($n == 2 ? "colspan='3'" : "");

        $max = 1000;
        $width = $n > 0 ? ceil(100 / $n) : 100;
        $s = $n == 2 ? "colspan='2'" : '';

        $html = "";

        if ($q2) {
            $html .= "<table style='text-align:center;' cellspacing='0' cellpadding='0'>";

            // Tampilan posisi PARENT
            if ($q2->parent_position_id != "") {
                $html .= "<tr>";
                $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                $html .= "<td $head width='$width%'>";
                $html .= "<div style='padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px; '>";
                $html .= $q2->parent_name;
                $html .= "</div>";
                $html .= "</td>";
                $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                $html .= "</tr>";

                $html .= "<tr>";
                $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                $html .= "<td $head><div><div style='height:10px; width:1px; margin:0 auto; background:#ccc'></div></div></td>";
                $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                $html .= "</tr>";
            }

            $html .= "<tr>";
            $html .= $n > 1 ? "<td colspan='$m'></td>" : "";

            // Menginisiasi fungsi untuk posisi fungsional
            $x = 0;
            $posz = [];

            foreach ($q as $key) {
                if ($key->jenis_jabatan != 'Struktural') {
                    $html2 = $key->position_id == $now
                        ? "<li style='text-align:left; font-weight:bold; font-size:7px; text-decoration:underline'>"
                        : "<li style='text-align:left; font-size:7px'>";

                    $html2 .= $key->child_name;
                    $html2 .= "</li>";
                    $posz[] = $html2;
                    $x++;
                }
            }

            $wid = $x > 3 ? (($x - 3) * 8) + 30 : 30;

            $html .= "<td $head><div><div style='height:{$wid}px; width:1px; margin:0 auto; background:#ccc;'>";

            if ($n == 0) {
                if (is_array($posz)) {
                    $html .= "<div style='position:absolute;width:300px'><ol style='margin-left:-20px;'>";
                    foreach ($posz as $p) {
                        $html .= $p;
                    }
                    $html .= "</ol></div>";
                }
            }

            $html .= "</div></div></div></td>";

            if ($n > 1) {
                $html .= "<td colspan='$m'><div><ol style='margin-left:-80px;'>";
                if (is_array($posz)) {
                    foreach ($posz as $p) {
                        $html .= $p;
                    }
                }
                $html .= "</ol></div></td>";
            }

            $html .= "</tr>";

            $html .= "<tr>";
            $i = 1;
            foreach ($q as $key) {
                if ($key->jenis_jabatan == 'Struktural') {
                    $html .= "<td $s width='$width%' valign='top'>";
                    $html .= "<table cellspacing='0' cellpadding='0' style='height:30px; width:100%;'>";
                    $html .= "<tr>";
                    $html .= $i == 1 ? "<td width='50%'>&nbsp;</td>" : "<td width='50%' style='border-top: 1px #ccc solid; text-align:right'>&nbsp;</td>";
                    $html .= $i == $n ? "<td width='50%' style='border-left: 1px #ccc solid;'>&nbsp;</td>" : "<td width='50%' style='border-top: 1px #ccc solid;border-left: 1px #ccc solid'>&nbsp;</td>";
                    $html .= "</tr>";
                    $html .= "</table>";
                    $html .= "</td>";
                    $i++;
                }
            }
            $html .= "</tr>";

            $html .= "<tr>";
            foreach ($q as $key) {
                if ($key->jenis_jabatan == 'Struktural') {
                    $html .= "<td $s width='$width%' valign='top'>";
                    $html .= $key->position_id == $now
                        ? "<div style='width:100px;padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px;background:#c4f5ff'>"
                        : "<div style='width:100px;padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px'>";
                    $html .= $key->child_name;
                    $html .= "</div>";
                    $html .= "</td>";
                }
            }
            $html .= "</tr>";

            $html .= "</table>";
        }

        return $html;
    }
}
