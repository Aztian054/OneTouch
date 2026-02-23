<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Inspeksi;
use App\Exports\SertifikatExport;
use App\Exports\InspeksiExport;
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

    public function inspeksiPdf(Request $request)
    {
        $inspeksis = Inspeksi::where('user_id', auth()->id())->latest()->get();
        $pdf = Pdf::loadView('pdf.laporan-inspeksi', compact('inspeksis'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('inspeksi-saya-' . now()->format('Ymd') . '.pdf');
    }

    public function inspeksiExcel(Request $request)
    {
        return Excel::download(
            new InspeksiExport($request->all(), null, null, auth()->id()),
            'inspeksi-saya-' . now()->format('Ymd') . '.xlsx'
        );
    }
}
