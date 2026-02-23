<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Inspeksi;
use App\Models\SkmSurvey;
use App\Models\DataEkspor;
use App\Models\User;
use App\Exports\SertifikatExport;
use App\Exports\InspeksiExport;
use App\Exports\SkmSurveyExport;
use App\Exports\DataEksporExport;
use App\Exports\UserExport;
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

    public function usersPdf(Request $request)
    {
        $query = User::query()->with('officer');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%$q%")
                   ->orWhere('username', 'like', "%$q%");
            });
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $users = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.users', compact('users'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-users-' . now()->format('Ymd') . '.pdf');
    }

    public function usersExcel(Request $request)
    {
        return Excel::download(
            new UserExport($request->all()),
            'laporan-users-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function skmSurveysPdf(Request $request)
    {
        $query = SkmSurvey::query();

        if ($request->filled('status_masa')) {
            $query->where('status_masa', $request->status_masa);
        }
        if ($request->filled('status_proses')) {
            $query->where('status_proses', $request->status_proses);
        }
        if ($request->filled('jenis_layanan')) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('submitted_at', $request->tahun);
        }

        $surveys = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.skm-surveys', compact('surveys'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-skm-surveys-' . now()->format('Ymd') . '.pdf');
    }

    public function skmSurveysExcel(Request $request)
    {
        return Excel::download(
            new SkmSurveyExport($request->all()),
            'laporan-skm-surveys-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function dataEksporPdf(Request $request)
    {
        $query = DataEkspor::query();

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('jenis_komoditas')) {
            $query->where('jenis_komoditas', $request->jenis_komoditas);
        }
        if ($request->filled('negara_tujuan')) {
            $query->where('negara_tujuan', 'like', "%" . $request->negara_tujuan . "%");
        }

        $dataEkspor = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.data-ekspor', compact('dataEkspor'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-data-ekspor-' . now()->format('Ymd') . '.pdf');
    }

    public function dataEksporExcel(Request $request)
    {
        return Excel::download(
            new DataEksporExport($request->all()),
            'laporan-data-ekspor-' . now()->format('Ymd') . '.xlsx'
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
