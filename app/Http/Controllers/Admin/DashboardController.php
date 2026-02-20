<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Inspeksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSertifikat  = Sertifikat::count();
        $sertifikatAktif  = Sertifikat::where('status_masa', 'aktif')->count();
        $sertifikatWarning = Sertifikat::where('status_masa', 'warning')->count();
        $sertifikatExpired = Sertifikat::where('status_masa', 'expired')->count();

        $totalInspeksi    = Inspeksi::count();
        $totalOfficer     = User::where('role', 'officer')->count();
        $totalUser        = User::where('role', 'user')->count();

        $recentSertifikat = Sertifikat::with('owner', 'creator')
            ->latest()->limit(5)->get();
        $recentInspeksi   = Inspeksi::with('owner', 'creator')
            ->latest()->limit(5)->get();

        // Chart data — sertifikat per jenis
        $sertifikatPerJenis = Sertifikat::selectRaw('jenis_sertifikat, COUNT(*) as total')
            ->groupBy('jenis_sertifikat')->get();

        return view('admin.dashboard', compact(
            'totalSertifikat', 'sertifikatAktif', 'sertifikatWarning', 'sertifikatExpired',
            'totalInspeksi', 'totalOfficer', 'totalUser',
            'recentSertifikat', 'recentInspeksi', 'sertifikatPerJenis'
        ));
    }
}
