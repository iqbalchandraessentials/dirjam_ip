<?php

namespace App\Imports;

use App\Models\HubunganKerja;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\MasterPendidikan;
use App\Models\SpesifikasiPendidikan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\WewenangJabatan;
use App\Models\UraianMasterJabatan;
use App\Models\ViewUraianJabatan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class UraianMasterJabatanImport implements ToCollection
{

    /**
     * @param Collection $collection
     */
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
            $viewUraianJabatan = ViewUraianJabatan::select(['MASTER_JABATAN','DESCRIPTION','jen','TYPE','SITEID'])->where('MASTER_JABATAN', $data['nama'])->first();
            // dd($viewUraianJabatan);
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
                    if (isset($rows[$row][1]) && $rows[$row][1] === "v") {
                        return $value;
                    }
                }
                return $default;
            }
            $data['anggaran'] = getValueFromRows($rows, $anggaranMap);
            $data['accountability'] = getValueFromRows($rows, $accountabilityMap, 'Non Quantifiable');
            $data['nature_impact'] = getValueFromRows($rows, $natureImpactMap, '');

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
                    // Pastikan data valid sebelum dimasukkan ke array
                    if (!empty($row[2]) && !empty($row[3])) {
                        $this->hubungan_kerja[] = [
                            'komunikasi' => $row[2], // Sesuaikan kolom
                            'tujuan' => $row[3],
                            'jenis' => 'internal',
                        ];
                    }
                }
            }

            if (empty($this->hubungan_kerja[0]['komunikasi'])) {
                return redirect()->back()->with('error','Hubungan Kerja Internal kosong');
            }

            foreach ($rows as $key => $row) {
                if ($key >= 104 && $key <= 111) {
                    if (!empty($row[2]) && !empty($row[3])) {
                        $this->hubungan_kerja[] = [
                            'komunikasi' => $row[2], // Sesuaikan kolom
                            'tujuan' => $row[3],
                            'jenis' => 'eksternal',
                        ];
                    }
                }
            }
            if (empty($this->hubungan_kerja[0]['komunikasi'])) {
                return redirect()->back()->with('error','Hubungan kerja Eksternal kosong');
            }
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
            // dd($data);   
            // dd($viewUraianJabatan);
            // +=+
            $viewUraianJabatan['jenis_jabatan'] = $viewUraianJabatan['type'] == 'S' ? 'struktural' : 'fungsional';
            $master_jabatan = MasterJabatan::updateOrCreate(
                [
                    'nama' => $viewUraianJabatan['master_jabatan']
                ],
                [
                    'unit_kode' => $viewUraianJabatan['description'], // Data yang akan diupdate atau dibuat
                    'jenis_jabatan' => $viewUraianJabatan['jenis_jabatan'],
                    'jenjang_kode' => $viewUraianJabatan['jen'],
                ]
            );
            // Buat data UraianMasterJabatan
             $uraian_jabatan_id = UraianMasterJabatan::create([
                'master_jabatan_id' => $master_jabatan->id,
                'nama' => $data['nama'],
                'unit_id' => $viewUraianJabatan['siteid'],
                'fungsi_utama' => $data['fungsi_utama'],
                'anggaran' => $data['anggaran'],
                'accountability' => $data['accountability'],
                'nature_impact' => $data['nature_impact'],
                'created_by' => Auth::id(),
                'status' => 'APPROVE',
             ]);
            $uraian_jabatan_id = $uraian_jabatan_id->id;
            foreach ($data['tugas_pokok_utama'] as $x) {
                // Cek jika 'aktivitas' dan 'output' tidak kosong
                if (!empty($x['aktivitas']) && !empty($x['output'])) {
                    TugasPokoUtamaGenerik::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'aktivitas' => $x['aktivitas'],
                        'output' => $x['output'],
                        'jenis' => 'utama',
                    ]);
                }
            }
            foreach ($data['kompetensi_teknis'] as $x) {
                if (!empty($x['kode_kompetensi']) && !empty($x['level'])) {
                    $master_detail_kompetensi = $x['kode_kompetensi'].'.'.$x['level'];
                    KeterampilanTeknis::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'kode' => $x['kode_kompetensi'],
                        'master_detail_kompetensi_id' => $master_detail_kompetensi,
                        'kategori' => "CORE",
                        'level' => $x['level'],
                    ]);
                }
            }    
            foreach ($data['hubungan_kerja'] as $x) {
                if (!empty($x['komunikasi']) && !empty($x['tujuan']) && !empty($x['jenis'])) {
                    HubunganKerja::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'komunikasi' => $x['komunikasi'],
                        'tujuan' => $x['tujuan'],
                        'jenis' => $x['jenis'],
                    ]);
                }
            }
            foreach ($data['masalah_kompleksitas_kerja'] as $x) {
                if (!empty($x['masalah_kompleksitas_kerja'])) {
                    MasalahKompleksitasKerja::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'definisi' => $x['masalah_kompleksitas_kerja'],
                    ]);
                }
            }
            foreach ($data['wewenang_jabatan'] as $x) {
                if (!empty($x['wewenang_jabatan'])) {
                    WewenangJabatan::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'definisi' => $x['wewenang_jabatan'],
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
                    // Cari data pengalaman berdasarkan jenjang jabatan dan nama pendidikan
                    $pengalaman = MasterPendidikan::select('pengalaman')
                        ->where('jenjang_jabatan', $viewUraianJabatan->jen)
                        ->where('nama', $x['pendidikan'])
                        ->first();

                    // Validasi pengalaman agar hanya angka
                    $pengalamanValue = is_numeric($pengalaman->pengalaman) ? $pengalaman->pengalaman : 0;

                    // Buat entri di tabel SpesifikasiPendidikan
                    SpesifikasiPendidikan::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'pendidikan' => $x['pendidikan'],
                        'pengalaman' => $pengalamanValue, // Pastikan tipe data numerik
                        'bidang_studi' => $x['bidang_studi'] ?? null, // Default ke null jika tidak ada
                    ]);
                }
            };
            return $uraian_jabatan_id;
        } catch (\Exception $e) {
            Log::error('Error saat membuat uraian jabatan: ' . $e->getMessage());
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }
}
