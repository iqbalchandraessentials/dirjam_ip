<?php

namespace App\Http\Controllers;

use App\Models\M_PROGRES;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
{
    $progres = M_PROGRES::orderByDesc('PERSEN')->get();
    $jp = ["Indonesia Power", "PGU", "POMU", "UPK", "UPDK", "OMU", "KP", "MSU"];
    
    $total_n_all = 0;
    $total_all = 0;
    $dataPersen = [];

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
        $sisa_persen = 100 - $persen;

        $dataPersen[] = [
            'jenis' => $j,
            'persen' => $persen,
            'sisa_persen' => $sisa_persen
        ];

        // Mengakumulasi total keseluruhan untuk Indonesia Power
        $total_n_all += $n;
        $total_all += $total;
    }

    $persen_indonesia_power = ($total_all > 0) ? round(($total_n_all / $total_all) * 100) : 0;
    $sisa_persen_indonesia_power = 100 - $persen_indonesia_power;

    return view('pages.dashboard', compact('dataPersen', 'persen_indonesia_power', 'sisa_persen_indonesia_power'));
}

    
    


    public function getClusterDetail($id)
    {
        $progres = M_PROGRES::where('jenis', $id)->orderByDesc('PERSEN')->get();
        $chartData = [];
    
        foreach ($progres as $v) {
            // Menghitung persen sisa agar sesuai dengan format contoh
            $persen_sisa = 100 - $v->persen;
    
            $chartData[] = [
                'element' => $v->siteid,
                'data' => [
                    ['label' => $v->description, 'value' => $v->persen],
                    ['label' => '-', 'value' => $persen_sisa]
                ],
            ];
        }
    
        return view('pages.cluster.show', compact('chartData'));
    }
    
    
}
