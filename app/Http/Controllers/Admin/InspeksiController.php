<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspeksi;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InspeksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Inspeksi::with('owner', 'creator');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('nama_perusahaan', 'like', "%$q%");
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_sertifikat', $request->jenis);
        }

        $inspeksis = $query->latest()->paginate(15)->appends(request()->query());
        $jenisList = Sertifikat::getJenisList();

        return view('admin.inspeksi.index', compact('inspeksis', 'jenisList'));
    }

    public function create()
    {
        $jenisList = Sertifikat::getJenisList();
        $users     = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.inspeksi.create', compact('jenisList', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'nama_perusahaan' => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'kategori'        => 'required|in:Inspeksi,Surveilan',
            'jenis_sertifikat'=> 'required|in:' . implode(',', Sertifikat::getJenisList()),
            'berkas'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data['created_by']    = auth()->id();
        $data['status_berkas'] = 'Tidak Ada';

        if ($request->hasFile('berkas')) {
            $data['berkas_path']   = $request->file('berkas')->store('inspeksi', 'public');
            $data['status_berkas'] = 'Terkirim';
        }

        unset($data['berkas']);
        Inspeksi::create($data);
        return redirect()->route('admin.inspeksi.index')->with('success', 'Data inspeksi berhasil ditambahkan.');
    }

    public function show(Inspeksi $inspeksi)
    {
        $inspeksi->load('owner', 'creator');
        return view('admin.inspeksi.show', compact('inspeksi'));
    }

    public function edit(Inspeksi $inspeksi)
    {
        $jenisList = Sertifikat::getJenisList();
        $users     = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.inspeksi.edit', compact('inspeksi', 'jenisList', 'users'));
    }

    public function update(Request $request, Inspeksi $inspeksi)
    {
        $data = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'nama_perusahaan' => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'kategori'        => 'required|in:Inspeksi,Surveilan',
            'jenis_sertifikat'=> 'required|in:' . implode(',', Sertifikat::getJenisList()),
            'berkas'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('berkas')) {
            if ($inspeksi->berkas_path) {
                Storage::disk('public')->delete($inspeksi->berkas_path);
            }
            $data['berkas_path']   = $request->file('berkas')->store('inspeksi', 'public');
            $data['status_berkas'] = 'Terkirim';
        }

        unset($data['berkas']);
        $inspeksi->update($data);
        return redirect()->route('admin.inspeksi.index')->with('success', 'Data inspeksi berhasil diperbarui.');
    }

    public function destroy(Inspeksi $inspeksi)
    {
        if ($inspeksi->berkas_path) {
            Storage::disk('public')->delete($inspeksi->berkas_path);
        }
        $inspeksi->delete();
        return redirect()->route('admin.inspeksi.index')->with('success', 'Data inspeksi berhasil dihapus.');
    }
}
