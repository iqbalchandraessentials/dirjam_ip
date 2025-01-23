<?php

namespace App\Http\Controllers;

use App\Models\JabatanLamaBaru;
use App\Models\jenjang\M_JENJANG;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanNonteknis;
use App\Models\KeterampilanTeknis;
use App\Models\M_AKTIVITAS;
use App\Models\M_AKTIVITAS_GENERIK;
use App\Models\M_JABATAN;
use App\Models\M_KEWENANGAN_JABATAN;
use App\Models\M_KOMUNIKASI;
use App\Models\M_MAP_PENDIDIKAN;
use App\Models\M_PENGAMBILAN_KEPUTUSAN;
use App\Models\M_TANTANGAN;
use App\Models\M_URAIAN_JABATAN;
use App\Models\MappingNatureOfImpact;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\MasterJenjangJabatan;
use App\Models\MasterPendidikan;
use App\Models\MasterUnit;
use App\Models\MelengkapiData;
use App\Models\TEMPLATE_ACUAN_V;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\unit\M_UNIT;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class UraianJabatanController extends Controller
{

    public function index()
    {
        $jabatans = ViewUraianJabatan::where('unit_kd', 'KP')->get();
        $jenjangOptions  = MasterJenjangJabatan::get();
        $unitOptions  = MasterUnit::get();
        return view('pages.uraian_jabatan.index', compact('jenjangOptions', 'unitOptions', 'jabatans'));

    }

    public function filterData(Request $request)
    {
        $unit = $request->input('unit');

        if (is_null($unit)) {
            $results = ViewUraianJabatan::all(); // Get all records if unit is null
        } elseif (is_array($unit)) {
            $results = ViewUraianJabatan::whereIn('UNIT_KD', $unit)->get();
        } else {
            $results = ViewUraianJabatan::where('UNIT_KD', $unit)->get(); // If it's a single value
        }
        if ($results->isNotEmpty()) {
            dd($results);
        } else {
            dd('No results found.');
        }
        $unitOptions = MasterUnit::select('kode', 'nama')->get();
        $jenjangOptions = MasterJenjangJabatan::select('kode', 'nama')->get();
        // dd($unitOptions);
          // Mengembalikan hasil ke view
        return view('pages.uraian_jabatan.index', compact('jabatans', 'jenjangOptions', 'unitOptions'));
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
    public function show(string $id)
    {
        $data = $this->getDatas($id);
        return view('pages.uraian_jabatan.show', ['data' => $data]);

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
    public function getLatestDatas($data, $jenjang) {
        $test = [];
        $test['fungsi_utama'] = $data['uraianMasterJabatan']['fungsi_utama'];
        $test['nature_of_impact'] = $data['uraianMasterJabatan']['nature_impact'] ?? '';
        $test['anggaran'] = $data['uraianMasterJabatan']['anggaran'];
        $test['kewenangan_pengadaan'] = $data['uraianMasterJabatan']['kewenangan_pengadaan'];
        $test['aktivitas'] = $data['uraianMasterJabatan']['tugasPokoUtamaGenerik'];
        $test['kemampuan_dan_pengalaman'] = $data['uraianMasterJabatan']['kemampuandanPengalaman'];
        $test['komunikasi_internal'] = collect($data['uraianMasterJabatan']['hubunganKerja'])->where('jenis', 'internal');
        $test['komunikasi_external'] = collect($data['uraianMasterJabatan']['hubunganKerja'])->where('jenis', 'eksternal');
        foreach ($data['uraianMasterJabatan']['spesifikasiPendidikan'] as $key => $item) {
            $masterPendidikan = MasterPendidikan::where('nama', $item['pendidikan'])
                ->where('jenjang_jabatan', $jenjang)
                ->first();
            $data['uraianMasterJabatan']['spesifikasiPendidikan'][$key]['pengalaman'] = $masterPendidikan ? $masterPendidikan->pengalaman : '-';
        }
        $test['pendidikan'] = $data['uraianMasterJabatan']['spesifikasiPendidikan'];
        $test['tantangan'] = $data['uraianMasterJabatan']['masalahKompleksitasKerja'];
        $test['pengambilan_keputusan'] = $data['uraianMasterJabatan']['wewenangJabatan'];
        return $test;
    }

    public function getDatas($id) 
    {
        $data = M_URAIAN_JABATAN::where('URAIAN_JABATAN_ID', $id)->firstOrFail();
        $uraian_jabatan_id = $data->uraian_jabatan_id;
        $jabatan = M_JABATAN::where('POSITION_ID', $data->position_id)->firstOrFail();
        $check = MasterJabatan::where('nama', $jabatan->master_jabatan)->with('uraianMasterJabatan')->first();
        $type = $jabatan->type == "S" ? "struktural" : "fungsional";
        if ($check) {
            $data = $this->getLatestDatas($check, $jabatan->jen);
        } else {
            $data['nature_of_impact'] = MappingNatureOfImpact::select('kategori')->where('KODE_PROFESI', $jabatan->nama_profesi)->first();
            $jabatanText = $jabatan->jabatan;
            $words = explode(' ', $jabatanText);
            $jabatanTrimmed = implode(' ', array_slice($words, 0, count($words) - 2));
            $melengkapiData = JabatanLamaBaru::whereRaw('LOWER(jabatan) LIKE ?', ['%' . strtolower($jabatanTrimmed) . '%'])->first();
            $templateAcuan = optional($melengkapiData)->master_jabatan 
                ? TEMPLATE_ACUAN_V::where('NAMA_TEMPLATE', $melengkapiData->master_jabatan)->first() 
                : null;
            $aktivitas = M_AKTIVITAS::where('uraian_jabatan_id', $jabatan->template_id)->get();
            $id = $jabatan->template_id;
            if ($aktivitas->isEmpty()) {
                $aktivitas = M_AKTIVITAS::where('URAIAN_JABATAN_ID', $jabatan->uraian_jabatan_id)->get();
                $id = $jabatan->uraian_jabatan_id;
            }
            if ($aktivitas->isEmpty() && $templateAcuan) {
                $aktivitas = M_AKTIVITAS::where('URAIAN_JABATAN_ID', $templateAcuan->uraian_jabatan_id)->get();
                $id = $templateAcuan->uraian_jabatan_id;
            }
            $data["aktivitas"] = $aktivitas;
            $mapPendidikan = new M_MAP_PENDIDIKAN();
            $data['kemampuan_dan_pengalaman'] = KemampuandanPengalaman::where('jenis_jabatan', $type)->get();
            $data['pendidikan'] = $mapPendidikan->getByJabatan($id);
            $data['komunikasi_internal'] = M_KOMUNIKASI::where('LINGKUP_FLAG', 'internal')->where('URAIAN_JABATAN_ID', $id)->orderBy('URUTAN')->get();
            $data['komunikasi_external'] = M_KOMUNIKASI::where('LINGKUP_FLAG', 'external')->where('URAIAN_JABATAN_ID', $id)->orderBy('URUTAN')->get();
            $data["tantangan"] = M_TANTANGAN::where('URAIAN_JABATAN_ID',$id)->get();
            $data['pengambilan_keputusan'] = M_PENGAMBILAN_KEPUTUSAN::where('URAIAN_JABATAN_ID', $id)->orderBy('URUTAN')->get();
            $kwn = $this->kwn();
            $results = M_KEWENANGAN_JABATAN::with('kewenangan')
                ->where('URAIAN_JABATAN_ID', $id)
                ->get();
            $kewenanganData = [];
            foreach ($results as $result) {
                $kewenanganData[$result->TIPE_KEWENANGAN] = $result->kewenangan->JUMLAH_KEWENANGAN ?? "";
            }
            foreach ($kwn as $key => $value) {
                $data[$key] = $kewenanganData[$key] ?? "";
            }
        }
        $data['pengambilan_keputusan'] = $data['pengambilan_keputusan'] ?? WewenangJabatan::where('jenis_jabatan', $type)->get();
        $data['tantangan'] = $data['tantangan'] ?? MasalahKompleksitasKerja::where('jenis_jabatan', $type)->get();        
        $data['aktivitas_generik'] = TugasPokoUtamaGenerik::where('jenis', 'generik')->where('jenis_jabatan',$type)->get();
        $data['jabatan'] = $jabatan;
        $data['uraian_jabatan_id'] = $uraian_jabatan_id;
        $data['struktur_organisasi'] = $this->sto($jabatan['parent_position_id'], $jabatan['position_id']);
        $data['keterampilan_non_teknis'] = KeterampilanNonteknis::where('MASTER_JABATAN', $data['jabatan']['master_jabatan'])->get();
        $data_core = KeterampilanTeknis::where('URAIAN_MASTER_JABATAN_ID', $data['jabatan']['template_id'])->get();
        $core = !$data_core ? $data_core : KeterampilanTeknis::where('kategori','CORE')->where('MASTER_JABATAN', $data['jabatan']['master_jabatan'])->get()  ;
        $enabler = KeterampilanTeknis::where('kategori','ENABLER')->where('MASTER_JABATAN', $data['jabatan']['master_jabatan'])->get();
        $data['keterampilan_teknis'] =  $core->merge($enabler);
     
        // dd($data);
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
