<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class DummyExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        return new Collection([
            ['Iqbal Dewangga', 'Developer', '2024-10-31'],
            ['Andi Santoso', 'Manager', '2024-10-30'],
            ['Rina Melati', 'Designer', '2024-10-29']
        ]);
    }

    public function headings(): array
    {
        return [
            [''], [''],  // Kosong untuk header
            ['Nama', 'Jabatan', 'Tanggal']  // Header kolom data utama
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Atur ukuran kolom untuk menyesuaikan layout A4
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(30);

                // Atur tinggi baris agar lebih proporsional
                $sheet->getRowDimension(1)->setRowHeight(80);

                // Logo Kiri
                $drawingLeft = new Drawing();
                $drawingLeft->setName('Logo Left');
                $drawingLeft->setPath(public_path('img/dirjab_logo2.png'));
                $drawingLeft->setHeight(60);
                $drawingLeft->setCoordinates('A1');
                $drawingLeft->setOffsetX(10);  // Posisi lebih ke dalam dari tepi
                $drawingLeft->setWorksheet($sheet);

                // Logo Kanan
                $drawingRight = new Drawing();
                $drawingRight->setName('Logo Right');
                $drawingRight->setPath(public_path('img/logoPLN.png'));
                $drawingRight->setHeight(60);
                $drawingRight->setCoordinates('C1');
                $drawingRight->setOffsetX(-10);  // Posisi lebih ke dalam dari tepi
                $drawingRight->setWorksheet($sheet);

                // Menggabungkan sel untuk bagian judul dan informasi
                $sheet->mergeCells('A2:C2');
                $sheet->setCellValue('A2', 'Uraian Jabatan - Head Office');

                // Informasi header tambahan
                $sheet->setCellValue('A3', 'Tanggal:');
                $sheet->setCellValue('B3', '2024-10-31');
                $sheet->setCellValue('A4', 'No Record:');
                $sheet->setCellValue('B4', '12345');
                $sheet->setCellValue('A5', 'Revisi:');
                $sheet->setCellValue('B5', '1');
                $sheet->setCellValue('A6', 'Status:');
                $sheet->setCellValue('B6', 'Approved');

                // Style header agar sejajar di tengah
                $sheet->getStyle('A2:C2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style untuk informasi lainnya
                $sheet->getStyle('A3:A6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                // Border untuk membatasi area informasi header
                $sheet->getStyle('A2:C6')->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
            }
        ];
    }
}
