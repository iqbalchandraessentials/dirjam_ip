<?php

namespace App\Imports;

use App\Models\existing\UraianJabatan;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\Aktivitas;
use App\Models\Komunikasi;
use App\Models\PengambilanKeputusan;
use App\Models\Tantangan;
use App\Models\MasterPendidikan;
use App\Models\SpesifikasiPendidikan;
use App\Models\unit\M_UNIT;
use App\Models\VIEW_TEMPLATE;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class UraianMasterJabatanImport implements ToCollection
{

    public $tugas_pokok_utama = [];
    public $hubungan_kerja = [];
    public $masalah_kompleksitas_kerja = [];
    public $wewenang_jabatan = [];
    public $pendidikan = [];
    public $kompetensi_teknis = [];
    public $kemampuan_pengalaman = [];

    public function collection(Collection $rows)
    {
        try {
            $data = [];
            $data['nama'] =   $rows[10][4];
            $unit_nama = $rows[5][0];
            $unit = M_UNIT::whereRaw('LOWER(unit_nama) = LOWER(?)', [$unit_nama])->first();
            $data['unit_id'] = $unit->unit_kd ?? $unit_nama;
            $viewUraianJabatan =  VIEW_TEMPLATE::select(['master_jabatan','jen','TYPE','SITEID'])->where('master_jabatan', $data['nama'])->first();
            if (!$viewUraianJabatan) {
                return redirect()->back()->with('error', 'Nama Master jabatan tidak ditemukan');
            }
            if (!$data['nama']) {
                return redirect()->back()->with('error','Master jabatan kosong');
            }

            // fungsi utama
            $data['fungsi_utama'] =  $rows[21][1] ;
            if (!$data['fungsi_utama']) {
                return redirect()->back()->with('error','Fungsi utama kosong');
            }
            // dimesi finansial
            $anggaranMap = [
                64 => "Investasi",
                65 => "Operasional",
            ];
            $accountabilityMap = [
                68 => "Non Quantifiable",
                69 => "Very Small",
                70 => "Small",
                71 => "Medium",
                72 => "Large",
                73 => "Very Large",
            ];
            $natureImpactMap = [
                76 => "Prime",
                77 => "Share",
                78 => "Contributory",
                79 => "Remote",
            ];
            function getValueFromRows($rows, $map, $default = null)
            {
                foreach ($map as $row => $value) {
                    if (isset($rows[$row][1]) && $rows[$row][1] == "v") {
                        return $value;
                    }
                }
                return $default;
            }

            $data['anggaran'] = getValueFromRows($rows, $anggaranMap);
            $data['accountability'] = getValueFromRows($rows, $accountabilityMap);
            $data['nature_impact'] = getValueFromRows($rows, $natureImpactMap);

            // TUGAS POKOK UTAMA DAN OUTPUT
            foreach ($rows as $key => $row) {
                if ($key >= 26 && $key <= 50) {
                    $this->tugas_pokok_utama[] = [
                        'aktivitas' => $row[2], // Sesuaikan kolom
                        'output' => $row[6],
                        'jenis' => 'utama',
                    ];
                }
            }
            if (empty($this->tugas_pokok_utama[0]['aktivitas'])) {
                return redirect()->back()->with('error','Tugas Pokok Utama Dan Output kosong');
            }
            $data['tugas_pokok_utama'] = $this->tugas_pokok_utama;
            // HUBUNGAN KERJA
            foreach ($rows as $key => $row) {
                if ($key >= 90 && $key <= 101) {
                    if (!empty($row[2]) && !empty($row[3])) {
                        $this->hubungan_kerja[] = [
                            'komunikasi' => $row[2],
                            'tujuan' => $row[3],
                            'jenis' => 'internal',
                        ];
                    }
                }
            }
            // if (empty($this->hubungan_kerja[0]['subjek'])) {
            //     return redirect()->back()->with('error','Hubungan Kerja Internal kosong');
            // }
            foreach ($rows as $key => $row) {
                if ($key >= 104 && $key <= 111) {
                    if (!empty($row[2]) && !empty($row[3])) {
                        $this->hubungan_kerja[] = [
                            'komunikasi' => $row[2],
                            'tujuan' => $row[3],
                            'jenis' => 'external',
                        ];
                    }
                }
            }
            // if (empty($this->hubungan_kerja[0]['subjek'])) {
            //     return redirect()->back()->with('error','Hubungan kerja Eksternal kosong');
            // }
            $data['hubungan_kerja'] = $this->hubungan_kerja;
            // MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA
            foreach ($rows as $key => $row) {
                if ($key >= 116 && $key <= 120) {
                    $this->masalah_kompleksitas_kerja[] = [
                        'masalah_kompleksitas_kerja' => $row[2]
                    ];
                }
            }
            $data['masalah_kompleksitas_kerja'] = $this->masalah_kompleksitas_kerja;
            // WEWENANG JABATAN
            foreach ($rows as $key => $row) {
                if ($key >= 125 && $key <= 129) {
                    $this->wewenang_jabatan[] = [
                        'wewenang_jabatan' => $row[2]
                    ];
                }
            }
            $data['wewenang_jabatan'] = $this->wewenang_jabatan;
            // Pendidikan
            foreach ($rows as $key => $row) {
                if ($key >= 134 && $key <= 137) {
                    $this->pendidikan[] = [
                        'pendidikan' => $row[2],
                        'pengalaman' => $row[3],
                        'bidang_studi' => $row[5],
                    ];
                }
            }
            if (empty($this->pendidikan[0]['pendidikan'])) {
                return redirect()->back()->with('error','Pendidikan kosong');
            }
            $data['pendidikan'] = $this->pendidikan;
   
            foreach ($rows as $key => $row) {
                if ($key >= 140 && $key <= 144) {
                    $this->kemampuan_pengalaman[] = [
                        'definisi' => $row[2],
                    ];
                }
            }
            $data['kemampuan_pengalaman'] = $this->kemampuan_pengalaman;
            // Kompetensi Teknis
            foreach ($rows as $key => $row) {
                if ($key >= 183 && $key <= 192) {
                    $kodeKompetensi = isset($row[2]) && !empty(trim($row[2])) ? trim($row[2]) : null;
                    if ($kodeKompetensi) { 
                        $this->kompetensi_teknis[] = [
                            'kode_kompetensi' => $kodeKompetensi,
                            'level' => isset($row[6]) ? trim($row[6]) : null,
                            'kode_perilaku' => $kodeKompetensi . '.' . (isset($row[6]) ? trim($row[6]) : ''),
                        ];
                    }
                }
            }
            // Aturan validasi untuk setiap item di array
            $rules = [
                '*.kode_kompetensi' => 'required|string|exists:master_kompetensi_teknis,kode|max:50',
                '*.level' => 'required|integer|min:1|max:5',
            ];
            // Lakukan validasi
            $validator = Validator::make($this->kompetensi_teknis, $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error','Komptensi Teknis salah atau kosong');
            }
            $data['kompetensi_teknis'] = $this->kompetensi_teknis;
            // akhir kompetensi teknis
            // menampilkan error
            if (!empty($errors)) {
                return redirect()->back()->with('error', implode(', ', $errors));
            }

            // end of get data
            // dd($viewUraianJabatan);
            // dd($data['tugas_pokok_utama']);
            // +=+
            $turnOff = UraianJabatan::where('active_flag', 1)
            ->where('nama_template', $data['nama'])
            ->where('unit_kd', $data['unit_id']) // Pastikan unit_kd sesuai dengan database
            ->update(['active_flag' => 0, 'sign4_id' => 0]);
            // DB::commit();

            $uraian_jabatan = UraianJabatan::create([
                'nama_template' => $data['nama'],
                'fungsi_utama' => $data['fungsi_utama'],
                'unit_kd' => $data['unit_id'], 
                'dibuat_oleh' => Auth::user()->name,
                'waktu_dibuat' => Carbon::now(),
                'active_flag' => 1,
                'sign4_id' => 1
            ]);
            $uraian_jabatan_id = $uraian_jabatan->URAIAN_JABATAN_ID;
            foreach ($data['tugas_pokok_utama'] as $x) {
                if (!empty($x['aktivitas']) && !empty($x['output'])) {
                    Aktivitas::create([
                        'uraian_jabatan_id' => $uraian_jabatan_id,
                        'aktivitas' => $x['aktivitas'],
                        'output' => $x['output'],
                        'dibuat_oleh' => Auth::user()->name,
                        'waktu_dibuat' => Carbon::now(),
                    ]);
                }
            }

            KeterampilanTeknis::where('master_jabatan', $data['nama'] )->where('kategori', 'CORE')->delete();
            foreach ($data['kompetensi_teknis'] as $x) {
                if (!empty($x['kode_kompetensi']) && !empty($x['level'])) {
                    $master_detail_kompetensi = $x['kode_kompetensi'].'.'.$x['level'];
                    KeterampilanTeknis::create([
                        'master_jabatan' => $data['nama'],
                        'kode' => $x['kode_kompetensi'],
                        'master_detail_kompetensi_id' => $master_detail_kompetensi,
                        'kategori' => "CORE",
                        'level' => $x['level'],
                    ]);
                }
            }
            foreach ($data['hubungan_kerja'] as $x) {
                if (!empty($x['subjek']) && !empty($x['tujuan']) && !empty($x['jenis'])) {
                    Komunikasi::create([
                        'uraian_jabatan_id' => $uraian_jabatan_id,
                        'subjek' => $x['subjek'],
                        'tujuan' => $x['tujuan'],
                        'lingkup_flag' => $x['jenis'],
                        'dibuat_oleh' => Auth::user()->name,
                        'waktu_dibuat' => Carbon::now()
                    ]);
                }
            }
            foreach ($data['masalah_kompleksitas_kerja'] as $x) {
                if (!empty($x['masalah_kompleksitas_kerja'])) {
                    Tantangan::create([
                        'uraian_jabatan_id' => $uraian_jabatan_id,
                        'tantangan' => $x['masalah_kompleksitas_kerja'],
                        'dibuat_oleh' => Auth::user()->name,
                        'waktu_dibuat' => Carbon::now()
                    ]);
                }
            }
            foreach ($data['wewenang_jabatan'] as $x) {
                if (!empty($x['wewenang_jabatan'])) {
                    PengambilanKeputusan::create([
                        'uraian_jabatan_id' => $uraian_jabatan_id,
                        'pengambilan_keputusan' => $x['wewenang_jabatan'],
                        'dibuat_oleh' => Auth::user()->name,
                        'waktu_dibuat' => Carbon::now()
                    ]);
                }
            }
            foreach ($data['kemampuan_pengalaman'] as $x) {
                if (!empty($x['definisi'])) {
                    KemampuandanPengalaman::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'definisi' => $x['definisi'],
                    ]);
                }
            }
            
             foreach ($data['pendidikan'] as $x) {
                if (!empty($x['pendidikan']) && !empty($x['pengalaman'])) {
                    $pengalaman = MasterPendidikan::select('pengalaman')
                        ->where('jenjang_jabatan', $viewUraianJabatan->jen)
                        ->where('nama', $x['pendidikan'])
                        ->first();

                    $pengalamanValue = is_numeric($pengalaman->pengalaman) ? $pengalaman->pengalaman : 0;

                    SpesifikasiPendidikan::create([
                        'URAIAN_MASTER_JABATAN_ID' => $uraian_jabatan_id,
                        'pendidikan' => $x['pendidikan'],
                        'pengalaman' => $pengalamanValue,
                        'bidang_studi' => $x['bidang_studi'] ?? null,
                    ]);
                }
            };
            return $data['nama'];
        } catch (\Exception $e) {
            Log::error('Error saat membuat Template jabatan: ' . $e->getMessage());
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }
}
