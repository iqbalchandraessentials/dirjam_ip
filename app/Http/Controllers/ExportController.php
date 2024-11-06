<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DummyExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function exportExcel()
    {
        // Path template
    $templatePath = public_path('/template/Template_Dirjab.xlsx');

    // Load file template Excel
    $spreadsheet = IOFactory::load($templatePath);
    $worksheet = $spreadsheet->getActiveSheet();

    // Input data ke kolom D baris ke 9
    $worksheet->setCellValue('D9', 'Isi data Anda di sini'); // Ganti 'Isi data Anda di sini' dengan data dinamis jika diperlukan

    // Tentukan nama file yang akan diunduh
    $exportPath = storage_path('/exports/Template_Dirjab_Filled.xlsx');

    // Simpan file yang sudah diisi
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($exportPath);

    // Unduh file
    return response()->download($exportPath)->deleteFileAfterSend(true);
    }
}
