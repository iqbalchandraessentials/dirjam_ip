<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\M_MAP_PENDIDIKAN;
use App\Models\MappingNatureOfImpact;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJenjangJabatan;
use App\Models\SpesifikasiPendidikan;
use App\Models\unit\M_UNIT;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UraianJabatanController extends Controller
{

    public function index()
    {
        $jabatans = ViewUraianJabatan::where('unit_kd', Auth::user()->unit_kd)->where('completed', 'Completed')->where('status', 'APPROVE')->get();
        $unitOptions  = M_UNIT::select(['unit_kd', 'unit_nama'])->get();
        $selectUnit = Auth::user()->unitKerja->unit_nama;
        return view('pages.uraian_jabatan.index', compact('unitOptions', 'jabatans', 'selectUnit'));
    }

    public function show(string $id)
    {
        $data = $this->getDatas($id);
        return view('pages.uraian_jabatan.show', ['data' => $data]);
    }

    public function filterData(Request $request)
    {
        $unit = $request->input('unit');
        $jenjang = $request->input('jenjang');
        $query = ViewUraianJabatan::query();
        if ($unit) {
            $query->where('unit_kd', $unit);
        }

        $jabatans = $query->get();
        $unitOptions = M_UNIT::select(['unit_kd', 'unit_nama'])->where('status', 1)->get();
        $jenjangOptions = MasterJenjangJabatan::select('kode', 'nama')->get();

        return view('pages.uraian_jabatan.index', compact('jabatans', 'jenjangOptions', 'unitOptions'));
    }


    public function getDatas($id)
    {
        $data = ViewUraianJabatan::where('uraian_jabatan_id', $id)->firstOrFail();
        $data['nature_of_impact'] = MappingNatureOfImpact::where('kode_profesi', $data->nama_profesi)->value('jenis');
        $spesifikasiPendidikan = SpesifikasiPendidikan::where('uraian_jabatan_id', $data->template_id)->get();
        $data['pendidikan'] = $spesifikasiPendidikan->isEmpty() ? (new M_MAP_PENDIDIKAN())->getByJabatan($id) : $spesifikasiPendidikan;
        if ($data['tantangan']->isEmpty() || $data['tantangan']->whereNotNull('definisi')->isEmpty()) {
            $data['tantangan'] = MasalahKompleksitasKerja::where('jenis_jabatan', $data->type)->get();
        }
        if ($data['pengambilan_keputusan']->isEmpty() || !$data['pengambilan_keputusan'][0]->definisi) {
            $data['pengambilan_keputusan'] = WewenangJabatan::where('jenis_jabatan', $data->type)->get();
        }
        $data['kemampuan_dan_pengalaman'] = $data['kemampuanDanPengalaman'] ? $data['kemampuanDanPengalaman'] : KemampuandanPengalaman::where('jenis_jabatan', $data['type'])->get();
        $data['keterampilan_teknis'] = KeterampilanTeknis::where('master_jabatan', $data['master_jabatan'])->whereIn('kategori', ['CORE', 'ENABLER'])->get();
        $data['struktur_organisasi'] = $this->sto($data['parent_position_id'], $data['position_id']);
        $data['spesifikasi_pendidikan'] = $data['spesifikasi_pendidikan']->isEmpty() ?  (new M_MAP_PENDIDIKAN())->getByJabatan($data['template_id']) : $data['spesifikasi_pendidikan'];
        if (empty($data['komunikasi_internal'][0]['tujuan'])) {
            $data['komunikasi_internal'] = [];
        }
        return $data;
    }

    public function getPendidikanByJabatanId($id)
    {
        return DB::table('MAP_PENDIDIKAN as mp')
            ->join('pendidikan as p', 'p.pendidikan_id', '=', 'mp.pendidikan_id')
            ->select('mp.*', 'p.*')
            ->where('mp.uraian_jabatan_id', $id)
            ->orderBy('mp.pendidikan_id', 'DESC')
            ->get();
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
        } else {
            $q = DB::table('IP_URJAB_ATASAN_LANGSUNG')->where('parent_position_id', $id)->get();

            $jabatans = [];

            foreach ($q as $key) {
                if ($key->jenis_jabatan == 'Struktural') {
                    $jabatans[$key->position_id] = $key->child_name;
                }
            }

            $q2 = DB::table('IP_URJAB_ATASAN_LANGSUNG')->where('position_id', $now)->first();

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

                if ($q2->parent_position_id != "") {
                    $html .= "<tr>";
                    $html .= $n > 1 ? "<td colspan='$m'></td>" : "";
                    $html .= "<td $head width='$width%'>";
                    $html .= "<div style='padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px;'>";
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

                $html .= "<td $head><div style='height:{$wid}px; width:1px; margin:0 auto; background:#ccc;'>";

                if ($n == 0) {
                    if (is_array($posz)) {
                        $html .= "<div style='position:absolute;width:300px'><ol style='margin-left:-20px;'>";
                        foreach ($posz as $p) {
                            $html .= $p;
                        }
                        $html .= "</ol></div>";
                    }
                }

                $html .= "</div></td>";

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
                        $html .= "</tr></table></td>";
                        $i++;
                    }
                }

                $html .= "</tr><tr>";
                foreach ($q as $key) {
                    if ($key->jenis_jabatan == 'Struktural') {
                        $html .= "<td $s width='$width%' valign='top'>";
                        $html .= $key->position_id == $now
                            ? "<div style='width:100px;padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px;background:#c4f5ff'>"
                            : "<div style='width:100px;padding:5px; margin:0 5px; border:1px #ccc solid; display:inline-block; font-size:7px'>";
                        $html .= $key->child_name;
                        $html .= "</div></td>";
                    }
                }
                $html .= "</tr></table>";
            }
        }
        return $html;
    }
}
