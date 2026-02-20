<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Inspeksi;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalSertifikat   = Sertifikat::where('user_id', $userId)->count();
        $sertifikatAktif   = Sertifikat::where('user_id', $userId)->where('status_masa', 'aktif')->count();
        $sertifikatWarning = Sertifikat::where('user_id', $userId)->where('status_masa', 'warning')->count();
        $sertifikatExpired = Sertifikat::where('user_id', $userId)->where('status_masa', 'expired')->count();
        $totalInspeksi     = Inspeksi::where('user_id', $userId)->count();

        $warningList = Sertifikat::where('user_id', $userId)
            ->where('status_masa', 'warning')
            ->latest('tanggal_kadaluwarsa')
            ->limit(5)->get();

        $recentInspeksi = Inspeksi::where('user_id', $userId)
            ->latest()->limit(5)->get();

        return view('user.dashboard', compact(
            'totalSertifikat', 'sertifikatAktif', 'sertifikatWarning', 'sertifikatExpired',
            'totalInspeksi', 'warningList', 'recentInspeksi'
        ));
    }
}
