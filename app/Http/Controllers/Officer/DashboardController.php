<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Inspeksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $officer = auth()->user();
        $userIds = User::where('officer_id', $officer->id)->pluck('id');

        $scopeFn = function ($q) use ($officer, $userIds) {
            $q->where('created_by', $officer->id)->orWhereIn('user_id', $userIds);
        };

        $totalSertifikat   = Sertifikat::where($scopeFn)->count();
        $sertifikatAktif   = Sertifikat::where($scopeFn)->where('status_masa', 'aktif')->count();
        $sertifikatWarning = Sertifikat::where($scopeFn)->where('status_masa', 'warning')->count();
        $sertifikatExpired = Sertifikat::where($scopeFn)->where('status_masa', 'expired')->count();
        $totalInspeksi     = Inspeksi::where($scopeFn)->count();
        $totalUsers        = User::where('officer_id', $officer->id)->count();

        $warningList = Sertifikat::with('owner')
            ->where($scopeFn)
            ->where('status_masa', 'warning')
            ->latest('tanggal_kadaluwarsa')
            ->limit(5)->get();

        $recentInspeksi = Inspeksi::with('owner')
            ->where($scopeFn)
            ->latest()->limit(5)->get();

        return view('officer.dashboard', compact(
            'totalSertifikat', 'sertifikatAktif', 'sertifikatWarning', 'sertifikatExpired',
            'totalInspeksi', 'totalUsers', 'warningList', 'recentInspeksi'
        ));
    }
}
