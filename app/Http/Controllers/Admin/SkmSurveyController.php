<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkmSurvey;
use Illuminate\Http\Request;
use App\Exports\SkmSurveyExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SkmSurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = SkmSurvey::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by jenis layanan
        if ($request->has('jenis_layanan') && $request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        // Search by name or email
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $surveys = $query->orderBy('submitted_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => SkmSurvey::count(),
            'today' => SkmSurvey::whereDate('submitted_at', today())->count(),
            'average_rating' => SkmSurvey::active()->avgRating(),
        ];

        // Chart data
        $chartData = $this->getChartData($request);

        return view('admin.skm.index', compact('surveys', 'stats', 'chartData'));
    }

    public function show(SkmSurvey $skmSurvey)
    {
        return view('admin.skm.show', compact('skmSurvey'));
    }

    public function edit(SkmSurvey $skmSurvey)
    {
        return view('admin.skm.edit', compact('skmSurvey'));
    }

    public function update(Request $request, SkmSurvey $skmSurvey)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|string|max:20',
            'jenis_layanan' => 'nullable|string|max:255',
            'q1_kualitas_pelayanan' => 'required|numeric|min:0|max:5',
            'q2_kompetensi_petugas' => 'required|numeric|min:0|max:5',
            'q3_kecepatan' => 'required|numeric|min:0|max:5',
            'q4_kenyamanan' => 'required|numeric|min:0|max:5',
            'q5_kenyamanan_sarpras' => 'required|numeric|min:0|max:5',
            'q6_fasilitas' => 'required|numeric|min:0|max:5',
            'q7_penampilan' => 'required|numeric|min:0|max:5',
            'saran_masukan' => 'nullable|string',
            'status' => 'required|in:active,archived',
        ]);

        $skmSurvey->update($validated);

        return redirect()->route('admin.skm.show', $skmSurvey)
            ->with('success', 'Survey berhasil diperbarui.');
    }

    public function destroy(SkmSurvey $skmSurvey)
    {
        $skmSurvey->delete();

        return redirect()->route('admin.skm.index')
            ->with('success', 'Survey berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new SkmSurveyExport($request), 'skm-surveys.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = SkmSurvey::query();

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        if ($request->has('jenis_layanan') && $request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        $surveys = $query->orderBy('submitted_at', 'desc')->get();
        $chartData = $this->getChartData($request);

        $pdf = Pdf::loadView('pdf.skm-surveys', compact('surveys', 'chartData'));
        return $pdf->download('skm-surveys.pdf');
    }

    private function getChartData(Request $request)
    {
        $query = SkmSurvey::active();

        // Apply filters
        if ($request->has('jenis_layanan') && $request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        return [
            'q1_kualitas_pelayanan' => round($query->avg('q1_kualitas_pelayanan'), 1),
            'q2_kompetensi_petugas' => round($query->avg('q2_kompetensi_petugas'), 1),
            'q3_kecepatan' => round($query->avg('q3_kecepatan'), 1),
            'q4_kenyamanan' => round($query->avg('q4_kenyamanan'), 1),
            'q5_kenyamanan_sarpras' => round($query->avg('q5_kenyamanan_sarpras'), 1),
            'q6_fasilitas' => round($query->avg('q6_fasilitas'), 1),
            'q7_penampilan' => round($query->avg('q7_penampilan'), 1),
        ];
    }
}