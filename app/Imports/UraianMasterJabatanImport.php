<?php

namespace App\Imports;

use App\Models\HubunganKerja;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterJabatan;
use App\Models\SpesifikasiPendidikan;
use App\Models\TugasPokoUtamaGenerik;
use App\Models\WewenangJabatan;
use App\Models\UraianMasterJabatan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
            $data['nama'] = isset($rows[10][4]) ? $rows[10][4] : 'Default Nama';
            $data['fungsi_utama'] = isset($rows[21][1]) ? $rows[21][1] : 'Default Fungsi Utama';
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
            $data['tugas_pokok_utama'] = $this->tugas_pokok_utama;

            // HUBUNGAN KERJA
            foreach ($rows as $key => $row) {
                if ($key >= 90 && $key <= 101) {
                    $this->hubungan_kerja[] = [
                        'komunikasi' => $row[2], // Sesuaikan kolom
                        'tujuan' => $row[3],
                        'jenis' => 'internal',
                    ];
                }
            }
            foreach ($rows as $key => $row) {
                if ($key >= 104 && $key <= 111) {
                    $this->hubungan_kerja[] = [
                        'komunikasi' => $row[2], // Sesuaikan kolom
                        'tujuan' => $row[3],
                        'jenis' => 'eksternal',
                    ];
                }
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
            $data['pendidikan'] = $this->pendidikan;
            // kemampuan_pengalaman
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
                    $this->kompetensi_teknis[] = [
                        'kode_kompetensi' => $row[2],
                        'level' => $row[6],
                        'kode_perilaku' => $row[2] . '.' . $row[6],
                    ];
                }
            }
            $data['kompetensi_teknis'] = $this->kompetensi_teknis;

            $master_jabatan = MasterJabatan::where('nama', $data['nama'])->first();

            // dd($master_jabatan);

            if (!$master_jabatan) {
                // Handle error, e.g., return error message or log
                return response()->json(['error' => 'Nama jabatan tidak ditemukan'], 404);
            }
            
            // Buat data UraianMasterJabatan
             $uraian_jabatan_id = UraianMasterJabatan::create([
                'master_jabatan_id' => $master_jabatan->id,
                'nama' => $data['nama'],
                'unit_id' => 1,
                'fungsi_utama' => $data['fungsi_utama'],
                'anggaran' => $data['anggaran'],
                'accountability' => $data['accountability'],
                'nature_impact' => $data['nature_impact'],
            ]);

            $uraian_jabatan_id = $uraian_jabatan_id->id;
            // dd($data);
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
            
            // foreach ($data['pendidikan'] as $x) {
            //     if (!empty($x['pendidikan']) && !empty($x['pengalaman']) && !empty($x['bidang_studi'])) {
            //         SpesifikasiPendidikan::create([
            //             'uraian_master_jabatan_id' => $uraian_jabatan_id,
            //             'pendidikan' => $x['pendidikan'],
            //             'pengalaman' => $x['pengalaman'],
            //             'bidang_studi' => $x['bidang_studi'],
            //         ]);
            //     }
            // }
            
            foreach ($data['kemampuan_pengalaman'] as $x) {
                if (!empty($x['definisi'])) {
                    KemampuandanPengalaman::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'definisi' => $x['definisi'],
                    ]);
                }
            }
            
            foreach ($data['kompetensi_teknis'] as $x) {
                if (!empty($x['kode_kompetensi']) && !empty($x['level'])) {
                    KeterampilanTeknis::create([
                        'uraian_master_jabatan_id' => $uraian_jabatan_id,
                        'kode' => $x['kode_kompetensi'],
                        'kategori' => 'CORE',
                        'level' => $x['level'],
                    ]);
                }
            }            
            
            return $uraian_jabatan_id;
        } catch (\Exception $e) {
            Log::error('Error saat membuat uraian jabatan: ' . $e->getMessage());
        }
    }
}
