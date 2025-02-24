<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanNonteknis;
use App\Models\KeterampilanTeknis;
use App\Models\M_AKTIVITAS;
use App\Models\M_KOMUNIKASI;
use App\Models\M_MAP_PENDIDIKAN;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\MasterPendidikan;
use App\Models\PokoUtamaGenerik;
use App\Models\unit\M_UNIT;
use App\Models\UraianMasterJabatan;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TemplateJabatanController extends Controller
{

    public function index(Request $request)
    {
        $unitOptions = M_UNIT::select(['unit_kd', 'unit_nama'])->get();
        $selectUnit = Auth::user()->unitKerja->unit_nama;
        return view('pages.template.index', compact('unitOptions', 'selectUnit'));
    }

    public function show($masterJabatan, $unit_kd, $id = null)
    {
        $data = $this->getDatas($masterJabatan, $unit_kd, $id);
        return view('pages.template.show', [
            'data' => $data,
        ]);
    }

    public function filterData(Request $request)
    {  
        $unit_kd = $request->input('unit', Auth::user()->unit_kd);
    
        $data = ViewUraianJabatan::select('master_jabatan', 'unit_kd', 'jen')
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
    
    public function draft($id)
    {
        $data =  MasterJabatan::find($id);
        $unit = M_UNIT::select('unit_kd')->where('unit_nama', $data->unit_kode)->first();
        $encodedName = base64_encode($data->nama);
        return view('pages.template.draft',  ['data' => $data, 'unit' => $unit, 'encodedName' => $encodedName]);
    }

    public function getDatas($masterJabatan, $unit_kd = '', $id = null)
    {
        $masterJabatan = base64_decode($masterJabatan);
    
        // Jika ID adalah angka, ambil data berdasarkan ID
        if (is_numeric($id) && $id !== 'old') {
            return $this->processExistingData(
                $this->getUraianMasterJabatanById($id),
                $unit_kd
            );
        }
    
        // Jika ID adalah "old", panggil processNewData
        if ($id == 'old') {    
            return $this->processNewData($masterJabatan, $unit_kd);
        }
        
        // Jika tidak ada ID, cari berdasarkan nama master jabatan
        $data = $this->getUraianMasterJabatanByName($masterJabatan);
    
        return $data 
            ? $this->processExistingData($data, $unit_kd)
            : $this->processNewData($masterJabatan, $unit_kd);
    }
    
    /**
     * Mengambil data UraianMasterJabatan berdasarkan ID.
     */
    private function getUraianMasterJabatanById($id)
    {
        return UraianMasterJabatan::with([
            'masterJabatan', 'PokoUtamaGenerik', 'hubunganKerja',
            'masalahKompleksitasKerja', 'wewenangJabatan',
            'spesifikasiPendidikan', 'kemampuandanPengalaman'
        ])->findOrFail($id);
    }
    
    /**
     * Mengambil data UraianMasterJabatan berdasarkan nama.
     */
    private function getUraianMasterJabatanByName($name)
    {
        return UraianMasterJabatan::with([
            'masterJabatan', 'PokoUtamaGenerik', 'hubunganKerja',
            'masalahKompleksitasKerja', 'wewenangJabatan',
            'spesifikasiPendidikan', 'kemampuandanPengalaman'
        ])
        ->where('nama', $name)
        ->orderByDesc('id')
        ->first();
    }
    
    
    private function processExistingData($data, $unit_kd)
    {
        $data['jabatans'] = ViewUraianJabatan::with(['jenjangJabatan', 'namaProfesi'])
        ->select('jabatan', 'position_id', 'NAMA_PROFESI', 'bawahan_langsung', 'total_bawahan', 'DESCRIPTION', 'JEN', 'ATASAN_LANGSUNG')
        ->where('MASTER_JABATAN', $data['nama'])
        ->where('SITEID', $unit_kd)
        ->distinct()
        ->orderBy('MASTER_JABATAN')
        ->get();
        $type = $data->jenis_jabatan == 'F' ? 'fungsional' : 'struktural';
        $position_id = $data['jabatans'][0]['position_id'] ?? null;
        $parent_position_id = $data['jabatans'][0]['parent_position_id'] ?? null;
        foreach ($data['spesifikasiPendidikan'] as $key => $item) {
            $masterPendidikan = MasterPendidikan::where('nama', $item['pendidikan'])
                ->where('jenjang_jabatan', $data['jabatans'][0]['jen'] ?? null)
                ->first();
            $data['spesifikasiPendidikan'][$key]['pengalaman'] = $masterPendidikan->pengalaman ?? '-';
        }
        return $this->finalizeData($data, $type, $parent_position_id, $position_id);
    }
    
    private function processNewData($masterJabatan, $unit_kd)
    {
        $x = ViewUraianJabatan::where('MASTER_JABATAN', $masterJabatan)
            ->where('SITEID', $unit_kd)
            ->with(['jenjangJabatan', 'namaProfesi'])
            ->first();
        if (!$x) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $type = $x->type == 'F' ? 'fungsional' : 'struktural';
        $data = [
            'fungsi_utama' => $x->fungsi_utama,
            'nama' => $x->master_jabatan,
            'unit_kd' => $x->unit_kd,
            'masterJabatan' => [
                'jenjangJabatan' => ['nama' => $x->jenjangJabatan->nama ?? $x->jen],
                'jenis_jabatan' => $type,
                'unit_kode' => $x->description,
            ],
            'jabatans' => ViewUraianJabatan::with(['jenjangJabatan', 'namaProfesi'])
            ->select('jabatan', 'position_id', 'bawahan_langsung', 'total_bawahan', 'NAMA_PROFESI', 'DESCRIPTION', 'JEN', 'ATASAN_LANGSUNG')
            ->where('MASTER_JABATAN', $x['master_jabatan'])
            ->where('SITEID', $unit_kd)
            ->distinct()
            ->orderBy('MASTER_JABATAN')
            ->get(),
            'PokoUtamaGenerik' => M_AKTIVITAS::where('uraian_jabatan_id', $x->template_id)->get()
        ];
        $data['spesifikasiPendidikan'] = (new M_MAP_PENDIDIKAN())->getByJabatan($x->template_id);
        $data['hubunganKerja'] = M_KOMUNIKASI::where('URAIAN_JABATAN_ID', $x->template_id)->orderBy('URUTAN')->get();
        return $this->finalizeData($data, $type, $x->parent_position_id, $x->position_id);
    }
    
    private function finalizeData($data, $type, $parent_position_id, $position_id)
    {
        $data['struktur_organisasi'] = $this->sto($parent_position_id, $position_id);
        $data['tugas_pokok_generik'] = PokoUtamaGenerik::where('jenis', 'generik')->where('jenis_jabatan', $type)->get();
        $data['masalah_kompleksitas_kerja'] = MasalahKompleksitasKerja::where('jenis_jabatan', $type)->get();
        $data['wewenang_jabatan'] = WewenangJabatan::where('jenis_jabatan', $type)->get();
        $data['kemampuan_dan_pengalaman'] = KemampuandanPengalaman::where('jenis_jabatan', $type)->get();
        $data['keterampilan_non_teknis'] = KeterampilanNonteknis::where('master_jabatan', $data['nama'])->get();
        $core = KeterampilanTeknis::where('kategori', 'CORE')->where('master_jabatan', $data['nama'])->get();
        $enabler = KeterampilanTeknis::where('kategori', 'ENABLER')->where('master_jabatan', $data['nama'])->get();
        $data['keterampilan_teknis'] = $core->merge($enabler);
        if (!empty($data['hubunganKerja']) && empty($data['hubunganKerja'][0]['tujuan'])) {
            $data['hubunganKerja'] = [];
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
