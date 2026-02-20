<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class TentangKamiController extends Controller
{
    public function index()
    {
        return view('public.tentang-kami');
    }
}
