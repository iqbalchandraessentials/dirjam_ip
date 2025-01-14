<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DataImport;
use App\Imports\UraianMasterJabatanImport;
use App\Models\UraianMasterJabatan;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('import');
    }

    public function import(Request $request)
    { 
        try {
            Excel::import(new UraianMasterJabatanImport, $request->file('file'));
            session()->flash('success', 'Data uraian jabatan berhasil diupload, mohon periksa kembali.');
            return redirect()->route('uraian_jabatan_template.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }

}
