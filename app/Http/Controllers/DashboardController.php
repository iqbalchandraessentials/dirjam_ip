<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getClusterDetail($id) {
        $chartData = [
            [
                'element' => 'indonesia-power1',
                'data' => [['label' => 'SLA', 'value' => 100]],
                'colors' => ['#14A2B8'],
                'resize' => true
            ],
            [
                'element' => 'indonesia-power2',
                'data' => [['label' => 'MSU', 'value' => 100]],
                'colors' => ['#14A2B8'],
                'resize' => true
            ],
            [
                'element' => 'indonesia-power3',
                'data' => [['label' => 'PRO', 'value' => 100]],
                'colors' => ['#14A2B8'],
                'resize' => true
            ],
        ];
        
        return view('pages.cluster.show', compact('chartData'));
    }
    
    
}
