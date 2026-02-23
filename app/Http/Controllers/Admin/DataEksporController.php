<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataEkspor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataEksporController extends Controller
{
    /**
     * Display a listing of data ekspor
     */
    public function index()
    {
        $dataEkspors = DataEkspor::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        return view('admin.data-ekspor.index', compact('dataEkspors'));
    }

    /**
     * Show the form for creating new data ekspor
     */
    public function create()
    {
        return view('admin.data-ekspor.create');
    }

    /**
     * Store a newly created data ekspor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'frekuensi' => 'required|integer|min:0',
            'volume' => 'required|numeric|min:0',
            'nilai' => 'required|numeric|min:0',
            'komoditas' => 'nullable|string|max:255',
            'negara_tujuan' => 'nullable|string|max:255',
            'unit_pelaksana' => 'nullable|string|max:255',
            'eksportir' => 'nullable|string|max:255',
        ], [
            'bulan.required' => 'Bulan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'frekuensi.required' => 'Frekuensi wajib diisi.',
            'volume.required' => 'Volume wajib diisi.',
            'nilai.required' => 'Nilai wajib diisi.',
        ]);

        DataEkspor::create($validated);

        return redirect()->route('admin.data-ekspor.index')
            ->with('success', 'Data ekspor berhasil ditambahkan.');
    }

    /**
     * Show the form for editing data ekspor
     */
    public function edit(DataEkspor $dataEkspor)
    {
        return view('admin.data-ekspor.edit', compact('dataEkspor'));
    }

    /**
     * Update the specified data ekspor
     */
    public function update(Request $request, DataEkspor $dataEkspor)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'frekuensi' => 'required|integer|min:0',
            'volume' => 'required|numeric|min:0',
            'nilai' => 'required|numeric|min:0',
            'komoditas' => 'nullable|string|max:255',
            'negara_tujuan' => 'nullable|string|max:255',
            'unit_pelaksana' => 'nullable|string|max:255',
            'eksportir' => 'nullable|string|max:255',
        ], [
            'bulan.required' => 'Bulan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'frekuensi.required' => 'Frekuensi wajib diisi.',
            'volume.required' => 'Volume wajib diisi.',
            'nilai.required' => 'Nilai wajib diisi.',
        ]);

        $dataEkspor->update($validated);

        return redirect()->route('admin.data-ekspor.index')
            ->with('success', 'Data ekspor berhasil diperbarui.');
    }

    /**
     * Remove the specified data ekspor
     */
    public function destroy(DataEkspor $dataEkspor)
    {
        $dataEkspor->delete();

        return redirect()->route('admin.data-ekspor.index')
            ->with('success', 'Data ekspor berhasil dihapus.');
    }

    /**
     * Remove all data ekspor
     */
    public function destroyAll(Request $request)
    {
        // Confirm password for security
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Password wajib diisi untuk konfirmasi.',
        ]);

        // Verify password
        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Password salah. Penghapusan dibatalkan.');
        }

        $count = DataEkspor::count();
        DataEkspor::truncate();

        return redirect()->route('admin.data-ekspor.index')
            ->with('success', "Semua data ekspor ({$count} record) berhasil dihapus.");
    }
}
