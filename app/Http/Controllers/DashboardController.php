<?php

namespace App\Http\Controllers;

use App\Models\M_PROGRES;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $chartdata = [];
        $progres = M_PROGRES::orderByDesc('PERSEN')->get();
        $jp = ["PGU", "POMU", "UPK", "UPDK", "OMU", "KP", "MSU"];
    
        $total_n_all = 0;
        $total_all = 0;
    
        foreach ($jp as $j) {
            $n = 0;
            $total = 0;
    
            foreach ($progres as $key) {
                if ($j === $key->jenis) {
                    $n += $key->n;
                    $total += $key->total;
                }
            }
    
            $persen = ($total > 0) ? round(($n / $total) * 100) : 0;
    
            // Simpan ke array chartdata
            $chartdata[] = [
                'element' => $j,
                'data' => [['label' => $j, 'value' => $persen]],
            ];
    
            // Akumulasi untuk Indonesia Power
            $total_n_all += $n;
            $total_all += $total;
        }
    
        // Hitung persentase untuk Indonesia Power
        $persen_indonesia_power = ($total_all > 0) ? round(($total_n_all / $total_all) * 100) : 0;
    
        // Tambahkan Indonesia Power ke chartdata
        $chartdata[] = [
            'element' => 'IndonesiaPower',
            'data' => [['label' => 'Indonesia Power', 'value' => $persen_indonesia_power]],
        ];
    
        return view('pages.dashboard', compact('chartdata'));
    }


    public function getClusterDetail($id)
    {

        $progres = M_PROGRES::where('jenis', $id)->orderByDesc('PERSEN')->get();

        $chartData = [];
    
        foreach ($progres as $v) {
            $chartData[] = [
                'element' => $v->siteid,
                'data' => [['label' => $v->description, 'value' => $v->persen]],
            ];
        }
    
        return view('pages.cluster.show', compact('chartData'));
    }
    
}
