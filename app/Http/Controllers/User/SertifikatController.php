<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $query = Sertifikat::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_pemilik', 'like', "%$s%")
                  ->orWhere('nomor_sertifikat', 'like', "%$s%");
            });
        }
        if ($request->filled('jenis'))       $query->where('jenis_sertifikat', $request->jenis);
        if ($request->filled('status_masa')) $query->where('status_masa', $request->status_masa);

        $sertifikats = $query->latest()->paginate(15)->withQueryString();
        $jenisList   = Sertifikat::getJenisList();

        return view('user.sertifikat.index', compact('sertifikats', 'jenisList'));
    }

    public function show(Sertifikat $sertifikat)
    {
        if ($sertifikat->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }
        $sertifikat->load('creator');
        return view('user.sertifikat.show', compact('sertifikat'));
    }
}
