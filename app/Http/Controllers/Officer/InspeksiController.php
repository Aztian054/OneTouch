<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Inspeksi;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InspeksiController extends Controller
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
        $query = $this->scopeQuery(Inspeksi::with('owner'));

        if ($request->filled('search'))   $query->where('nama_perusahaan', 'like', '%' . $request->search . '%');
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('jenis'))    $query->where('jenis_sertifikat', $request->jenis);

        $inspeksis = $query->latest()->paginate(15)->withQueryString();
        $jenisList = Sertifikat::getJenisList();

        return view('officer.inspeksi.index', compact('inspeksis', 'jenisList'));
    }

    public function create()
    {
        $jenisList     = Sertifikat::getJenisList();
        $assignedUsers = User::where('officer_id', auth()->id())->orderBy('name')->get();
        return view('officer.inspeksi.create', compact('jenisList', 'assignedUsers'));
    }

    public function store(Request $request)
    {
        $assignedIds = User::where('officer_id', auth()->id())->pluck('id')->toArray();

        $data = $request->validate([
            'user_id'         => 'required|in:' . implode(',', $assignedIds ?: [0]),
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
        return redirect()->route('officer.inspeksi.index')->with('success', 'Data inspeksi berhasil ditambahkan.');
    }

    public function show(Inspeksi $inspeksi)
    {
        $this->authorize_access($inspeksi);
        $inspeksi->load('owner', 'creator');
        return view('officer.inspeksi.show', compact('inspeksi'));
    }

    public function edit(Inspeksi $inspeksi)
    {
        $this->authorize_access($inspeksi);
        $jenisList     = Sertifikat::getJenisList();
        $assignedUsers = User::where('officer_id', auth()->id())->orderBy('name')->get();
        return view('officer.inspeksi.edit', compact('inspeksi', 'jenisList', 'assignedUsers'));
    }

    public function update(Request $request, Inspeksi $inspeksi)
    {
        $this->authorize_access($inspeksi);
        $assignedIds = User::where('officer_id', auth()->id())->pluck('id')->toArray();

        $data = $request->validate([
            'user_id'         => 'required|in:' . implode(',', $assignedIds ?: [0]),
            'nama_perusahaan' => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'kategori'        => 'required|in:Inspeksi,Surveilan',
            'jenis_sertifikat'=> 'required|in:' . implode(',', Sertifikat::getJenisList()),
            'berkas'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('berkas')) {
            if ($inspeksi->berkas_path) Storage::disk('public')->delete($inspeksi->berkas_path);
            $data['berkas_path']   = $request->file('berkas')->store('inspeksi', 'public');
            $data['status_berkas'] = 'Terkirim';
        }

        unset($data['berkas']);
        $inspeksi->update($data);
        return redirect()->route('officer.inspeksi.index')->with('success', 'Data inspeksi berhasil diperbarui.');
    }

    public function destroy(Inspeksi $inspeksi)
    {
        $this->authorize_access($inspeksi);
        if ($inspeksi->berkas_path) Storage::disk('public')->delete($inspeksi->berkas_path);
        $inspeksi->delete();
        return redirect()->route('officer.inspeksi.index')->with('success', 'Data inspeksi berhasil dihapus.');
    }

    private function authorize_access(Inspeksi $inspeksi): void
    {
        $officer = auth()->user();
        $userIds = User::where('officer_id', $officer->id)->pluck('id');
        if ($inspeksi->created_by !== $officer->id && !$userIds->contains($inspeksi->user_id)) {
            abort(403, 'Akses ditolak.');
        }
    }
}
