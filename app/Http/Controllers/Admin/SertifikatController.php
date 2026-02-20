<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $query = Sertifikat::with('owner', 'creator');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('nama_pemilik', 'like', "%$q%")
                   ->orWhere('nomor_sertifikat', 'like', "%$q%");
            });
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_sertifikat', $request->jenis);
        }
        if ($request->filled('status_masa')) {
            $query->where('status_masa', $request->status_masa);
        }

        $sertifikats = $query->latest()->paginate(15)->appends(request()->query());
        $jenisList   = Sertifikat::getJenisList();
        $officers    = User::where('role', 'officer')->get();
        $users       = User::where('role', 'user')->get();

        return view('admin.sertifikat.index', compact('sertifikats', 'jenisList', 'officers', 'users'));
    }

    public function create()
    {
        $jenisList = Sertifikat::getJenisList();
        $users     = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.sertifikat.create', compact('jenisList', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'nama_pemilik'       => 'required|string|max:255',
            'nomor_sertifikat'   => 'required|string|max:100|unique:sertifikats',
            'ruang_lingkup'      => 'required|string|max:500',
            'jenis_sertifikat'   => 'required|in:' . implode(',', Sertifikat::getJenisList()),
            'grade'              => 'required|in:A,B,C',
            'tanggal_terbit'     => 'required|date',
            'tanggal_kadaluwarsa'=> 'required|date|after:tanggal_terbit',
            'status_proses'      => 'required|in:Pending,Process,Completed',
            'berkas'             => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data['created_by']  = auth()->id();
        $data['status_masa'] = Sertifikat::computeStatusMasa($data['tanggal_kadaluwarsa']);

        if ($request->hasFile('berkas')) {
            $data['berkas_path']   = $request->file('berkas')->store('sertifikat', 'public');
            $data['status_berkas'] = 'Terkirim';
        }

        unset($data['berkas']);
        Sertifikat::create($data);
        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function show(Sertifikat $sertifikat)
    {
        $sertifikat->load('owner', 'creator');
        return view('admin.sertifikat.show', compact('sertifikat'));
    }

    public function edit(Sertifikat $sertifikat)
    {
        $jenisList = Sertifikat::getJenisList();
        $users     = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.sertifikat.edit', compact('sertifikat', 'jenisList', 'users'));
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        $data = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'nama_pemilik'       => 'required|string|max:255',
            'nomor_sertifikat'   => 'required|string|max:100|unique:sertifikats,nomor_sertifikat,' . $sertifikat->id,
            'ruang_lingkup'      => 'required|string|max:500',
            'jenis_sertifikat'   => 'required|in:' . implode(',', Sertifikat::getJenisList()),
            'grade'              => 'required|in:A,B,C',
            'tanggal_terbit'     => 'required|date',
            'tanggal_kadaluwarsa'=> 'required|date|after:tanggal_terbit',
            'status_proses'      => 'required|in:Pending,Process,Completed',
            'berkas'             => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data['status_masa'] = Sertifikat::computeStatusMasa($data['tanggal_kadaluwarsa']);

        if ($request->hasFile('berkas')) {
            if ($sertifikat->berkas_path) {
                Storage::disk('public')->delete($sertifikat->berkas_path);
            }
            $data['berkas_path']   = $request->file('berkas')->store('sertifikat', 'public');
            $data['status_berkas'] = 'Terkirim';
        }

        unset($data['berkas']);
        $sertifikat->update($data);
        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        if ($sertifikat->berkas_path) {
            Storage::disk('public')->delete($sertifikat->berkas_path);
        }
        $sertifikat->delete();
        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }
}
