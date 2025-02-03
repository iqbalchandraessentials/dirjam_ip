<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MappingKompetensiNonTeknisExport;
use App\Exports\MappingKompetensiTeknisExport;
use App\Exports\MasterDefaultDataExport;
use App\Exports\MasterJabatanUnitExport;
use App\Exports\MasterKompetensiNonTeknisExport;
use App\Exports\MasterKompetensiTeknisExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use iio\libmergepdf\Merger;
use PDF;

class ExportController extends Controller
{
    protected $templateJabatanController;
    protected $UraianJabatanController;

    public function __construct(TemplateJabatanController $templateJabatanController, UraianJabatanController $UraianJabatanController)
    {
        $this->templateJabatanController = $templateJabatanController;
        $this->UraianJabatanController = $UraianJabatanController;
    }

    public function exportMasterKompetensiTeknis()
    {
        return Excel::download(new MasterKompetensiTeknisExport, 'Master Kompentensi Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMappingKompetensiTeknis()
    {
        return Excel::download(new MappingKompetensiTeknisExport, 'Mapping Kompentensi Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMasterJabatanUnit()
    {
        return Excel::download(new MasterJabatanUnitExport, 'Master Jabatan Unit.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMasterKompetensiNonTeknis()
    {
        return Excel::download(new MasterKompetensiNonTeknisExport, 'Master Kompentensi Non Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMappingKompetensiNonTeknis()
    {
        return Excel::download(new MappingKompetensiNonTeknisExport, 'Mapping Kompentensi Non Teknis.'. date('d-m-Y H-i-s') .'.xlsx');
    }
    public function exportMasterDefaultData()
    {
        return Excel::download(new MasterDefaultDataExport, 'Master Default Data.'. date('d-m-Y H-i-s') .'.xlsx');
    }
       

    public function exportUraianJabatanPdf($id)
    {
        $data = $this->UraianJabatanController->getDatas($id);
        // 1. Generate PDF untuk bagian selain Struktur Organisasi
        $pdfPortrait = PDF::loadView('pages.uraian_jabatan.pdf_report', ['data' => $data]);
        $pathPortrait = storage_path('app/temp_portrait.pdf');
        file_put_contents($pathPortrait, $pdfPortrait->output());

        // 2. Generate PDF khusus untuk Struktur Organisasi (landscape)
        $pdfLandscape = PDF::loadView('pages.uraian_jabatan.pdf_struktur_organisasi', ['data' => $data]);
        $pdfLandscape->setPaper('A4', 'landscape');
        $pathLandscape = storage_path('app/temp_landscape.pdf');
        file_put_contents($pathLandscape, $pdfLandscape->output());

        // 3. Gabungkan kedua PDF
        $merger = new Merger();
        $merger->addFile($pathPortrait);
        $merger->addFile($pathLandscape);
        $finalPdf = $merger->merge();

        // 4. Hapus file sementara
        unlink($pathPortrait);
        unlink($pathLandscape);
        $name = "URAIAN_JABATAN-" . str_replace(' ', '-', $data['jabatan']['jabatan']) . "-" . date('d-m-Y_H-i-s') . ".pdf";

        return response($finalPdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
    }

    public function exportTemplateJabatanPdf($id)
    {
        $data = $data = $this->templateJabatanController->getDatas($id);
        // 1. Generate PDF untuk bagian selain Struktur Organisasi
        $pdfPortrait = PDF::loadView('pages.template.pdf_report', [ 'data' => $data ]);
        
        $pathPortrait = storage_path('app/temp_portrait.pdf');
        file_put_contents($pathPortrait, $pdfPortrait->output());

        // 2. Generate PDF khusus untuk Struktur Organisasi (landscape)
        $pdfLandscape = PDF::loadView('pages.uraian_jabatan.pdf_struktur_organisasi', ['data' => $data]);
        $pdfLandscape->setPaper('A4', 'landscape');
        $pathLandscape = storage_path('app/temp_landscape.pdf');
        file_put_contents($pathLandscape, $pdfLandscape->output());

        // 3. Gabungkan kedua PDF
        $merger = new Merger();
        $merger->addFile($pathPortrait);
        $merger->addFile($pathLandscape);
        $finalPdf = $merger->merge();

        // 4. Hapus file sementara
        unlink($pathPortrait);
        unlink($pathLandscape);
        $name = "Template_Jabatan_" . $data['nama'] . date('d-m-Y H-i-s') . ".pdf";
        return response($finalPdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
    }


    // public function exportTemplateJabatanPdf($id)
    // {
    //     $data = $data = $this->templateJabatanController->getDatas($id);
    //     $pdf = PDF::loadView('pages.template.pdf_report', [ 'data' => $data ]);
    //     $name = "Template_Jabatan_" . $data['nama'] . date('d-m-Y H-i-s') . ".pdf";
    //     return $pdf->download($name);
    // }



    public function exportUraianJabatanExcel($id)
    {
        $data = $this->UraianJabatanController->getDatas($id);
        // dd($data[]);
        // dd($data['fungsi_utama']);
        // dd($data['komunikasi_internal']->count());
        $templatePath = public_path('/template/Template_Urjab.xlsx');
        // Load file template Excel
        $spreadsheet = IOFactory::load($templatePath);    
        $objPHPExcel = $spreadsheet->getActiveSheet();
        $objPHPExcel->setCellValue("A6", strtoupper($data['jabatan']['jabatan']));
        $objPHPExcel->setCellValue("G4", "");
        $objPHPExcel->setCellValue("G5", "");
        $objPHPExcel->setCellValue("G6", "");
        $objPHPExcel->setCellValue("G7", "SUDAH DI VALDASI");
        // Sebutan Jabatan                  
        $objPHPExcel->setCellValue("E11", $data['jabatan']['jabatan']);
        // Jenjang Jabatan
        $objPHPExcel->setCellValue("E12", strtoupper($data['jabatan']['jenjangJabatan']['nama']));
        // KELOMPOK PROFESI        
        $objPHPExcel->setCellValue("E13", strtoupper($data['jabatan']['namaProfesi']['nama_profesi'] ?? $data['jabatan']['namaProfesi']));
        // Divisi/Departemen/Bidang/Bagian
        $objPHPExcel->setCellValue("E14", $data['jabatan']['divisi']);
         // Unis Kerja
         $objPHPExcel->setCellValue("E15", strtoupper($data['jabatan']['description']) );
         // Atasan Langsung       
         $objPHPExcel->setCellValue("E16", $data['jabatan']['atasan_langsung']);
        //  Fungsi Utama
        $objPHPExcel->setCellValue("B20", $data["fungsi_utama"]);
        $objPHPExcel->getStyle("B20")->getAlignment()->setWrapText(true);
        $n = ceil(strlen($data["fungsi_utama"]) / 86) * 16;
        $objPHPExcel->getRowDimension(20)->setRowHeight($n);
        // 
        /* TANGGUNG JAWAB UTAMA */
        $baris = 25;
        $no = 1;
        foreach ($data['aktivitas'] as $key) {
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", $key->aktivitas);
            $objPHPExcel->setCellValue("G$baris", $key->output);
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->getStyle("C$baris:H$baris")
                ->getAlignment()->setWrapText(true);
            $n = ceil(strlen($key->aktivitas) / 47) * 16;
            $objPHPExcel->getRowDimension($baris)->setRowHeight($n);
            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel
                ->getStyle("C$baris:H$baris")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $baris++;
            $no++;
        }
        // Tambahkan baris kosong jika data kurang dari 20
        for ($i = $no; $i <= 25; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", ""); 
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel
                ->getStyle("C$baris:H$baris")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $baris++;
        }
        // 
        // TANGGUNG JAWAB GENERIK
        $baris++;
        $objPHPExcel->setCellValue("A$baris", " 4.");
        $objPHPExcel->setCellValue("B$baris", "TUGAS POKOK GENERIK DAN OUTPUT");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);

        $baris++;
        $text = "Merupakan rincian aktivitas-aktivitas umum yang diperlukan suatu jabatan sesuai jenis jabatan tersebut, yang dilengkapi dengan informasi yang merujuk hasil kerja dapat berupa dokumen, laporan atau dokumentasi dalam bentuk lain yang dapat dipertanggungjawabkan hasilnya.";
        $objPHPExcel->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);

        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);

        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Aktivitas");
        $objPHPExcel->setCellValue("G$baris", "Output");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("C$baris:F$baris");
        $objPHPExcel->mergeCells("G$baris:H$baris");

        $baris++;
        $no = 1;
        $rowsCount = $data['aktivitas_generik']->count();
        foreach ($data['aktivitas_generik'] as $key) {
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", $key->aktivitas);
            $objPHPExcel->setCellValue("G$baris", $key->output);
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->getStyle("C$baris:H$baris")
                ->getAlignment()->setWrapText(true);

            $n = ceil(strlen($key->aktivitas) / 47) * 16; 
            $objPHPExcel->getRowDimension($baris)->setRowHeight($n);

            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel
                ->getStyle("C$baris:H$baris")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $baris++;
            $no++;
        }

        for ($i = $rowsCount + 1; $i <= 6; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $baris++;
        }
        // Dimensi Jabatan
        $objPHPExcel->setCellValue("A$baris", "5. ");
        $objPHPExcel->setCellValue("B$baris", "DIMENSI JABATAN");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Memuat semua data relevan yang dapat diukur dan digunakan untuk menggambarkan cakupan atau besarnya tanggung jawab yang dipegang termasuk ringkasan data kuantitatif dan kualitatif yang terkait dengan besarnya tugas ini.";
        $objPHPExcel->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $maxWidth = 86; 
        $rowHeightPerLine = 16; 
        $numLines = ceil(strlen($text) / $maxWidth); 
        $objPHPExcel->getRowDimension($baris)->setRowHeight($numLines * $rowHeightPerLine);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "5.a. Dimensi Finansial");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", isset($data['anggaran']) && $data['anggaran'] == 'Investasi' ? 'V' : '');
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Anggaran Investasi");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", isset($data['anggaran']) && $data['anggaran'] == 'Operasional' ? 'V' : '');
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Anggaran Operasional");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("G$baris", "Accountability");
        $objPHPExcel->getStyle("G$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ""); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $input = isset($data['accountability']) && $data['accountability'] == null ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->setCellValue("E$baris", "Non Quantifiable");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "< 650 Juta");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Very Small' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->setCellValue("E$baris", "Very Small");
        $objPHPExcel->mergeCells("E$baris:F$baris");

        $objPHPExcel->setCellValue("G$baris", "650 Juta - 6,5 Milyar");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Small' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Small");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "6,5 Milyar - 65 Milyar");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Medium' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Medium");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "65 Milyar - 650 Milyar");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Large' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Large");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "650 Milyar - 6,5 Trilyun");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Very Large' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Very Large");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "6,5 Trilyun - 65 Trilyun");
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("E$baris", "Nature Impact");
        $objPHPExcel->getStyle("E$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Prime' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Prime");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Share' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Share");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Contributory' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Contributory");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Remote' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Remote");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        // 
        // Dimensi Non-keuangan
        // 
        $objPHPExcel->setCellValue("B$baris", "5.b. Dimensi Non-keuangan");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "a. Jumlah staff yang dikelola di sub bidangnya sesuai FTK");
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "    Jumlah Bawahan");
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "    Langsung :");
        $objPHPExcel->mergeCells("C$baris:D$baris");
        // bawahan langsung
        $objPHPExcel->setCellValue("E$baris", $data['jabatan']['bawahan_langsung'] ?? '0');
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "    Total :");
        $objPHPExcel->mergeCells("C$baris:D$baris");
        $objPHPExcel->setCellValue("E$baris", $data['jabatan']['total_bawahan'] ?? '0');
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "b. Proses bisnis yang dikelola di sub bidangnya");
        // Hubungan Kerja Internal
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("A$baris", " 6.");
        $objPHPExcel->setCellValue("B$baris", "HUBUNGAN KERJA");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Menggambarkan hubungan kedinasan antara pemegang jabatan dengan jabatan lain dalam perusahaan maupun di perusahaan lain, yang disertai dengan deskripsi tujuan dari hubungan kerja tersebut.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Komunikasi Internal");
        $objPHPExcel->setCellValue("D$baris", "Tujuan");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:H$baris");
        $baris++;
        $no = 1;
            $rowsCount = $data['komunikasi_internal']->count(); 
            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            foreach ($data['komunikasi_internal'] as $key) {
                if ($key['subjek'] || $key['komunikasi']){
                    $objPHPExcel->setCellValue("B$baris", $no);
                    $objPHPExcel->setCellValue("C$baris", $key['subjek'] ? $key['subjek'] : $key['komunikasi']);
                    $objPHPExcel->setCellValue("D$baris", $key->tujuan);
                    $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                    $objPHPExcel->mergeCells("D$baris:H$baris");
                    $no++;
                    $baris++;
                }
            }
            for ($i = $rowsCount + 1; $i <= 12; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:H$baris");
                $baris++;
            }
        $baris++;
        // Hubungan Kerja Eksternal
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Komunikasi Eksternal");
        $objPHPExcel->setCellValue("D$baris", "Tujuan");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:H$baris");
        $baris++;
            $no = 1;
            $rowsCount = $data['komunikasi_external']->count(); 
            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            foreach ($data['komunikasi_external'] as $key) {
                if ($key['subjek'] || $key['komunikasi']){
                    $objPHPExcel->setCellValue("B$baris", $no);
                    $objPHPExcel->setCellValue("C$baris", $key['subjek'] ? $key['subjek'] : $key['komunikasi']);
                    $objPHPExcel->setCellValue("D$baris", $key->tujuan);
                    $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                    $objPHPExcel->mergeCells("D$baris:H$baris");
                    $no++;
                    $baris++;
                }
            }
            for ($i = $rowsCount + 1; $i <= 8; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:H$baris");
                $baris++;
            }
        $baris++;
        // 
        /* MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA */
        $objPHPExcel->setCellValue("A$baris", " 7.");
        $objPHPExcel->setCellValue("B$baris", "MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Merupakan uraian atas hal-hal yang menjadi permasalahan bagi pemangku jabatan sebagai akibat dari adanya kesulitan dalam pencapaian tujuan atau target yang ditetapkan.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("C$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = $data['tantangan']->count();
        $input = $objPHPExcel->getStyle("B25:G25"); // kolom
        foreach ($data['tantangan'] as $key) {
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", isset($key['tantangan']) ? $key['tantangan']  : $key['definisi']);
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $no++;
            $baris++;
        }
        for ($i = $rowsCount + 1; $i <= 5; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $baris++;
        }
        // WEWENANG JABATAN
        $baris++;
        $objPHPExcel->setCellValue("A$baris", " 8.");
        $objPHPExcel->setCellValue("B$baris", "WEWENANG JABATAN");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Menjelaskan sejauh mana peran jabatan ini dalam pengambilan keputusan dan dampak apa yang dapat ditimbulkan dari keputusan yang diambilnya.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "WEWENANG JABATAN");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("C$baris:H$baris");
        $baris++;
            $no = 1;
            $rowsCount = $data['pengambilan_keputusan']->count();
            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            foreach ($data['pengambilan_keputusan'] as $key) {
                $objPHPExcel->setCellValue("B$baris", $no);
                $objPHPExcel->setCellValue("C$baris", isset($key['pengambilan_keputusan']) ? $key['pengambilan_keputusan'] : $key['definisi']);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("C$baris:H$baris");
                $no++;
                $baris++;
            }
            for ($i = $rowsCount + 1; $i <= 5; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("C$baris:H$baris");
                $baris++;
            }
        $baris++;
        // SPESIFIKASI JABATAN
        $objPHPExcel->setCellValue("A$baris", " 9.");
        $objPHPExcel->setCellValue("B$baris", "SPESIFIKASI JABATAN");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:D$baris");
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Menguraikan dan menjelaskan pendidikan, pengetahuan pokok, keterampilan dan pengalaman minimal serta kompetensi yang diperlukan untuk mencapai tujuan jabatan, yang terdiri atas kualifikasi jabatan, kemampuan dan pengalaman, dan kompetensi.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Pendidikan");
        $objPHPExcel->setCellValue("D$baris", "Exp.");
        $objPHPExcel->setCellValue("F$baris", "Bidang Studi");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("F$baris:H$baris");
        $baris++;
        $no = 1;


        $no = 1;
        $rowsCount = count($data['pendidikan']); // uraian jabatan urjab
        $input = $objPHPExcel->getStyle("B27:G27");

        foreach ($data['pendidikan'] as $key) {
            // Mengambil bidang studi berdasarkan map_pendidikan_id
            $bidangQuery = (new \App\Models\M_MAP_PENDIDIKAN())->getBidang($key->map_pendidikan_id);
            $bidangStudiFormatted = '';

            if ($bidangQuery->count() == 1) {
                foreach ($bidangQuery as $b) {
                    $bidangStudiFormatted .= $b->bidang_studi;
                }
            } elseif ($bidangQuery->count() > 1) {
                $bidangStudiFormatted = '';
                foreach ($bidangQuery as $index => $b) {
                    $bidangStudiFormatted .= ($index + 1) . '. ' . trim($b->bidang_studi) . "\n";
                }
            }

            // Menentukan pengalaman kerja
            $pengalaman = ($key->pengalaman == '' || $key->pengalaman == 'FG' || $key->pengalaman == 0)
                ? 'Fresh Graduate'
                : "Pengalaman minimal $key->pengalaman tahun";

            // Menulis ke dalam file Excel
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", $key->pendidikan);
            $objPHPExcel->setCellValue("D$baris", $pengalaman);
            $objPHPExcel->setCellValue("F$baris", isset($key->id) ? $key->bidang_studi : $bidangStudiFormatted);
            
            // Styling dan merging
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("F$baris:H$baris");

            $baris++;
            $no++;
        }

        // Jika data kurang dari 4, tambahkan baris kosong
        for ($i = $rowsCount + 1; $i <= 4; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->setCellValue("D$baris", "");
            $objPHPExcel->setCellValue("F$baris", "");
            
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("F$baris:H$baris");

            $baris++;
        }


        // $rowsCount = $data['pendidikan']->count();
        // $input = $objPHPExcel->getStyle("B25:G25"); // kolom
        // foreach ($data['pendidikan'] as $i => $item) {
        //     // Set nomor urut
        //     $objPHPExcel->setCellValue("B$baris", $no);
        
        //     // Set pendidikan
        //     $objPHPExcel->setCellValue("C$baris", $item->pendidikan);
        
        //     // Tentukan pengalaman
        //     $pengalaman = ($item->pengalaman == '' || $item->pengalaman == 'FG' || $item->pengalaman == 0)
        //         ? 'Fresh graduate'
        //         : "Pengalaman minimal $item->pengalaman tahun";
        //     $objPHPExcel->setCellValue("D$baris", $pengalaman);
        
        //     // Format bidang studi
        //     $bidangQuery = (new \App\Models\M_MAP_PENDIDIKAN())->getBidang($item->map_pendidikan_id);
        //     $bidangStudiFormatted = '';
        //     if ($bidangQuery->count() == 1) {
        //         foreach ($bidangQuery as $b) {
        //             $bidangStudiFormatted .= $b->bidang_studi;
        //         }
        //     } elseif ($bidangQuery->count() > 1) {
        //         $index = 1;
        //         foreach ($bidangQuery as $b) {
        //             $bidangStudiFormatted .= "$index. " . trim($b->bidang_studi) . "\n";
        //             $index++;
        //         }
        //     }
        
        //     // Set bidang studi ke kolom F
        //     $objPHPExcel->setCellValue("F$baris", $bidangStudiFormatted);
        
        //     // Duplicate style and merge cells
        //     $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        //     $objPHPExcel->mergeCells("D$baris:E$baris");
        //     $objPHPExcel->mergeCells("F$baris:H$baris");
        
        //     // Increment baris dan nomor urut
        //     $baris++;
        //     $no++;
        // }
        
        // // Tambahkan baris kosong jika diperlukan hingga baris ke-4
        // for ($i = $rowsCount + 1; $i <= 4; $i++) {
        //     $objPHPExcel->setCellValue("B$baris", $i);
        //     $objPHPExcel->setCellValue("C$baris", "");
        //     $objPHPExcel->setCellValue("D$baris", "");
        //     $objPHPExcel->setCellValue("F$baris", "");
        //     $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        //     $objPHPExcel->mergeCells("D$baris:E$baris");
        //     $objPHPExcel->mergeCells("F$baris:H$baris");
        //     $baris++;
        // }
        
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "Kemampuan dan Pengalaman");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $rowsCount = $data['kemampuan_dan_pengalaman']->count();
        $huruf = 'a'; // Mulai dari huruf "a"
        foreach ($data['kemampuan_dan_pengalaman'] as $v) {
            $objPHPExcel->setCellValue("B$baris", "$huruf.");
            $objPHPExcel->setCellValue("C$baris", $v->definisi);
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $baris++; // Pindah ke baris berikutnya
            $huruf++; // Inkrementasi huruf (dari "a" menjadi "b", dan seterusnya)
        }for ($i = $rowsCount + 1; $i <= 5; $i++) {
            $objPHPExcel->setCellValue("B$baris", "$huruf.");
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $baris++;
            $huruf++;
        }
        $baris++;
        $objPHPExcel->setCellValue("A$baris", "10.");
        $objPHPExcel->setCellValue("B$baris", "STRUKTUR ORGANISASI");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi jabatan atasan langsung, bawahan langsung serta rekan kerja (peers).";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("A$baris", "11.");
        $objPHPExcel->setCellValue("B$baris", "KEBUTUHAN KOMPETENSI JABATAN (KKJ)");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Memberikan informasi mengenai kebutuhan kemahiran/kompetensi yang diharapkan dalam suatu jabatan.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        /* PERSYARATAN KOMPETENSI  */
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Utama");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi perilaku yang harus dimiliki oleh seluruh individu Pegawai dalam organisasi, pada semua fungsi dan Jenjang Jabatan.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("F$baris", "Penjelasan");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("F$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = $data['keterampilan_non_teknis']->WHERE('kategori', 'UTAMA')->count();
        $input = $objPHPExcel->getStyle("B25:G25"); // kolom
        foreach ($data['keterampilan_non_teknis']->WHERE('kategori', 'UTAMA') as $key) {
            $objPHPExcel->setCellValue("B$baris", " $no.");
            $objPHPExcel->setCellValue("C$baris", $key->kode);
            $objPHPExcel->setCellValue("D$baris", $key->detail->nama);
            $objPHPExcel->setCellValue("F$baris", $key['detail']['definisi'] ?? '');
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("F$baris:H$baris");
            $baris++;
            $no++;
        }
        for ($i = $rowsCount + 1; $i <= 5; $i++) {
            $objPHPExcel->setCellValue("B$baris", "$i.");
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->setCellValue("F$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("F$baris:H$baris");
                $baris++;
        }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Peran");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi perilaku yang dipersyaratkan agar individu Pegawai dapat berhasil dalam suatu posisi, peran, dan Jenjang Jabatan yang spesifik.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("F$baris", "Kategori");
        $objPHPExcel->setCellValue("G$baris", "Penjelasan");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("G$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = $data['keterampilan_non_teknis']->WHERE('kategori', 'PERAN')->count();
        $input = $objPHPExcel->getStyle("B25:G25"); // kolom
        foreach ($data['keterampilan_non_teknis']->WHERE('kategori', 'PERAN') as $key) {
                $objPHPExcel->setCellValue("B$baris", " $no.");
                $objPHPExcel->setCellValue("C$baris", $key['kode']);
                $objPHPExcel->setCellValue("D$baris", $key['detail']['nama']);
                $objPHPExcel->setCellValue("F$baris", $key['jenis']);
                $objPHPExcel->setCellValue("G$baris", $key['detail']['definisi']);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("G$baris:H$baris");
                $baris++;
                $no++;
            }
         for ($i = $rowsCount + 1; $i <= 4; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->setCellValue("D$baris", "");
            $objPHPExcel->setCellValue("F$baris", "");
            $objPHPExcel->setCellValue("G$baris", "");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $baris++;
        }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Fungsi");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi perilaku yang harus dimiliki untuk setiap fungsi bisnis di dalam organisasi.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("F$baris", "Kategori");
        $objPHPExcel->setCellValue("G$baris", "Penjelasan");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("G$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data["keterampilan_non_teknis"]->WHERE('kategori', 'FUNGSI')); 
        $input = $objPHPExcel->getStyle("B25:G25"); // kolom
        foreach ($data["keterampilan_non_teknis"]->WHERE('kategori', 'FUNGSI') as $key) {
                $objPHPExcel->setCellValue("B$baris", " $no.");
                $objPHPExcel->setCellValue("C$baris", $key->kode);
                $objPHPExcel->setCellValue("D$baris", $key['detail']['nama']);
                $objPHPExcel->setCellValue("F$baris", strtoupper($key['jenis']));
                $objPHPExcel->setCellValue("G$baris", $key['detail']['definisi']);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("G$baris:H$baris");
                $baris++;
                $no++;
            } 
            for ($i = $rowsCount + 1; $i <= 8; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->setCellValue("F$baris", "");
                $objPHPExcel->setCellValue("G$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("G$baris:H$baris");
                $baris++;
            }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Teknis");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi terkait dengan pengetahuan, keterampilan dan keahlian yang diperlukan sesuai dengan tugas pokok masing-masing individu Pegawai untuk menyelesaikan pekerjaan-pekerjaan secara teknis pada jabatannya.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("G$baris", "Kategori");
        $objPHPExcel->setCellValue("F$baris", "Level Profisiensi");
        $objPHPExcel->setCellValue("H$baris", "Penjelasan");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $input = $objPHPExcel->getStyle("B24:G24"); // header
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = $data['keterampilan_teknis']->count();
        foreach ($data['keterampilan_teknis'] as $key) {
            $objPHPExcel->setCellValue("B$baris", " $no.");
            $objPHPExcel->setCellValue("C$baris", $key->kode);
            $objPHPExcel->setCellValue("D$baris", $key['master']['nama']);
            $objPHPExcel->setCellValue("F$baris", $key['level']);
            $objPHPExcel->setCellValue("G$baris", $key['kategori']);
            $objPHPExcel->setCellValue("H$baris", $key->detailMasterKompetensiTeknis->perilaku);
            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $baris++;
            $no++;
        }
        for ($i = $rowsCount + 1; $i <= 14; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->setCellValue("D$baris", "");
            $objPHPExcel->setCellValue("F$baris", "");
            $objPHPExcel->setCellValue("G$baris", "");
            $objPHPExcel->setCellValue("H$baris", "");
            $input = $objPHPExcel->getStyle("B25:G25"); // kolom
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $baris++;
        }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "Keterangan :");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi primer adalah Kompetensi yang wajib dimiliki oleh individu yang menduduki suatu Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi sekunder adalah Kompetensi yang perlu dimiliki untuk mendukung individu yang menduduki suatu Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi core adalah Kompetensi teknis yang wajib dimiliki berdasarkan tugas pokok sesuai fungsi utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi enabler adalah Kompetensi teknis yang perlu dimiliki untuk mendukung tugas pokok sesuai fungsi utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis.");
        $baris++;
        $objPHPExcel->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getStyle('E')->getAlignment()->setWrapText(true);
        $objPHPExcel->getDefaultRowDimension()->setRowHeight(-1);
        $exportPath = storage_path('/exports/URAIAN_JABATAN_' . $data['jabatan']['jabatan'] . date('d-m-Y H-i-s') .'.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($exportPath);
        return response()->download($exportPath)->deleteFileAfterSend(true);
    }

    public function exportExcelTemplateJabatan($id)

    {
        $data = $this->templateJabatanController->getDatas($id);
        if(!empty($data['hubunganKerja'][0]['jenis'])) {
            $param = 'jenis';
            $ex = 'eksternal';
        }  else {
            $param ='lingkup_flag';
            $ex = 'external';
        }
        $templatePath = public_path('/template/Template_Dirjab.xlsx');
        // Load file template Excel
        $spreadsheet = IOFactory::load($templatePath);    
        $objPHPExcel = $spreadsheet->getActiveSheet();
        // $objPHPExcel->setCellValue("A6", strtoupper($data["unit_id"]));
        $objPHPExcel->setCellValue("G4", isset($data['created_at']) ? date_format($data['created_at'],'d-m-Y') : '-' );
        $objPHPExcel->setCellValue("G5", "-");
        $objPHPExcel->setCellValue("G6", "-");
        $objPHPExcel->setCellValue("G7", "SUDAH DI VALDASI");
        $objPHPExcel->setCellValue("E11", $data['nama']);
        // Sebutan Jabatan        
        $dataToInsert = "";
        foreach ($data['jabatans'] as $key) {
            $dataToInsert .= "-" .$key['jabatan'] ."\n";
        }           
        $objPHPExcel->setCellValue("E12", $dataToInsert);
        $objPHPExcel->getStyle("E12")->getAlignment()->setWrapText(true);
        $n = ceil(strlen($dataToInsert) / 25) * 16;
        $objPHPExcel->getRowDimension(12)->setRowHeight($n);
        // Jenis Jabatan
        $objPHPExcel->setCellValue("E13", $data['type']);
        // Jenjang Jabatan
        $objPHPExcel->setCellValue("E14", strtoupper($data['masterJabatan']['jenjangJabatan']['nama']));
        // KELOMPOK PROFESI
        $dataToInsert = "";
        foreach ($data['jabatans'] as $key) {
            $dataToInsert .= "-" . strtoupper($key['namaProfesi']['nama_profesi']) ?? 'Tidak ada nama_profesi' ."\n";
        }           
        $objPHPExcel->setCellValue("E15", $dataToInsert);
        $objPHPExcel->getStyle("E15")->getAlignment()->setWrapText(true);
        $n = ceil(strlen($dataToInsert) / 25) * 16;
        $objPHPExcel->getRowDimension(12)->setRowHeight($n);
        // stream Bisnis
        $objPHPExcel->setCellValue("E16", "");
         // Unis Kerja
         $dataToInsert = "";
         foreach ($data['jabatans'] as $key) {
             $dataToInsert .= "-" . strtoupper($key['description']) ."\n";
         }           
         $objPHPExcel->setCellValue("E17", $dataToInsert);
         $objPHPExcel->getStyle("E17")->getAlignment()->setWrapText(true);
         $n = ceil(strlen($dataToInsert) / 25) * 16;
         $objPHPExcel->getRowDimension(12)->setRowHeight($n);
         // Atasan Langsung
         $dataToInsert = "";
         foreach ($data['jabatans'] as $key) {
             $dataToInsert .= "-" .$key['atasan_langsung'] ?? 'Tidak ada atasan_langsung' ."\n";
         }           
         $objPHPExcel->setCellValue("E18", $dataToInsert);
         $objPHPExcel->getStyle("E18")->getAlignment()->setWrapText(true);
         $n = ceil(strlen($dataToInsert) / 25) * 16;
         $objPHPExcel->getRowDimension(12)->setRowHeight($n);
        //  Fungsi Utama
        $objPHPExcel->setCellValue("B22", $data["fungsi_utama"]);
        $objPHPExcel->getStyle("B22")->getAlignment()->setWrapText(true);
        $n = ceil(strlen($data["fungsi_utama"]) / 86) * 16;
        $objPHPExcel->getRowDimension(22)->setRowHeight($n);
        // 
        /* TANGGUNG JAWAB UTAMA */
        $baris = 27;
        $no = 1;
        foreach ($data['tugasPokoUtamaGenerik'] as $key) {
            if (isset($v['jenis']) == 'utama'){
                $objPHPExcel->setCellValue("B$baris", $no);
                $objPHPExcel->setCellValue("C$baris", $key->aktivitas);
                $objPHPExcel->setCellValue("G$baris", $key->output);
            } else {
                $objPHPExcel->setCellValue("B$baris", $no);
                $objPHPExcel->setCellValue("C$baris", $key->aktivitas);
                $objPHPExcel->setCellValue("G$baris", '');
            }
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->getStyle("C$baris:H$baris")
                ->getAlignment()->setWrapText(true);
            $n = ceil(strlen($key->aktivitas) / 47) * 16;
            $objPHPExcel->getRowDimension($baris)->setRowHeight($n);
            $input = $objPHPExcel->getStyle("B27:G27");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel
                ->getStyle("C$baris:H$baris")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $baris++;
            $no++;
        }
        // Tambahkan baris kosong jika data kurang dari 20
        for ($i = $no; $i <= 25; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", ""); 
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel
                ->getStyle("C$baris:H$baris")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $baris++;
        }
        // 
        // TANGGUNG JAWAB GENERIK
        $baris++;
        $objPHPExcel->setCellValue("A$baris", " 4.");
        $objPHPExcel->setCellValue("B$baris", "TUGAS POKOK GENERIK DAN OUTPUT");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);

        $baris++;
        $text = "Merupakan rincian aktivitas-aktivitas umum yang diperlukan suatu jabatan sesuai jenis jabatan tersebut, yang dilengkapi dengan informasi yang merujuk hasil kerja dapat berupa dokumen, laporan atau dokumentasi dalam bentuk lain yang dapat dipertanggungjawabkan hasilnya.";
        $objPHPExcel->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);

        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);

        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Aktivitas");
        $objPHPExcel->setCellValue("G$baris", "Output");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("C$baris:F$baris");
        $objPHPExcel->mergeCells("G$baris:H$baris");

        $baris++;
        $no = 1;
        $rowsCount = count($data['tugas_pokok_generik']);
        foreach ($data['tugas_pokok_generik'] as $key) {
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", $key->aktivitas);
            $objPHPExcel->setCellValue("G$baris", $key->output);
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->getStyle("C$baris:H$baris")
                ->getAlignment()->setWrapText(true);

            $n = ceil(strlen($key->aktivitas) / 47) * 16; 
            $objPHPExcel->getRowDimension($baris)->setRowHeight($n);

            $input = $objPHPExcel->getStyle("B27:G27");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel
                ->getStyle("C$baris:H$baris")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $baris++;
            $no++;
        }

        for ($i = $rowsCount + 1; $i <= 6; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->mergeCells("C$baris:F$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $baris++;
        }
        // Dimensi Jabatan
        $objPHPExcel->setCellValue("A$baris", "5. ");
        $objPHPExcel->setCellValue("B$baris", "DIMENSI JABATAN");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Memuat semua data relevan yang dapat diukur dan digunakan untuk menggambarkan cakupan atau besarnya tanggung jawab yang dipegang termasuk ringkasan data kuantitatif dan kualitatif yang terkait dengan besarnya tugas ini.";
        $objPHPExcel->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $maxWidth = 86; 
        $rowHeightPerLine = 16; 
        $numLines = ceil(strlen($text) / $maxWidth); 
        $objPHPExcel->getRowDimension($baris)->setRowHeight($numLines * $rowHeightPerLine);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "5.a. Dimensi Finansial");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", isset($data['anggaran']) && $data['anggaran'] == 'Investasi' ? 'V' : '');
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Anggaran Investasi");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", isset($data['anggaran']) && $data['anggaran'] == 'Operasional' ? 'V' : '');
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Anggaran Operasional");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("G$baris", "Accountability");
        $objPHPExcel->getStyle("G$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ""); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $input = isset($data['accountability']) && $data['accountability'] == 'Non Quantifiable' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->setCellValue("E$baris", "Non Quantifiable");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "< 650 Juta");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Very Small' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->setCellValue("E$baris", "Very Small");
        $objPHPExcel->mergeCells("E$baris:F$baris");

        $objPHPExcel->setCellValue("G$baris", "650 Juta - 6,5 Milyar");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Small' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Small");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "6,5 Milyar - 65 Milyar");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Medium' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Medium");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "65 Milyar - 650 Milyar");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Large' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Large");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "650 Milyar - 6,5 Trilyun");
        $baris++;
        $input = isset($data['accountability']) && $data['accountability'] == 'Very Large' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Very Large");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $objPHPExcel->setCellValue("G$baris", "6,5 Trilyun - 65 Trilyun");
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("E$baris", "Nature Impact");
        $objPHPExcel->getStyle("E$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Prime' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Prime");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Share' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Share");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Contributory' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Contributory");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        $input = isset($data['nature_impact']) && $data['nature_impact'] == 'Remote' ? 'V' : '';
        $objPHPExcel->setCellValue("B$baris", $input); 
        $objPHPExcel->mergeCells("B$baris:C$baris");
        $objPHPExcel->getStyle("B$baris:C$baris")->applyFromArray([
            'borders' => [
                'outline' => [
                    'style' =>Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setWrapText(true);
        $objPHPExcel->getStyle("B$baris:C$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->setCellValue("E$baris", "Remote");
        $objPHPExcel->mergeCells("E$baris:F$baris");
        $baris++;
        // 
        // Dimensi Non-keuangan
        // 
        $objPHPExcel->setCellValue("B$baris", "5.b. Dimensi Non-keuangan");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "a. Jumlah staff yang dikelola di sub bidangnya sesuai FTK");
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "    Jumlah Bawahan");
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "    Langsung :");
        $objPHPExcel->mergeCells("C$baris:D$baris");
        $input = '';        
        foreach ($data['jabatans'] as $key) {
            $input .= "-  ".  $key['bawahan_langsung'] ?? '0' . "\n";
        }
        $objPHPExcel->setCellValue("E$baris", $input);
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "    Total :");
        $objPHPExcel->mergeCells("C$baris:D$baris");
        $input = '';        
        foreach ($data['jabatans'] as $key) {
            $input .= "-  ".  $key['total_bawahan'] ?? '0' . "\n";
        }
        $objPHPExcel->setCellValue("E$baris", $input);
        $baris++;
        $objPHPExcel->setCellValue("C$baris", "b. Proses bisnis yang dikelola di sub bidangnya");
        // Hubungan Kerja Internal
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("A$baris", " 6.");
        $objPHPExcel->setCellValue("B$baris", "HUBUNGAN KERJA");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Menggambarkan hubungan kedinasan antara pemegang jabatan dengan jabatan lain dalam perusahaan maupun di perusahaan lain, yang disertai dengan deskripsi tujuan dari hubungan kerja tersebut.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Komunikasi Internal");
        $objPHPExcel->setCellValue("D$baris", "Tujuan");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:H$baris");
        $baris++;
        $no = 1;
            $rowsCount = count($data['hubunganKerja']->WHERE($param, 'internal')); 
            $input = $objPHPExcel->getStyle("B27:G27");
            foreach ($data['hubunganKerja']->WHERE($param, 'internal') as $key) {
                $objPHPExcel->setCellValue("B$baris", $no);
                $objPHPExcel->setCellValue("C$baris", isset($key['subjek']) ? $key['subjek'] : $key['komunikasi']);
                $objPHPExcel->setCellValue("D$baris", $key->tujuan);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:H$baris");
                $no++;
                $baris++;
            }
            for ($i = $rowsCount + 1; $i <= 12; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:H$baris");
                $baris++;
            }
        $baris++;
        // Hubungan Kerja Eksternal
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Komunikasi Eksternal");
        $objPHPExcel->setCellValue("D$baris", "Tujuan");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:H$baris");
        $baris++;
            $no = 1;
            $rowsCount = count($data['hubunganKerja']->WHERE($param, $ex));
            $input = $objPHPExcel->getStyle("B27:G27");
            foreach ($data['hubunganKerja']->WHERE($param, $ex) as $key) {
                $objPHPExcel->setCellValue("B$baris", $no);
                $objPHPExcel->setCellValue("C$baris", isset($key['subjek']) ? $key['subjek'] : $key['komunikasi']);
                $objPHPExcel->setCellValue("D$baris", $key->tujuan);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:H$baris");
                $no++;
                $baris++;
            }
            for ($i = $rowsCount + 1; $i <= 8; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:H$baris");
                $baris++;
            }
        $baris++;
        // 
        /* MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA */
        $objPHPExcel->setCellValue("A$baris", " 7.");
        $objPHPExcel->setCellValue("B$baris", "MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Merupakan uraian atas hal-hal yang menjadi permasalahan bagi pemangku jabatan sebagai akibat dari adanya kesulitan dalam pencapaian tujuan atau target yang ditetapkan.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("C$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data['masalah_kompleksitas_kerja']); 
        $input = $objPHPExcel->getStyle("B27:G27");
        foreach ($data['masalah_kompleksitas_kerja'] as $key) {
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", isset($key['tantangan'])  ? $key['tantangan'] : $key['definisi'] );
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $no++;
            $baris++;
        }
        for ($i = $rowsCount + 1; $i <= 5; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $baris++;
        }
        // WEWENANG JABATAN
        $baris++;
        $objPHPExcel->setCellValue("A$baris", " 8.");
        $objPHPExcel->setCellValue("B$baris", "WEWENANG JABATAN");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Menjelaskan sejauh mana peran jabatan ini dalam pengambilan keputusan dan dampak apa yang dapat ditimbulkan dari keputusan yang diambilnya.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "WEWENANG JABATAN");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("C$baris:H$baris");
        $baris++;
            $no = 1;
            $rowsCount = count($data['wewenang_jabatan']); 
            $input = $objPHPExcel->getStyle("B27:G27");
            foreach ($data['wewenang_jabatan'] as $key) {
                $objPHPExcel->setCellValue("B$baris", $no);
                $objPHPExcel->setCellValue("C$baris", isset($key['pengambilan_keputusan']) ? $key['pengambilan_keputusan'] : $key['definisi']);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("C$baris:H$baris");
                $no++;
                $baris++;
            }
            for ($i = $rowsCount + 1; $i <= 5; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("C$baris:H$baris");
                $baris++;
            }
        $baris++;
        // SPESIFIKASI JABATAN
        $objPHPExcel->setCellValue("A$baris", " 9.");
        $objPHPExcel->setCellValue("B$baris", "SPESIFIKASI JABATAN");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:D$baris");
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Menguraikan dan menjelaskan pendidikan, pengetahuan pokok, keterampilan dan pengalaman minimal serta kompetensi yang diperlukan untuk mencapai tujuan jabatan, yang terdiri atas kualifikasi jabatan, kemampuan dan pengalaman, dan kompetensi.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Pendidikan");
        $objPHPExcel->setCellValue("D$baris", "Exp.");
        $objPHPExcel->setCellValue("F$baris", "Bidang Studi");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("F$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data['spesifikasiPendidikan']); 
        $input = $objPHPExcel->getStyle("B27:G27");

        foreach ($data['spesifikasiPendidikan'] as $key) {
            // Mengambil bidang studi berdasarkan map_pendidikan_id
            $bidangQuery = (new \App\Models\M_MAP_PENDIDIKAN())->getBidang($key->map_pendidikan_id);
            $bidangStudiFormatted = '';

            if ($bidangQuery->count() == 1) {
                foreach ($bidangQuery as $b) {
                    $bidangStudiFormatted .= $b->bidang_studi;
                }
            } elseif ($bidangQuery->count() > 1) {
                $bidangStudiFormatted = '';
                foreach ($bidangQuery as $index => $b) {
                    $bidangStudiFormatted .= ($index + 1) . '. ' . trim($b->bidang_studi) . "\n";
                }
            }

            // Menentukan pengalaman kerja
            $pengalaman = ($key->pengalaman == '' || $key->pengalaman == 'FG' || $key->pengalaman == 0)
                ? 'Fresh Graduate'
                : "Pengalaman minimal $key->pengalaman tahun";

            // Menulis ke dalam file Excel
            $objPHPExcel->setCellValue("B$baris", $no);
            $objPHPExcel->setCellValue("C$baris", $key->pendidikan);
            $objPHPExcel->setCellValue("D$baris", $pengalaman);
            $objPHPExcel->setCellValue("F$baris", isset($key->id) ? $key->bidang_studi : $bidangStudiFormatted);
            
            // Styling dan merging
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("F$baris:H$baris");

            $baris++;
            $no++;
        }

        // Jika data kurang dari 4, tambahkan baris kosong
        for ($i = $rowsCount + 1; $i <= 4; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->setCellValue("D$baris", "");
            $objPHPExcel->setCellValue("F$baris", "");
            
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("F$baris:H$baris");

            $baris++;
        }

        $baris++;
        $objPHPExcel->setCellValue("B$baris", "Kemampuan dan Pengalaman");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $rowsCount = count($data['kemampuan_dan_pengalaman']); 
        $huruf = 'a'; // Mulai dari huruf "a"
        foreach ($data['kemampuan_dan_pengalaman'] as $v) {
            $objPHPExcel->setCellValue("B$baris", "$huruf.");
            $objPHPExcel->setCellValue("C$baris", $v->definisi);
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $baris++; // Pindah ke baris berikutnya
            $huruf++; // Inkrementasi huruf (dari "a" menjadi "b", dan seterusnya)
        }for ($i = $rowsCount + 1; $i <= 5; $i++) {
            $objPHPExcel->setCellValue("B$baris", "$huruf.");
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->mergeCells("C$baris:H$baris");
            $baris++;
            $huruf++;
        }
        $baris++;
        $objPHPExcel->setCellValue("A$baris", "10.");
        $objPHPExcel->setCellValue("B$baris", "STRUKTUR ORGANISASI");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi jabatan atasan langsung, bawahan langsung serta rekan kerja (peers).";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $baris++;
        $objPHPExcel->setCellValue("A$baris", "11.");
        $objPHPExcel->setCellValue("B$baris", "KEBUTUHAN KOMPETENSI JABATAN (KKJ)");
        $objPHPExcel->getStyle("A$baris:B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Memberikan informasi mengenai kebutuhan kemahiran/kompetensi yang diharapkan dalam suatu jabatan.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        /* PERSYARATAN KOMPETENSI  */
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Utama");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi perilaku yang harus dimiliki oleh seluruh individu Pegawai dalam organisasi, pada semua fungsi dan Jenjang Jabatan.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("F$baris", "Penjelasan");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("F$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data['keterampilan_non_teknis']->WHERE('kategori', 'UTAMA')); 
        $input = $objPHPExcel->getStyle("B27:G27");
        foreach ($data['keterampilan_non_teknis']->WHERE('kategori', 'UTAMA') as $key) {
            $objPHPExcel->setCellValue("B$baris", " $no.");
            $objPHPExcel->setCellValue("C$baris", $key->kode);
            $objPHPExcel->setCellValue("D$baris", $key->detail->nama);
            $objPHPExcel->setCellValue("F$baris", $key['detail']['definisi'] ?? '');
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("F$baris:H$baris");
            $baris++;
            $no++;
        }
        for ($i = $rowsCount + 1; $i <= 5; $i++) {
            $objPHPExcel->setCellValue("B$baris", "$i.");
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->setCellValue("F$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("F$baris:H$baris");
                $baris++;
        }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Peran");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi perilaku yang dipersyaratkan agar individu Pegawai dapat berhasil dalam suatu posisi, peran, dan Jenjang Jabatan yang spesifik.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("F$baris", "Kategori");
        $objPHPExcel->setCellValue("G$baris", "Penjelasan");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("G$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data['keterampilan_non_teknis']->WHERE('kategori', 'PERAN')); 
        $input = $objPHPExcel->getStyle("B27:G27");
        foreach ($data['keterampilan_non_teknis']->WHERE('kategori', 'PERAN') as $key) {
                $objPHPExcel->setCellValue("B$baris", " $no.");
                $objPHPExcel->setCellValue("C$baris", $key['kode']);
                $objPHPExcel->setCellValue("D$baris", $key['detail']['nama']);
                $objPHPExcel->setCellValue("F$baris", $key['jenis']);
                $objPHPExcel->setCellValue("G$baris", $key['detail']['definisi']);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("G$baris:H$baris");
                $baris++;
                $no++;
            }
         for ($i = $rowsCount + 1; $i <= 4; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->setCellValue("D$baris", "");
            $objPHPExcel->setCellValue("F$baris", "");
            $objPHPExcel->setCellValue("G$baris", "");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $objPHPExcel->mergeCells("G$baris:H$baris");
            $baris++;
        }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Fungsi");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi perilaku yang harus dimiliki untuk setiap fungsi bisnis di dalam organisasi.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("F$baris", "Kategori");
        $objPHPExcel->setCellValue("G$baris", "Penjelasan");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $objPHPExcel->mergeCells("G$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data["keterampilan_non_teknis"]->WHERE('kategori', 'FUNGSI')); 
        $input = $objPHPExcel->getStyle("B27:G27");
        foreach ($data["keterampilan_non_teknis"]->WHERE('kategori', 'FUNGSI') as $key) {
                $objPHPExcel->setCellValue("B$baris", " $no.");
                $objPHPExcel->setCellValue("C$baris", $key->kode);
                $objPHPExcel->setCellValue("D$baris", $key['detail']['nama']);
                $objPHPExcel->setCellValue("F$baris", strtoupper($key['jenis']));
                $objPHPExcel->setCellValue("G$baris", $key['detail']['definisi']);
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("G$baris:H$baris");
                $baris++;
                $no++;
            } 
            for ($i = $rowsCount + 1; $i <= 8; $i++) {
                $objPHPExcel->setCellValue("B$baris", $i);
                $objPHPExcel->setCellValue("C$baris", "");
                $objPHPExcel->setCellValue("D$baris", "");
                $objPHPExcel->setCellValue("F$baris", "");
                $objPHPExcel->setCellValue("G$baris", "");
                $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
                $objPHPExcel->mergeCells("D$baris:E$baris");
                $objPHPExcel->mergeCells("G$baris:H$baris");
                $baris++;
            }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", ">> Kompetensi Teknis");
        $objPHPExcel->getStyle("B$baris")->getFont()->setBold(true);
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $baris++;
        $objPHPExcel->mergeCells("B$baris:H$baris");
        $text = "Kompetensi terkait dengan pengetahuan, keterampilan dan keahlian yang diperlukan sesuai dengan tugas pokok masing-masing individu Pegawai untuk menyelesaikan pekerjaan-pekerjaan secara teknis pada jabatannya.";
        $objPHPExcel
            ->mergeCells("B$baris:H$baris")
            ->setCellValue("B$baris", $text);
        $objPHPExcel->getStyle("B$baris")->getFont()->setItalic(true);
        $objPHPExcel->getStyle("B$baris")->getAlignment()->setWrapText(true);
        $rowHeight = ceil(strlen($text) / 86) * 16;
        $objPHPExcel->getRowDimension($baris)->setRowHeight($rowHeight);
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "No");
        $objPHPExcel->setCellValue("C$baris", "Kode Kompetensi");
        $objPHPExcel->setCellValue("D$baris", "Kompetensi");
        $objPHPExcel->setCellValue("G$baris", "Kategori");
        $objPHPExcel->setCellValue("F$baris", "Level Profisiensi");
        $objPHPExcel->setCellValue("H$baris", "Penjelasan");
        $objPHPExcel->mergeCells("D$baris:E$baris");
        $input = $objPHPExcel->getStyle("B26:G26");
        $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
        $baris++;
        $no = 1;
        $rowsCount = count($data['keterampilan_teknis']); 
        foreach ($data['keterampilan_teknis'] as $key) {
            $objPHPExcel->setCellValue("B$baris", " $no.");
            $objPHPExcel->setCellValue("C$baris", $key->kode);
            $objPHPExcel->setCellValue("D$baris", $key['master']['nama']);
            $objPHPExcel->setCellValue("F$baris", $key['level']);
            $objPHPExcel->setCellValue("G$baris", $key['kategori']);
            $objPHPExcel->setCellValue("H$baris", $key->detailMasterKompetensiTeknis->perilaku);
            $input = $objPHPExcel->getStyle("B27:G27");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $baris++;
            $no++;
        }
        for ($i = $rowsCount + 1; $i <= 14; $i++) {
            $objPHPExcel->setCellValue("B$baris", $i);
            $objPHPExcel->setCellValue("C$baris", "");
            $objPHPExcel->setCellValue("D$baris", "");
            $objPHPExcel->setCellValue("F$baris", "");
            $objPHPExcel->setCellValue("G$baris", "");
            $objPHPExcel->setCellValue("H$baris", "");
            $input = $objPHPExcel->getStyle("B27:G27");
            $objPHPExcel->duplicateStyle($input, "B$baris:H$baris");
            $objPHPExcel->mergeCells("D$baris:E$baris");
            $baris++;
        }
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "Keterangan :");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi primer adalah Kompetensi yang wajib dimiliki oleh individu yang menduduki suatu Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi sekunder adalah Kompetensi yang perlu dimiliki untuk mendukung individu yang menduduki suatu Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi core adalah Kompetensi teknis yang wajib dimiliki berdasarkan tugas pokok sesuai fungsi utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis");
        $baris++;
        $objPHPExcel->setCellValue("B$baris", "- Kompetensi enabler adalah Kompetensi teknis yang perlu dimiliki untuk mendukung tugas pokok sesuai fungsi utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis.");
        $baris++;
        $objPHPExcel->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getStyle('E')->getAlignment()->setWrapText(true);
        $objPHPExcel->getDefaultRowDimension()->setRowHeight(-1);
        $exportPath = storage_path('/exports/Template_Jabatan' . $data['nama'] . date('d-m-Y H-i-s') .'.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($exportPath);
        return response()->download($exportPath)->deleteFileAfterSend(true);
    }


}
