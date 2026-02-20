<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class RegulasiController extends Controller
{
    public function index()
    {
        return view('public.regulasi');
    }
}
