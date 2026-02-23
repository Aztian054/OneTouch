<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DataSkm;
use App\Models\SkmSurvey;
use Illuminate\Http\Request;

class SkmController extends Controller
{
    public function index()
    {
        $skmData = DataSkm::orderBy('tahun')->get();
        
        // Get survey statistics for real-time chart
        $surveyStats = SkmSurvey::selectRaw('
            DATE_FORMAT(submitted_at, "%Y-%m") as month,
            COUNT(*) as total_surveys,
            AVG((q1_kualitas_pelayanan + q2_kompetensi_petugas + q3_kecepatan + q4_kenyamanan + q5_kenyamanan_sarpras + q6_fasilitas + q7_penampilan) / 7) as avg_rating
        ')
        ->where('submitted_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        // Get rating distribution
        $ratingDistribution = SkmSurvey::selectRaw('
            ROUND((q1_kualitas_pelayanan + q2_kompetensi_petugas + q3_kecepatan + q4_kenyamanan + q5_kenyamanan_sarpras + q6_fasilitas + q7_penampilan) / 7) as avg_rating,
            COUNT(*) as count
        ')
        ->where('submitted_at', '>=', now()->subMonths(6))
        ->groupBy('avg_rating')
        ->orderBy('avg_rating')
        ->get();
        
        // Get total surveys count
        $totalSurveys = SkmSurvey::count();
        $avgOverall = SkmSurvey::selectRaw('AVG((q1_kualitas_pelayanan + q2_kompetensi_petugas + q3_kecepatan + q4_kenyamanan + q5_kenyamanan_sarpras + q6_fasilitas + q7_penampilan) / 7) as avg')->first()->avg ?? 0;
        
        return view('public.skm', compact('skmData', 'surveyStats', 'ratingDistribution', 'totalSurveys', 'avgOverall'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|string|max:20',
            'jenis_layanan' => 'required|string|max:255',
            'q1_kualitas_pelayanan' => 'required|numeric|min:1|max:5',
            'q2_kompetensi_petugas' => 'required|numeric|min:1|max:5',
            'q3_kecepatan' => 'required|numeric|min:1|max:5',
            'q4_kenyamanan' => 'required|numeric|min:1|max:5',
            'q5_kenyamanan_sarpras' => 'required|numeric|min:1|max:5',
            'q6_fasilitas' => 'required|numeric|min:1|max:5',
            'q7_penampilan' => 'required|numeric|min:1|max:5',
            'saran_masukan' => 'nullable|string|max:1000',
        ]);

        SkmSurvey::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'jenis_layanan' => $validated['jenis_layanan'],
            'q1_kualitas_pelayanan' => $validated['q1_kualitas_pelayanan'],
            'q2_kompetensi_petugas' => $validated['q2_kompetensi_petugas'],
            'q3_kecepatan' => $validated['q3_kecepatan'],
            'q4_kenyamanan' => $validated['q4_kenyamanan'],
            'q5_kenyamanan_sarpras' => $validated['q5_kenyamanan_sarpras'],
            'q6_fasilitas' => $validated['q6_fasilitas'],
            'q7_penampilan' => $validated['q7_penampilan'],
            'saran_masukan' => $validated['saran_masukan'] ?? null,
            'ip_address' => $request->ip(),
            'submitted_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->route('skm')
            ->with('success', 'Survey Anda telah berhasil dikirim. Terima kasih!');
    }
}
