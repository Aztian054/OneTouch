<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class AplikasiController extends Controller
{
    public function index()
    {
        return view('public.aplikasi');
    }
}
