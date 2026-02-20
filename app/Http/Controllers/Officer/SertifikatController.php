<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    private function scopeQuery($query)
    {
        $officer = auth()->user();
        $userIds = User::where('officer_id', $officer->id)->pluck('id');
        return $query->where(function ($q) use ($officer, $userIds) {
            $q->where('created_by', $officer->id)->orWhereIn('user_id', $userIds);
        });
    }

    public function index(Request $request)
    {
        $query = $this->scopeQuery(Sertifikat::with('owner'));

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

        return view('officer.sertifikat.index', compact('sertifikats', 'jenisList'));
    }

    public function create()
    {
        $jenisList     = Sertifikat::getJenisList();
        $assignedUsers = User::where('officer_id', auth()->id())->orderBy('name')->get();
        return view('officer.sertifikat.create', compact('jenisList', 'assignedUsers'));
    }

    public function store(Request $request)
    {
        $assignedIds = User::where('officer_id', auth()->id())->pluck('id')->toArray();

        $data = $request->validate([
            'user_id'            => 'required|in:' . implode(',', $assignedIds ?: [0]),
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
        return redirect()->route('officer.sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function show(Sertifikat $sertifikat)
    {
        $this->authorize_access($sertifikat);
        $sertifikat->load('owner', 'creator');
        return view('officer.sertifikat.show', compact('sertifikat'));
    }

    public function edit(Sertifikat $sertifikat)
    {
        $this->authorize_access($sertifikat);
        $jenisList     = Sertifikat::getJenisList();
        $assignedUsers = User::where('officer_id', auth()->id())->orderBy('name')->get();
        return view('officer.sertifikat.edit', compact('sertifikat', 'jenisList', 'assignedUsers'));
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        $this->authorize_access($sertifikat);
        $assignedIds = User::where('officer_id', auth()->id())->pluck('id')->toArray();

        $data = $request->validate([
            'user_id'            => 'required|in:' . implode(',', $assignedIds ?: [0]),
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
        return redirect()->route('officer.sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        $this->authorize_access($sertifikat);
        if ($sertifikat->berkas_path) {
            Storage::disk('public')->delete($sertifikat->berkas_path);
        }
        $sertifikat->delete();
        return redirect()->route('officer.sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    private function authorize_access(Sertifikat $sertifikat): void
    {
        $officer = auth()->user();
        $userIds = User::where('officer_id', $officer->id)->pluck('id');
        if ($sertifikat->created_by !== $officer->id && !$userIds->contains($sertifikat->user_id)) {
            abort(403, 'Akses ditolak.');
        }
    }
}
