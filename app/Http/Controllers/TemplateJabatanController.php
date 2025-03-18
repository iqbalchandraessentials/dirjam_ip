<?php

namespace App\Http\Controllers;

use App\Models\existing\UraianJabatan;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\M_MAP_PENDIDIKAN;
use App\Models\MappingNatureOfImpact;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterPendidikan;
use App\Models\unit\M_UNIT;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TemplateJabatanController extends Controller
{

    public function index(Request $request)
    {
        $unitOptions = M_UNIT::select(['unit_kd', 'unit_nama'])->where('status', 1)->get();
        $selectUnit = Auth::user()->unitKerja->unit_nama;
        return view('pages.template.index', compact('unitOptions', 'selectUnit'));
    }

    public function filterData(Request $request)
    {
        $unit_kd = $request->input('unit', Auth::user()->unit_kd);
        $data = ViewUraianJabatan::where('completed', 'Completed')->where('status', 'APPROVE')->select('master_jabatan', 'unit_kd', 'jen')
            ->groupBy('master_jabatan', 'unit_kd', 'jen')
            ->when(!empty($unit_kd), function ($query) use ($unit_kd) {
                return $query->where('unit_kd', $unit_kd);
            })
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($unit_kd) {
                $encodedName = base64_encode($row->master_jabatan);
                return '
                    <a href="' . route('template_jabatan.show', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd]) . '" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                    <a href="' . route('export.template_jabatan_Excel', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd]) . '" class="btn btn-xs btn-success"><i class="fa fa-table"></i></a>
                    <a href="' . route('export.template_jabatan_PDF', ['encoded_name' => $encodedName, 'unit_kd' => $unit_kd]) . '" class="btn btn-xs btn-primary"><i class="ti-printer"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($masterJabatan, $unit_kd, $id = null)
    {
        $data = $this->getDatas($masterJabatan, $unit_kd, $id);
        return view('pages.template.show', [
            'data' => $data,
        ]);
    }

    public function draft($masterJabatan, $unit_kd)
    {
        $masterJabatan = base64_decode($masterJabatan);
        $data = UraianJabatan::select(['uraian_jabatan_id', 'nama_template', 'waktu_dibuat', 'dibuat_oleh'])->where('NAMA_TEMPLATE', $masterJabatan)->where('unit_kd', $unit_kd)->get();
        return view('pages.template.draft',  ['data' => $data, 'unit_kd' => $unit_kd, 'master_jabatan' => $masterJabatan]);
    }

    public function getDatas($masterJabatan, $unit_kd = '', $id = null)
    {
        $masterJabatan = base64_decode($masterJabatan);
        $data = ViewUraianJabatan::where([['MASTER_JABATAN', $masterJabatan],['SITEID', $unit_kd]])->with(['namaProfesi','jenjang_jabatan','tugas_pokok_utama','tugas_pokok_generik', 'hubungan_kerja', 'keterampilan_non_teknis'])->first();
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        foreach ($data['spesifikasi_pendidikan'] as $key => $item) {
            $masterPendidikan = MasterPendidikan::where('nama', $item['pendidikan'])->where('jenjang_jabatan', $data['jabatans'][0]['jen'] ?? null)->first();
            $data['spesifikasi_pendidikan'][$key]['pengalaman'] = $masterPendidikan->pengalaman ?? '-';
        }
        $data['jenis_jabatan'] = $data['jen'] == 'F' ? 'FUNGSIONAL' : 'STRUKTRUAL';
        $data['waktu_dibuat'] = Carbon::parse($data['waktu_dibuat']);
        $data['jumlahRecord'] = UraianJabatan::where([['NAMA_TEMPLATE', $masterJabatan],['unit_kd', $unit_kd]])->count();
        $data['jabatans'] = $this->getJabatanData($data, $unit_kd);
        $data['nature_impact'] = MappingNatureOfImpact::where('kode_profesi', $data['nama_profesi'])->value('jenis');
        $data['struktur_organisasi'] = $this->sto($data['parent_position_id'], $data['position_id']);
        if (!empty($data['hubungan_kerja']) && empty($data['hubungan_kerja'][0]['tujuan'])) {$data['hubungan_kerja'] = []; }
        $data['spesifikasi_pendidikan'] = $data['spesifikasi_pendidikan']->isEmpty() ?  (new M_MAP_PENDIDIKAN())->getByJabatan($data['template_id']) : $data['spesifikasi_pendidikan'];
        $tantangan = isset($data['tantangan'][0]['tantangan']) ? $data['tantangan'] : null;
        $data['tantangan'] = $tantangan ?? MasalahKompleksitasKerja::where('jenis_jabatan', $data['type'])->get();
        $pengambilan_keputusan = isset($data['pengambilan_keputusan'][0]['pengambilan_keputusan']) &&!empty($data['pengambilan_keputusan'][0]['pengambilan_keputusan']) ? $data['pengambilan_keputusan'] : null;
        $data['pengambilan_keputusan'] = $pengambilan_keputusan ?? WewenangJabatan::where('jenis_jabatan', $data['type'])->get();
        $data['kemampuan_dan_pengalaman'] = $data['kemampuanDanPengalaman'] ? $data['kemampuanDanPengalaman'] : KemampuandanPengalaman::where('jenis_jabatan', $data['type'])->get();
        $data['keterampilan_teknis'] = KeterampilanTeknis::where('master_jabatan', $data['master_jabatan'])->whereIn('kategori', ['CORE', 'ENABLER'])->get();
        return $data;
    }

    private function getJabatanData($x, $unit_kd)
    {
        return ViewUraianJabatan::with(['namaProfesi','jenjang_jabatan'])
            ->select('jabatan', 'position_id', 'bawahan_langsung', 'total_bawahan', 'NAMA_PROFESI', 'DESCRIPTION', 'JEN', 'ATASAN_LANGSUNG')
            ->where([
                ['MASTER_JABATAN', $x->master_jabatan],
                ['SITEID', $unit_kd]
            ])
            ->distinct()
            ->orderBy('MASTER_JABATAN')
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
