<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DataSkm;

class SkmController extends Controller
{
    public function index()
    {
        $skmData = DataSkm::orderBy('tahun')->get();
        return view('public.skm', compact('skmData'));
    }
}
