<?php

namespace App\Http\Controllers;

use App\Models\PersenUrjabPembangkit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $progres = PersenUrjabPembangkit::get();
    
        // Ambil rata-rata dari kolom 'persen'
        $rataPersen = $progres->avg(function ($item) {
            return (float) $item->persen;
        });
    
        // Batasi maksimum ke 100 jika perlu
        $rataPersen = round(min($rataPersen, 100), 2);
    
        $indonesiaPower = (object) [
            'jenis_pembangkit' => 'IndonesiaPower',
            'n' => $progres->sum('n'),
            'total' => $progres->sum('total'),
            'persen' => $rataPersen,
        ];
    
        $progres->prepend($indonesiaPower);
    
        return view('pages.dashboard', compact('progres'));
    }

    public function getClusterDetail($id)
    {
        $progres = PersenUrjabPembangkit::where('jenis', $id)->orderByDesc('PERSEN')->get();
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
