<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // Import PDF facade

class ReportController extends Controller
{
    public function exportPdf()
    {
        // Data yang akan ditampilkan di PDF
        $data = [
            ['name' => 'Iqbal Dewangga', 'position' => 'Developer', 'date' => '2024-10-31'],
            ['name' => 'Andi Santoso', 'position' => 'Manager', 'date' => '2024-10-30'],
            ['name' => 'Rina Melati', 'position' => 'Designer', 'date' => '2024-10-29'],
        ];

        // Membuat PDF dari view
        $pdf = PDF::loadView('pages.pdf_report', compact('data'));

        // Mengatur filename
        return $pdf->download('report.pdf');
    }
}