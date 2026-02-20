<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DataSkm;
use App\Models\DataEkspor;

class BerandaController extends Controller
{
    public function index()
    {
        $latestSkm = DataSkm::orderByDesc('tahun')->first();
        $latestEkspor = DataEkspor::where('tahun', date('Y'))->orderByDesc('bulan')->first();
        return view('public.beranda', compact('latestSkm', 'latestEkspor'));
    }
}
