<?php

namespace App\Http\Controllers;

use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanNonteknis;
use App\Models\KeterampilanTeknis;
use App\Models\M_AKTIVITAS;
use App\Models\M_KEWENANGAN_JABATAN;
use App\Models\M_KOMUNIKASI;
use App\Models\M_MAP_PENDIDIKAN;
use App\Models\M_PENGAMBILAN_KEPUTUSAN;
use App\Models\M_TANTANGAN;
use App\Models\M_URAIAN_JABATAN;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\MasterPendidikan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\URAIAN_JABATAN;
use App\Models\UraianMasterJabatan;
use App\Models\ViewUraianJabatan;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpParser\Node\Expr\Isset_;
use Yajra\DataTables\Facades\DataTables;

class TemplateJabatanController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ViewUraianJabatan::select('URAIAN_JABATAN_ID', 'master_jabatan', 'unit_kd', 'jen')->where('unit_kd', 'KP');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('export.templateJabatanExcel', $row->master_jabatan) . '"><i class="ti-layout"></i></a>
                            <a href="' . route('export.templateJabatanPdf', $row->master_jabatan) . '"><i class="ti-printer"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.template.index');
        // $data2 = MasterJabatan::select('id' as 'URAIAN_JABATAN_ID', 'nama' as master_jabatan, 'unit_kd', 'JENJANG_KODE' as 'jen')->has('uraianMasterJabatan')->get();
    }

    public function draft($id)
    {
        $data =  MasterJabatan::find($id);
        return view('pages.template.draft',  ['data' => $data]);
    }


    public function show($masterJabatan)
    {
        $data = $this->getDatas($masterJabatan);
        return view('pages.template.show', [
            'data' => $data,
        ]);
    }


    public function getDatas($masterJabatan)
    {
        $data = UraianMasterJabatan::with(['masterJabatan','tugasPokoUtamaGenerik','hubunganKerja','masalahKompleksitasKerja','wewenangJabatan','spesifikasiPendidikan','kemampuandanPengalaman'])->where('nama', $masterJabatan)->first();
        
        if ($data) {
            $data['jabatans'] = ViewUraianJabatan::select('uraian_jabatan_id', 'parent_position_id', 'type', 'jabatan', 'position_id', 'NAMA_PROFESI', 'DESCRIPTION', 'JEN', 'ATASAN_LANGSUNG')
                ->where('MASTER_JABATAN', $data['nama'])
                ->get();
            $jabatans = $data["jabatans"];
            foreach ($jabatans as $v) {
                $x = ViewUraianJabatan::select(['jabatan', 'type', 'DESCRIPTION', 'BAWAHAN_LANGSUNG', 'TOTAL_BAWAHAN', 'NAMA_PROFESI', 'ATASAN_LANGSUNG'])
                    ->where('position_id', $v->position_id)
                    ->first();
                $v = $x;
            $type = $data->jenis_jabatan == 'F' ? 'fungsional' : 'struktural';;
            $parent_position_id =  $data['jabatans'][0]['parent_position_id'];
            $position_id =  $data['jabatans'][0]['position_id'];
            }

            $data['spesifikasiPendidikan'] = $data['spesifikasiPendidikan'];
            foreach ($data['spesifikasiPendidikan'] as $key => $item) {
                $masterPendidikan = MasterPendidikan::where('nama', $item['pendidikan'])
                    ->where('jenjang_jabatan', $data['jabatans'][0]['jen'])
                    ->first();
                $data['spesifikasiPendidikan'][$key]['pengalaman'] = $masterPendidikan ? $masterPendidikan->pengalaman : '-';
            }
            $masalah_kompleksitas_kerja  = $data['masalahKompleksitasKerja'];
            $wewenang_jabatan  = $data['wewenangJabatan'];
            $kemampuandanPengalaman  = $data['kemampuandanPengalaman'];


        } else {
            $x = ViewUraianJabatan::select(['MASTER_JABATAN', 'fungsi_utama','parent_position_id', 'position_id', 'jabatan', 'jen', 'type', 'NAMA_PROFESI', 'template_id', 'uraian_jabatan_id'])->where('MASTER_JABATAN', $masterJabatan)->first();
            if (!$x) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
            
            $data = [
                'jabatans' => ViewUraianJabatan::with(['jenjangJabatan', 'namaProfesi'])->select(['MASTER_JABATAN', 'fungsi_utama', 'jabatan', 'type', 'jen', 'DESCRIPTION', 'BAWAHAN_LANGSUNG', 'TOTAL_BAWAHAN', 'NAMA_PROFESI', 'ATASAN_LANGSUNG', 'BAWAHAN_LANGSUNG', 'TOTAL_BAWAHAN'])->with('namaProfesi', 'jenjangJabatan')->where('MASTER_JABATAN', $masterJabatan)->get(),
                'fungsi_utama' => $x->fungsi_utama,
                'nama' => $x->master_jabatan,
                'masterJabatan' => [
                    'type' => $x->type,
                    'jenjangJabatan' => [
                        'nama' => $x->jenjangJabatan->nama ?? $x->jen
                    ]
                ],
                'tugasPokoUtamaGenerik' => M_AKTIVITAS::where('uraian_jabatan_id', $x->template_id)->get()
            ];
            
            $type = $x->type == 'F' ? 'fungsional' : 'struktural';
            $parent_position_id =  $x->parent_position_id;
            $position_id =  $x->position_id;
            $mapPendidikan = new M_MAP_PENDIDIKAN();
            $data['spesifikasiPendidikan'] = $mapPendidikan->getByJabatan($x->template_id);
            $data['hubunganKerja'] = M_KOMUNIKASI::where('URAIAN_JABATAN_ID', $x->template_id)->orderBy('URUTAN')->get();
            $masalah_kompleksitas_kerja = M_TANTANGAN::where('URAIAN_JABATAN_ID', $x->template_id)->get();
            $wewenang_jabatan = M_PENGAMBILAN_KEPUTUSAN::where('URAIAN_JABATAN_ID', $x->template_id)->orderBy('URUTAN')->get();
            $kwn = $this->kwn();
            $results = M_KEWENANGAN_JABATAN::with('kewenangan')
                ->where('URAIAN_JABATAN_ID', $x->template_id)
                ->get();
            $kewenanganData = [];
            foreach ($results as $result) {
                $kewenanganData[$result->TIPE_KEWENANGAN] = $result->kewenangan->JUMLAH_KEWENANGAN ?? "";
            }
            foreach ($kwn as $key => $value) {
                $data[$key] = $kewenanganData[$key] ?? "";
            }
        }
            $data['struktur_organisasi'] = $this->sto($parent_position_id, $position_id);
            $data['tugas_pokok_generik'] = TugasPokoUtamaGenerik::where('jenis', 'generik')->where('jenis_jabatan', $type)->get();
            $data['masalah_kompleksitas_kerja'] = $masalah_kompleksitas_kerja->isNotEmpty()
                ? $masalah_kompleksitas_kerja
                : MasalahKompleksitasKerja::where('jenis_jabatan', $type)->get();
            $data['wewenang_jabatan'] = $wewenang_jabatan->isNotEmpty()
                ? $wewenang_jabatan
                : WewenangJabatan::where('jenis_jabatan', $type)->get();
            $data['kemampuan_dan_pengalaman'] = isset($kemampuandanPengalaman)
            ? $kemampuandanPengalaman
            : KemampuandanPengalaman::where('jenis_jabatan', $type)->get();
            $data['keterampilan_non_teknis'] = KeterampilanNonteknis::where('MASTER_JABATAN', $masterJabatan)->get();
            $data_core = KeterampilanTeknis::where('MASTER_JABATAN', $masterJabatan)->get();
            $core = !$data_core ? $data_core : KeterampilanTeknis::where('kategori', 'CORE')->where('MASTER_JABATAN', $masterJabatan)->get();
            $enabler = KeterampilanTeknis::where('kategori', 'ENABLER')->where('MASTER_JABATAN', $masterJabatan)->get();
            $data['keterampilan_teknis'] =  $core->merge($enabler);
      
        // dd($parent_position_id);
        // dd($data['struktur_organisasi']);

        return $data;
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
