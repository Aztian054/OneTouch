<?php

namespace App\Http\Controllers\Admin;

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
    public function index(Request $request)
    {
        return view('admin.laporan.index');
    }

    public function sertifikatPdf(Request $request)
    {
        $query = Sertifikat::with('owner', 'creator');
        $this->applyFilters($query, $request);
        $sertifikats = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-sertifikat-' . now()->format('Ymd') . '.pdf');
    }

    public function sertifikatExcel(Request $request)
    {
        return Excel::download(
            new SertifikatExport($request->all()),
            'laporan-sertifikat-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function inspeksiPdf(Request $request)
    {
        $query = Inspeksi::with('owner', 'creator');
        $this->applyInspeksiFilters($query, $request);
        $inspeksis = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.laporan-inspeksi', compact('inspeksis'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-inspeksi-' . now()->format('Ymd') . '.pdf');
    }

    public function inspeksiExcel(Request $request)
    {
        return Excel::download(
            new InspeksiExport($request->all()),
            'laporan-inspeksi-' . now()->format('Ymd') . '.xlsx'
        );
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('jenis'))       $query->where('jenis_sertifikat', $request->jenis);
        if ($request->filled('status_masa')) $query->where('status_masa', $request->status_masa);
        if ($request->filled('grade'))       $query->where('grade', $request->grade);
        if ($request->filled('tahun'))       $query->whereYear('tanggal_terbit', $request->tahun);
    }

    private function applyInspeksiFilters($query, Request $request): void
    {
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('jenis'))    $query->where('jenis_sertifikat', $request->jenis);
        if ($request->filled('tahun'))    $query->whereYear('tanggal', $request->tahun);
    }
}
