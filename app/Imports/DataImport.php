<?php

namespace App\Imports;

use App\Models\HubunganKerja;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanTeknis;
use App\Models\MasalahKompleksitasKerja;
use App\Models\SpesifikasiPendidikan;
use App\Models\PokoUtamaGenerik;
use App\Models\UraianMasterJabatan;
use App\Models\WewenangJabatan;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
class DataImport implements ToCollection
{

    public function collection(Collection $rows)
    {

     // Parsing Data
     $data = [];
     $data['nama'] = $rows[10][4]; // Baris ke-10 Kolom ke-4 (contoh)
     $data['fungsi_utama'] = $rows[20][1]; // Baris ke-20 Kolom ke-1
     $data['anggaran'] = $rows[63][1] === 'v' ? 'Investasi' : null;
     $data['accountability'] = $rows[67][1] === 'v' ? 'Non Quantifiable' : 'Medium';
     $data['nature_impact'] = $rows[75][1] === 'v' ? 'Prime' : 'Share';

     // Buat data UraianMasterJabatan
     $uraian_jabatan = UraianMasterJabatan::create([
         'nama' => $data['nama'],
         'unit_kd' => 1,
         'fungsi_utama' => 'fungsi_utama fungsi_utama fungsi_utama fungsi_utama',
        //  'fungsi_utama' => $data['fungsi_utama'],
         'anggaran' => $data['anggaran'],
         'accountability' => $data['accountability'],
         'nature_impact' => $data['nature_impact'],
     ]);

     dd($uraian_jabatan);



        // $data = [];
        // $data['master_jabatan'] = $rows[10][4];
        // $data['fungsi_utama'] = $rows[20][1];
        // // tugas_pokok_utama
        // foreach ($rows as $key => $row) {
        //     if ($key >= 26 && $key <= 49) { // Baris 1-5 (Index mulai dari 0)
        //         $data['tugas_pokok_utama'][] = [
        //             'aktifitas' => $row[2], // Sesuaikan kolom
        //             'output' => $row[6],
        //         ];
        //     }
        // }
        // // Dimensi Finansial
        // $anggaran = null;
        // $rows[63][1] == "v" ? $anggaran = "Investasi" : null;
        // $rows[64][1] == "v" ? $anggaran = "Operasional" : null;
        // $data["anggaran"] = $anggaran;
        // // Accountability
        // $accountability = 'Non Quantifiable';
        // $rows[67][1] == 'v' ? $accountability = 'Non Quantifiable' : null;
        // $rows[68][1] == 'v' ? $accountability = 'Very Small' : null;
        // $rows[69][1] == 'v' ? $accountability = 'Small' : null;
        // $rows[70][1] == 'v' ? $accountability = 'Medium' : null;
        // $rows[71][1] == 'v' ? $accountability = 'Large' : null;
        // $rows[72][1] == 'v' ? $accountability = 'Very Large' : null;
        // // $accountability == null ? 'Non Quantifiable' : $accountability;
        // $data["accountability"] = $accountability;
        // // Nature Impact
        // $nature_impact = "";
        // $rows[75][1] == 'v' ? $nature_impact = 'Prime' : null;
        // $rows[76][1] == 'v' ? $nature_impact = 'Share' : null;
        // $rows[77][1] == 'v' ? $nature_impact = 'Contributory' : null;
        // $rows[78][1] == 'v' ? $nature_impact = 'Remote' : null;
        // $data['nature_impact'] = $nature_impact;
        // // HUBUNGAN KERJA
        // foreach ($rows as $key => $row) {
        //     if ($key >= 89 && $key <= 100) { 
        //         $this->hubungan_kerja[] = [
        //             'komunikasi' => $row[2], // Sesuaikan kolom
        //             'tujuan' => $row[3],
        //             'jenis' => 'internal',
        //         ];
        //     }
        // }
        // foreach ($rows as $key => $row) {
        //     if ($key >= 103 && $key <= 110) { 
        //         $this->hubungan_kerja[] = [
        //             'komunikasi' => $row[2], // Sesuaikan kolom
        //             'tujuan' => $row[3],
        //             'jenis' => 'eksternal',
        //         ];
        //     }
        // }
        // // dd($this->hubungan_kerja);
        // $data['hubungan_kerja'] = $this->hubungan_kerja;
        // // MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA
        // foreach ($rows as $key => $row) {
        //     if ($key >= 115 && $key <= 119) { 
        //         $this->masalah_kompleksitas_kerja[] = [
        //             'masalah_kompleksitas_kerja' => $row[2]
        //         ];
        //     }
        // }
        // // dd($this->masalah_kompleksitas_kerja);
        // $data['masalah_kompleksitas_kerja'] = $this->masalah_kompleksitas_kerja;
        // // WEWENANG JABATAN
        // foreach ($rows as $key => $row) {
        //     if ($key >= 124 && $key <= 128) { 
        //         $this->wewenang_jabatan[] = [
        //             'wewenang_jabatan' => $row[2]
        //         ];
        //     }
        // }
        // // dd($this->wewenang_jabatan);
        // $data['wewenang_jabatan'] = $this->wewenang_jabatan;
        // // Pendidikan
        // foreach ($rows as $key => $row) {
        //     if ($key >= 133 && $key <= 136) { 
        //         $this->pendidikan[] = [
        //             'pendidikan' => $row[2],
        //             'pengalaman' => $row[3],
        //             'bidang_studi' => $row[5],
        //         ];
        //     }
        // }
        // // dd($this->pendidikan);
        // $data['pendidikan'] = $this->pendidikan;
        // // kemampuan_pengalaman
        // foreach ($rows as $key => $row) {
        //     if ($key >= 139 && $key <= 143) { 
        //         $this->kemampuan_pengalaman[] = [
        //             'kemampuan_pengalaman' => $row[2],
        //         ];
        //     }
        // }
        // // dd($this->kemampuan_pengalaman);
        // $data['$kemampuan_pengalaman'] = $this->kemampuan_pengalaman;
        // // Kompetensi Teknis
        // foreach ($rows as $key => $row) {
        //     if ($key >= 181 && $key <= 190) { 
        //         $this->kompetensi_teknis[] = [
        //             'kode_kompetensi' => $row[2],
        //             'level' => $row[5],
        //             'kode_perilaku' => $row[2].'.'.$row[5],
        //         ];
        //     }
        // }
        // // dd($this->kompetensi_teknis);
        // $data['kompetensi_teknis'] = $this->kompetensi_teknis;
        // // dd($data['master_jabatan']);
        // // dd($data);


        // // $uraianJabatan = new UraianMasterJabatan();
        // // $uraianJabatan->nama = "MANAGER ORGANIZATION AND WORKFORCE EFFECTIVENESS";
        // // $uraianJabatan->unit_kd = 1;
        // // $uraianJabatan->fungsi_utama = "Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut dijalankan.";
        // // $uraianJabatan->anggaran = null;
        // // $uraianJabatan->accountability = null;
        // // $uraianJabatan->nature_impact = "Share";
        // // $uraianJabatan->save();

        // $uraian_jabatan_id = UraianMasterJabatan::create(
        //     [
        //         'nama' => "MANAGER ORGANIZATION AND WORKFORCE EFFECTIVENESS",
        //         'unit_kd' => 1,
        //         'fungsi_utama' => "Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut dijalankan.",
        //         'anggaran' => null,
        //         'accountability' => null,
        //         'nature_impact' => "Share",
        //     ]
        // );
        // // dd($uraianJabatan);
        // foreach ($data['tugas_pokok_utama'] as $x) {
        //     PokoUtamaGenerik::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'aktivitas' => $x['aktifitas'],
        //         'output' => $x['output'],
        //         'jenis' => 'utama',
        //     ]);
        // }
        // foreach ($data['hubungan_kerja'] as $x) {
        //     HubunganKerja::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'komunikasi'=>$x['komunikasi'],
        //         'tujuan'=>$x['tujuan'],
        //         'jenis'=>$x['jenis'],
        //     ]);
        // }   
        // foreach ($data['masalah_kompleksitas_kerja'] as $x) {
        //     MasalahKompleksitasKerja::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'definisi'=>$x['masalah_kompleksitas_kerja'],
        //     ]);
        // }
        // foreach ($data['wewenang_jabatan'] as $x) {
        //     WewenangJabatan::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'definisi'=>$x['wewenang_jabatan'],
        //     ]);
        // }
        // foreach ($data['pendidikan'] as $x) {
        //     SpesifikasiPendidikan::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'pendidikan'=>$x['pendidikan'],
        //         'pengalaman'=>$x['pengalaman'],
        //         'bidang_studi'=>$x['bidang_studi'],
        //     ]);
        // }
        // foreach ($data['kemampuan_pengalaman'] as $x) {
        //     KemampuandanPengalaman::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'definisi'=>$x['kemampuan_pengalaman'],
        //     ]);
        // }
        // foreach ($data['kompetensi_teknis'] as $x) {
        //     KeterampilanTeknis::create([
        //         'uraian_jabatan_id' => $uraian_jabatan_id->id,
        //         'kode_kompetensi' =>$x['kode_kompetensi'],
        //         'level' =>$x['level'],
        //         'kategori' => 'core',
        //     ]);
        // }
        // return $uraian_jabatan_id;
    }
}
