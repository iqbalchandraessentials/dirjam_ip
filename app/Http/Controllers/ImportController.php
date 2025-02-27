<?php

namespace App\Http\Controllers;

use App\Imports\KeterampilanNonteknisImport;
use App\Imports\KeterampilanTeknisImport;
use Illuminate\Http\Request;
use App\Imports\KompetensiTeknisImport;
use App\Imports\MasterDefaultDataImport;
use App\Imports\MasterKompetensiNonTeknisImport;
use App\Imports\UraianMasterJabatanImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function masterKompetensiTeknis(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new KompetensiTeknisImport, $request->file('file'));
            session()->flash('success', 'Master Keterampilan Teknis berhasil diupload, mohon periksa kembali.');
            return redirect()->route('master.kompetensi-teknis');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        }
    }
    public function masterKompetensiNonTeknis(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new MasterKompetensiNonTeknisImport, $request->file('file'));
            session()->flash('success', 'Master Keterampilan Non Teknis berhasil diupload, mohon periksa kembali.');
            return redirect()->route('master.kompetensi-non-teknis');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors($errorMessages);
        }
    }
    
    public function mappingKompetensiNonTeknis(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new KeterampilanNonteknisImport, $request->file('file'));
            session()->flash('success', 'Mapping Keterampilan Non Teknis berhasil diupload, mohon periksa kembali.');
            return redirect()->route('master.mapping-komptensi-non-teknis');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        }
    }

    public function masterDefaultData(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new MasterDefaultDataImport, $request->file('file'));
            session()->flash('success', 'Master Default Data berhasil diupload, mohon periksa kembali.');
            return redirect()->route('master.defaultData');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);
            Excel::import(new UraianMasterJabatanImport, $request->file('file'));
            session()->flash('success', 'Data uraian jabatan berhasil diupload, mohon periksa kembali.');
            return redirect()->route('template_jabatan.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }

    public function mappingKeterampilanTeknis(Request $request)
    {
        try {
            // Validasi file yang diunggah
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);
    
            // Proses import data
            Excel::import(new KeterampilanTeknisImport, $request->file('file'));
    
            // Jika berhasil
            session()->flash('success', 'Mapping Keterampilan Teknis berhasil diupload, mohon periksa kembali.');
            return redirect()->route('master.mapping-komptensi-teknis');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Tangkap error validasi pada import
            $failures = $e->failures();
    
            // Kumpulkan pesan error dari setiap baris
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
    
            // Tampilkan pesan error dengan redirect
            return redirect()->back()->withErrors(['import' => $errorMessages]);
        } catch (\Exception $e) {
            // Tangkap error umum lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
}
