<?php

namespace App\Http\Controllers;

use App\Models\BidangStudi;
use App\Models\DetailKomptensiTeknis;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanNonteknis;
use App\Models\KeterampilanTeknis;
use App\Models\Konsentrasi;
use App\Models\M_PROFESI;
use App\Models\MappingNatureOfImpact;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MasterIndikatorOutput;
use App\Models\MasterJabatan;
use App\Models\MasterJenjangJabatan;
use App\Models\MasterKompetensiNonteknis;
use App\Models\MasterKompetensiTeknis;
use App\Models\MasterPendidikan;
use App\Models\MasterSingkatanJabatan;
use App\Models\PokoUtamaGenerik;
use App\Models\unit\M_UNIT;
use App\Models\WewenangJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MasterDataController extends Controller
{

    public function bidangStudi()
    {
        $data = BidangStudi::with('konsentrasi')->get();
        return view('pages.masterData.bidangStudi.index', ['data' => $data]);
    }

    public function bidangStudiStore(Request $request)
    {
        $request->validate([
            'bidang_studi' => 'required|string|max:255|unique:bidang_studi',
            'konsentrasi' => 'nullable|string'
        ]);
    
        try {
            $bidang = BidangStudi::create([
                'bidang_studi' => $request->bidang_studi
            ]);
    
            if ($request->konsentrasi) {
                $konsentrasiList = explode(',', $request->konsentrasi);
                foreach ($konsentrasiList as $konsentrasi) {
                    Konsentrasi::create([
                        'bidang_studi_id' => $bidang->bidang_studi_id,
                        'konsentrasi' => trim($konsentrasi)
                    ]);
                }
            }
    
            return redirect()->route('master.bidangStudi')->with('success',  'Bidang Studi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('master.bidangStudi')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function bidangStudiUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bidang_studi,id', // Memastikan ID valid
            'bidang_studi' => 'required|string|max:255|unique:bidang_studi,bidang_studi,' . $request->id,
            'konsentrasi' => 'nullable|string'
        ]);
    
        try {
            $bidang = BidangStudi::findOrFail($request->id); // Perbaikan dari where()
            $bidang->update([
                'bidang_studi' => $request->bidang_studi
            ]);
    
            // Update konsentrasi
            Konsentrasi::where('bidang_studi_id', $bidang->id)->delete(); // Perbaikan dari bidang_studi_id ke id
            if ($request->konsentrasi) {
                $konsentrasiList = explode(',', $request->konsentrasi);
                foreach ($konsentrasiList as $konsentrasi) {
                    Konsentrasi::create([
                        'bidang_studi_id' => $bidang->id, // Perbaikan dari bidang_studi_id ke id
                        'konsentrasi' => trim($konsentrasi)
                    ]);
                }
            }
    
            return redirect()->route('master.bidangStudi')->with('success',  'Bidang Studi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('master.bidangStudi')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    

    public function bidangStudiDelete(Request $request)
    {
        try {
            $bidang_studi_id = $request->id;
            $bidang = BidangStudi::where('bidang_studi_id', $bidang_studi_id)->first();
            $bidang->delete();
    
            return redirect()->route('master.bidangStudi')->with('success',  'Bidang Studi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('master.bidangStudi')->with('error',  'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // public function natureOfImpact()
    // {
    //     $data = MappingNatureOfImpact::with('namaProfesi')->get();
    //     $option = M_PROFESI::get();
    //     return view('pages.masterData.dimensiFinansial.index', ['data' => $data, 'option' => $option]);
    // }

    public function natureOfImpact()
    {
        $option = M_PROFESI::get();
        return view('pages.masterData.dimensiFinansial.index', ['option' => $option]);
    }

    public function getNatureOfImpact(Request $request)
    {
        if ($request->ajax()) {
            $data = MappingNatureOfImpact::with('namaProfesi')->select('id', 'kode_profesi', 'jenis');

            return DataTables::of($data)
                ->addColumn('nama_profesi', function ($row) {
                    return $row->namaProfesi->nama_profesi ?? $row->kode_profesi;
                })
                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-primary btn-xs btnEdit" 
                        data-id="' . $row->id . '" 
                        data-kode_profesi="' . $row->kode_profesi . '" 
                        data-jenis="' . $row->jenis . '">
                        <i class="ti-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-xs btnDelete" data-id="' . $row->id . '">
                        <i class="ti-trash"></i>
                    </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function storeNatureOfImpact(Request $request)
    {
        $request->validate([
            'kode_profesi' => 'required|string',
            'jenis' => 'required|string',
        ]);

        MappingNatureOfImpact::create([
            'kode_profesi' => $request->kode_profesi,
            'jenis' => $request->jenis,
            'created_by' => Auth::user()->name
        ]);

        return redirect()->route('master.natureOfImpact')->with('success', 'Data berhasil ditambahkan');
    }

    public function updateNatureOfImpact(Request $request)
    {
        $request->validate([
            'kode_profesi' => 'required|string',
            'jenis' => 'required|string',
        ]);

        $indikator = MappingNatureOfImpact::findOrFail($request->id);
        $indikator->update([
            'kode_profesi' => $request->kode_profesi,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('master.natureOfImpact')->with('success', 'Data berhasil diperbarui');
    }

    public function deleteNatureOfImpact(Request $request)
    {
        $indikator = MappingNatureOfImpact::findOrFail($request->id);
        $indikator->delete();
        return redirect()->route('master.natureOfImpact')->with('success', 'Data berhasil dihapus');
    }

    public function indikator()
    {
        $data = MasterIndikatorOutput::get();
        return view('pages.masterData.indikator.index', ['data' => $data]);
    }

    public function storeIndikator(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        MasterIndikatorOutput::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('master.indikator')->with('success', 'Data berhasil ditambahkan');
    }

    public function updateIndikator(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $indikator = MasterIndikatorOutput::findOrFail($request->id);
        $indikator->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('master.indikator')->with('success', 'Data berhasil diperbarui');
    }

    public function deleteIndikator(Request $request)
    {
        $indikator = MasterIndikatorOutput::findOrFail($request->id);
        $indikator->delete();
        return redirect()->route('master.indikator')->with('success', 'Data berhasil dihapus');
    }

    public function jenjangJabatan()
    {
        $data = MasterJenjangJabatan::get();
        return view('pages.masterData.jenjang.index', ['data' => $data]);
    }

    public function updateStatusJenjang(Request $request)
    {
        try {
            $jenjang = MasterJenjangJabatan::findOrFail($request->id);
            $jenjang->status = $request->status;
            $jenjang->save();

            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }

    public function unit()
    {
        $data = M_UNIT::get();
        return view('pages.masterData.unit.index', ['data' => $data]);
    }

    public function updateStatusUnit(Request $request)
    {
        try {
            $unit = M_UNIT::where('unit_id', $request->id)->firstOrFail();
            $unit->update(['status' => $request->status]);

            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }

    public function tugasPokokGenerik()
    {
        $data = PokoUtamaGenerik::get();
        return view('pages.masterData.tugasPokokGenerik.index', ['data' => $data]);
    }

    public function TugasPokokGenerikStore(Request $request)
    {
        $request->validate([
            'aktivitas' => 'required|string',
            'output' => 'required|string',
            'jenis_jabatan' => 'required|string',
        ]);

        PokoUtamaGenerik::create([
            'aktivitas' => $request->aktivitas,
            'output' => $request->output,
            'jenis_jabatan' => $request->jenis_jabatan,
            'created_by' => Auth::user()->name,
        ]);
        return redirect()->route('master.tugas_pokok_generik.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function TugasPokokGenerikUpdate(Request $request)
    {
        $request->validate([
            'aktivitas' => 'required|string',
            'output' => 'required|string',
            'jenis_jabatan' => 'required|string',
        ]);

        $data = PokoUtamaGenerik::findOrFail($request->id);
        $data->update([
            'aktivitas' => $request->aktivitas,
            'output' => $request->output,
            'jenis_jabatan' => $request->jenis_jabatan,
            'created_by' => Auth::user()->name,
        ]);
        return redirect()->route('master.tugas_pokok_generik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function TugasPokokGenerikDestroy(Request $request)
    {
        $data = PokoUtamaGenerik::findOrFail($request->id);;
        $data->delete();
        return redirect()->route('master.tugas_pokok_generik.index')->with('success', 'Data berhasil dihapus.');
    }

    public function defaultMasterData()
    {
        $masalahKompleksitasKerja = MasalahKompleksitasKerja::whereNotNull('jenis_jabatan')->get();
        $wewenangJabatan = WewenangJabatan::whereNotNull('jenis_jabatan')->get();
        $kemampuandanPengalaman = KemampuandanPengalaman::whereNotNull('jenis_jabatan')->get();
        return view('pages.masterData.defaultMasterData.index', [
            'masalahKompleksitasKerja' => $masalahKompleksitasKerja,
            'wewenangJabatan' => $wewenangJabatan,
            'kemampuandanPengalaman' => $kemampuandanPengalaman,
        ]);
    }

    public function masterKompetensiTeknis(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterKompetensiTeknis::get();
            return DataTables::of($data)
                ->addColumn('kode', function ($row) {
                    return '<a href="' . route('master.kompetensi-detail-teknis', $row->id) . '">' . $row->kode . '</a>';
                })
                ->addColumn('nama', function ($row) {
                    return '<a href="' . route('master.kompetensi-detail-teknis', $row->id) . '">' . $row->nama . '</a>';
                })
                ->rawColumns(['kode', 'nama']) // Untuk mendukung HTML di kolom
                ->make(true);
        }
        return view('pages.masterData.kompetensiTeknis.index');
    }
    public function detailMasterKompetensiTeknis($id)
    {
        $data = MasterKompetensiTeknis::with('level')->find($id);
        return view('pages.masterData.kompetensiTeknis.show', ['data' => $data]);
    }
    public function MasterKompetensiNonteknis(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterKompetensiNonteknis::select(['kode', 'nama', 'singkatan', 'jenis', 'definisi']);
            return DataTables::of($data)->make(true);
        }
        return view('pages.masterData.kompetensiNonTeknis.index');
    }

    public function storeKompetensi(Request $request)
    {
        $request->validate([
            'kode_master' => 'required|string',
            'level' => 'required',
            'perilaku' => 'required|string',
        ]);

        DetailKomptensiTeknis::create([
            'kode_master' => $request->kode_master,
            'level' => $request->level,
            'perilaku' => $request->perilaku,
            'kode_master_level' => $request->kode_master . '.' . $request->level,
            'created_by' => Auth::user()->name
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function updateKompetensi(Request $request)
    {

        $kompetensi = DetailKomptensiTeknis::where('kode_master_level', $request->kode_master_level)->firstOrFail();

        $kompetensi->update([
            'level' => $request->level,
            'perilaku' => $request->perilaku,
            'kode_master_level' => $request->kode_master_level
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function deleteKompetensi($id)
    {
        $kompetensi = DetailKomptensiTeknis::findOrFail($id);
        $kompetensi->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }


    public function mappingkomptensiNonTeknis(Request $request)
    {
        if ($request->ajax()) {
            $data = KeterampilanNonteknis::with('detail')->select('keterampilan_nonteknis.*');
            return DataTables::of($data)
                ->addColumn('nama_kompetensi', function ($row) {
                    return $row->detail->nama ?? '-';
                })
                ->make(true);
        }

        return view('pages.masterData.kompetensiNonTeknis.mapping');
    }
    public function mappingkomptensiTeknis(Request $request)
    {
        if ($request->ajax()) {
            $data = KeterampilanTeknis::with('master')->select('keterampilan_teknis.*');
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan ini untuk menambahkan nomor indeks ke data
                ->editColumn('master_jabatan', function ($row) {
                    return $row['master_jabatan'] ?: ($row['uraianJabatan']['nama'] ?? '-');
                })
                ->editColumn('master.nama', function ($row) {
                    return strtoupper($row->master->nama ?? '-');
                })
                ->make(true);
        }

        return view('pages.masterData.kompetensiTeknis.mapping');
    }

    public function masterJabatan(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterJabatan::select('id', 'master_jabatan', 'singkatan_jabatan_clean', 'aktif');

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return $row->aktif
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-danger">Tidak Aktif</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '<a href="' . route('master.jabatan.form', $row->id) . '" class="btn btn-primary btn-xs">
                                <i class="ti-pencil fa-lg"></i>
                            </a>
                            <form action="' . route('master.jabatan.delete', $row->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\');">
                                ' . csrf_field() . '
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-xs">
                                    <i class="ti-trash fa-lg"></i>
                                </button>
                            </form>';
                })
                ->rawColumns(['status', 'aksi'])
                ->make(true);
        }

        return view('pages.masterData.masterJabatanUnit.index');
    }


    public function formMasterJabatan($id = null)
    {
        $jabatan = null;
        if ($id) {
            $jabatan = MasterJabatan::with('singkatan')->findOrFail($id);
        }
        return view('pages.masterData.masterJabatanUnit.form', compact('jabatan'));
    }

    public function storeMasterJabatan(Request $request)
    {
        try {
            $request->validate([
                'master_jabatan' => 'required|unique:MST_JABATAN_TB,master_jabatan',
                'singkatan_jabatan_clean' => 'required|unique:MST_JABATAN_TB,singkatan_jabatan_clean',
                'aktif' => 'required|boolean',
                'singkatan_jabatan' => 'array',
                'singkatan_jabatan.*' => 'nullable|string|max:255',
            ]);

            $jabatan = MasterJabatan::create([
                'master_jabatan' => $request->master_jabatan,
                'singkatan_jabatan_clean' => $request->singkatan_jabatan_clean,
                'aktif' => $request->aktif
            ]);

            foreach ($request->singkatan_jabatan as $singkatan) {
                if (!empty($singkatan)) {
                    MasterSingkatanJabatan::create([
                        'master_jabatan' => $request->master_jabatan,
                        'singkatan_jabatan' => $singkatan,
                        'aktif' => 1
                    ]);
                }
            }
            return redirect()->route('master.jabatan')->with('success', 'Master Jabatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateMasterJabatan(Request $request)
    {
        try {
            $id = $request->id;
            $jabatan = MasterJabatan::findOrFail($id);

            $request->validate([
                'master_jabatan' => "required|unique:MST_JABATAN_TB,master_jabatan,{$id},id",
                'singkatan_jabatan_clean' => "required|unique:MST_JABATAN_TB,singkatan_jabatan_clean,{$id},id",
                'aktif' => 'required|boolean',
                'singkatan_jabatan' => 'array',
                'singkatan_jabatan.*' => 'nullable|string|max:255',
            ]);

            $jabatan->update([
                'master_jabatan' => $request->master_jabatan,
                'singkatan_jabatan_clean' => $request->singkatan_jabatan_clean,
                'aktif' => $request->aktif
            ]);

            // Hapus singkatan jabatan lama berdasarkan ID master_jabatan
            MasterSingkatanJabatan::where('master_jabatan', $jabatan->master_jabatan)->delete();

            // Tambahkan singkatan jabatan yang baru
            foreach ($request->singkatan_jabatan as $singkatan) {
                if (!empty($singkatan)) {
                    MasterSingkatanJabatan::insert([
                        'master_jabatan' => $jabatan->master_jabatan,
                        'singkatan_jabatan' => $singkatan,
                        'aktif' => 1
                    ]);
                }
            }

            return redirect()->route('master.jabatan')->with('success', 'Master Jabatan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function destroyMasterJabatan($id)
    {
        try {
            $jabatan = MasterJabatan::findOrFail($id);
            $jabatan->delete();

            return redirect()->route('master.jabatan')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function stoJobcode(Request $request)
    {
        if ($request->ajax()) {
            $data =  $data =  DB::select('SELECT * FROM INTTALENT.sto_jobcode');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.masterData.stoJobcode.index');

    }

    public function pendidikan()
    {
        $data = MasterPendidikan::get();
        $jenjang = MasterJenjangJabatan::select(['kode', 'nama'])->where('status', '1')->get();
        return view('pages.masterData.pendidikan.index', [
            'data' => $data,
            'jenjang' => $jenjang,
        ]);
    }

    public function createPendidikan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'pengalaman' => 'required|string',
            'jenjang_jabatan' => 'required|string',
        ]);

        MasterPendidikan::create([
            'nama' => $request->nama,
            'pengalaman' => $request->pengalaman,
            'jenjang_jabatan' => $request->jenjang_jabatan,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->route('master.pendidikan')->with('success', 'Data pendidikan berhasil ditambahkan.');
    }

    public function updatePendidikan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'pengalaman' => 'required|string',
            'jenjang_jabatan' => 'required|string',
        ]);

        $pendidikan = MasterPendidikan::findOrFail($request->id);
        $pendidikan->update([
            'nama' => $request->nama,
            'pengalaman' => $request->pengalaman,
            'jenjang_jabatan' => $request->jenjang_jabatan,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->route('master.pendidikan')->with('success', 'Data pendidikan berhasil diupadate.');
    }

    public function deletePendidikan(Request $request)
    {
        $pendidikan = MasterPendidikan::findOrFail($request->id);
        $pendidikan->delete();

        return redirect()->route('master.pendidikan')->with('success', 'Data pendidikan berhasil dihapus.');
    }
}
