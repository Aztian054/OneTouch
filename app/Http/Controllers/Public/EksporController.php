<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DataEkspor;

class EksporController extends Controller
{
    public function index()
    {
        // Pass semua data — view menggunakan Chart.js dengan client-side year filtering
        $years      = DataEkspor::selectRaw('DISTINCT tahun')->orderBy('tahun')->pluck('tahun');
        $eksporData = DataEkspor::orderBy('tahun')->orderBy('bulan')->get();

        return view('public.ekspor', compact('eksporData', 'years'));
    }
}
