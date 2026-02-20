<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Exports\SertifikatExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('user.laporan.index');
    }

    public function sertifikatPdf(Request $request)
    {
        $sertifikats = Sertifikat::where('user_id', auth()->id())->latest()->get();
        $pdf = Pdf::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('sertifikat-saya-' . now()->format('Ymd') . '.pdf');
    }

    public function sertifikatExcel(Request $request)
    {
        return Excel::download(
            new SertifikatExport($request->all(), null, null, auth()->id()),
            'sertifikat-saya-' . now()->format('Ymd') . '.xlsx'
        );
    }
}
