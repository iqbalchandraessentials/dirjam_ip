<?php

namespace App\Http\Controllers;

use App\Models\BidangStudi;
use App\Models\DetailKomptensiTeknis;
use App\Models\jenjang\M_JENJANG;
use App\Models\KemampuandanPengalaman;
use App\Models\KeterampilanNonteknis;
use App\Models\KeterampilanTeknis;
use App\Models\Konsentrasi;
use App\Models\M_PROFESI;
use App\Models\MappingNatureOfImpact;
use App\Models\MasalahKompleksitasKerja;
use App\Models\MASTER_JABATAN_UNIT;
use App\Models\MasterBidangStudi;
use App\Models\MasterIndikatorOutput;
use App\Models\MasterJenjangJabatan;
use App\Models\MasterKompetensiNonteknis;
use App\Models\MasterKompetensiTeknis;
use App\Models\MasterPendidikan;
use App\Models\PokoUtamaGenerik;
use App\Models\unit\M_UNIT;
use App\Models\ViewUraianJabatan;
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

    public function store(Request $request)
    {
        $request->validate([
            'bidang_studi' => 'required|string|max:255',
            'konsentrasi' => 'nullable|array',
            'konsentrasi.*' => 'string|max:255',
        ]);

        $bidang = BidangStudi::create(['bidang_studi' => $request->bidang_studi]);

        if ($request->konsentrasi) {
            foreach ($request->konsentrasi as $kons) {
                Konsentrasi::create([
                    'bidang_studi_id' => $bidang->id,
                    'konsentrasi' => $kons,
                ]);
            }
        }

        return response()->json(['success' => 'Data berhasil ditambahkan']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bidang_studi,id',
            'bidang_studi' => 'required|string|max:255',
            'konsentrasi' => 'nullable|array',
            'konsentrasi.*' => 'string|max:255',
        ]);

        $bidang = BidangStudi::findOrFail($request->id);
        $bidang->update(['bidang_studi' => $request->bidang_studi]);

        // Hapus konsentrasi lama & tambahkan yang baru
        Konsentrasi::where('bidang_studi_id', $bidang->id)->delete();
        if ($request->konsentrasi) {
            foreach ($request->konsentrasi as $kons) {
                Konsentrasi::create([
                    'bidang_studi_id' => $bidang->id,
                    'konsentrasi' => $kons,
                ]);
            }
        }

        return response()->json(['success' => 'Data berhasil diperbarui']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bidang_studi,id',
        ]);

        BidangStudi::where('id', $request->id)->delete();
        Konsentrasi::where('bidang_studi_id', $request->id)->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function natureOfImpact()
    {
        $data = MappingNatureOfImpact::with('namaProfesi')->get();
        $option = M_PROFESI::get();
        return view('pages.masterData.dimensiFinansial.index', ['data' => $data, 'option' => $option]);
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

    public function updateStatus(Request $request)
    {
        try {
            $jenjang = MasterJenjangJabatan::findOrFail($request->id);
            $jenjang->status = $request->status;
            $jenjang->save();
            // $jenjang->update(['status' => $request->status]);


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

    public function tugasPokokGenerik()
    {
        $data = PokoUtamaGenerik::where('jenis', 'generik')->get();
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
            'jenis' => $request->jenis,
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
            'jenis' => $request->jenis,
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
    public function masterKompetensiNonTeknis(Request $request)
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
            'kode_master_level' => 'required|string|unique:DetailKomptensiTeknis,kode_master_level',
            'kode_master' => 'required|string',
            'level' => 'required',
            'perilaku' => 'required|string',
        ]);
        DetailKomptensiTeknis::create([
            'kode_master' => $request->kode_master,
            'level' => $request->level,
            'perilaku' => $request->perilaku,
            'kode_master_level' => $request->kode_master . $request->level,
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
            $data = MASTER_JABATAN_UNIT::select('master_jabatan', 'siteid')->distinct();
            return DataTables::of($data)
                ->addIndexColumn() // Menambahkan kolom nomor urut
                ->make(true);
        }
        return view('pages.masterData.masterJabatanUnit.index');
    }

    public function stoJobcode(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::select('SELECT SINGKATAN_JABATAN,JENIS_PEMBANGKIT,SINGKATAN_JABATAN_CLEAN,KODE_JABATAN,PEOPLE_GROUP_ID,ORG_ID,LEVELING,STRUCTURE,PERSON_ID_PARENT,NAMA_PARENT,NIPEG_PARENT,EMAIL_PARENT,PATH,PARENT_PATH,STATUS,ID,VALID_FROM,VALID_TO,PARENT_NAME,PARENT_POSITION_ID,CHILD_POSITION_ID,CHILD_NAME,PERSON_ID_BAWAHAN,NAMA_BAWAHAN,NIPEG_BAWAHAN,EMAIL_BAWAHAN,MASTER_JABATAN,ORGANIZATION_ID,ORGANIZATION_DESC,MAX_PERSONS,FTE,JOB_ID,JENIS_JABATAN,JEN_P21B,JENJANG,SUBORDINATE_POSITION_ID,FLAG_DEFINITIF,DIREKTORAT,DIVISI,LOCATION_CODE,TOWN_OR_CITY,P22A,POG_MIN,POG_MAX,UNIT_KD,UNIT_KD_REV,UNIT_NAMA,RE FROM INTTALENT.sto_jobcode');

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
