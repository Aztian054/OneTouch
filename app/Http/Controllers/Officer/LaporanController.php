<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Inspeksi;
use App\Models\User;
use App\Exports\SertifikatExport;
use App\Exports\InspeksiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function getScope(): array
    {
        $officer = auth()->user();
        $userIds = User::where('officer_id', $officer->id)->pluck('id')->toArray();
        return [$officer->id, $userIds];
    }

    public function index()
    {
        return view('officer.laporan.index');
    }

    public function sertifikatPdf(Request $request)
    {
        [$officerId, $userIds] = $this->getScope();
        $sertifikats = Sertifikat::with('owner')
            ->where(function ($q) use ($officerId, $userIds) {
                $q->where('created_by', $officerId)->orWhereIn('user_id', $userIds);
            })->latest()->get();

        $pdf = Pdf::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-sertifikat-' . now()->format('Ymd') . '.pdf');
    }

    public function sertifikatExcel(Request $request)
    {
        [$officerId, $userIds] = $this->getScope();
        return Excel::download(
            new SertifikatExport($request->all(), $officerId, $userIds),
            'laporan-sertifikat-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function inspeksiPdf(Request $request)
    {
        [$officerId, $userIds] = $this->getScope();
        $inspeksis = Inspeksi::with('owner')
            ->where(function ($q) use ($officerId, $userIds) {
                $q->where('created_by', $officerId)->orWhereIn('user_id', $userIds);
            })->latest()->get();

        $pdf = Pdf::loadView('pdf.laporan-inspeksi', compact('inspeksis'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-inspeksi-' . now()->format('Ymd') . '.pdf');
    }

    public function inspeksiExcel(Request $request)
    {
        [$officerId, $userIds] = $this->getScope();
        return Excel::download(
            new InspeksiExport($request->all(), $officerId, $userIds),
            'laporan-inspeksi-' . now()->format('Ymd') . '.xlsx'
        );
    }
}
