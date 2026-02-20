<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class LayananController extends Controller
{
    public function index()
    {
        return view('public.layanan');
    }
}
