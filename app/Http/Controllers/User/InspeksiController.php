<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inspeksi;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class InspeksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Inspeksi::where('user_id', auth()->id());

        if ($request->filled('search'))   $query->where('nama_perusahaan', 'like', '%' . $request->search . '%');
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('jenis'))    $query->where('jenis_sertifikat', $request->jenis);

        $inspeksis = $query->latest()->paginate(15)->withQueryString();
        $jenisList = Sertifikat::getJenisList();

        return view('user.inspeksi.index', compact('inspeksis', 'jenisList'));
    }

    public function show(Inspeksi $inspeksi)
    {
        if ($inspeksi->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }
        $inspeksi->load('creator');
        return view('user.inspeksi.show', compact('inspeksi'));
    }
}
