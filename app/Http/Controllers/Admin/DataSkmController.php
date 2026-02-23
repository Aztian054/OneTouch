<?php

namespace App\Http\Controllers\Admin;

use App\Models\DataSkm;
use Illuminate\Http\Request;

class DataSkmController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of all SKM data
     */
    public function index()
    {
        $skmData = DataSkm::orderBy('tahun', 'desc')->get();
        return view('admin.data-skm.index', compact('skmData'));
    }

    /**
     * Show the form for creating new SKM data
     */
    public function create()
    {
        return view('admin.data-skm.create');
    }

    /**
     * Store new SKM data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'target' => 'required|numeric|min:1|max:5',
            'realisasi' => 'required|numeric|min:1|max:5',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'target.required' => 'Target wajib diisi.',
            'realisasi.required' => 'Realisasi wajib diisi.',
            'target.max' => 'Target maksimal 5.',
            'realisasi.max' => 'Realisasi maksimal 5.',
        ]);

        DataSkm::create($validated);

        return redirect()->route('admin.data-skm.index')
            ->with('success', 'Data SKM tahun ' . $validated['tahun'] . ' berhasil ditambahkan.');
    }

    /**
     * Show the form for editing SKM data
     */
    public function edit(DataSkm $dataSkm)
    {
        return view('admin.data-skm.edit', compact('dataSkm'));
    }

    /**
     * Update SKM data
     */
    public function update(Request $request, DataSkm $dataSkm)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'target' => 'required|numeric|min:1|max:5',
            'realisasi' => 'required|numeric|min:1|max:5',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'target.required' => 'Target wajib diisi.',
            'realisasi.required' => 'Realisasi wajib diisi.',
            'target.max' => 'Target maksimal 5.',
            'realisasi.max' => 'Realisasi maksimal 5.',
        ]);

        $dataSkm->update($validated);

        return redirect()->route('admin.data-skm.index')
            ->with('success', 'Data SKM tahun ' . $validated['tahun'] . ' berhasil diperbarui.');
    }

    /**
     * Delete SKM data
     */
    public function destroy(DataSkm $dataSkm)
    {
        $tahun = $dataSkm->tahun;
        $dataSkm->delete();

        return redirect()->route('admin.data-skm.index')
            ->with('success', 'Data SKM tahun ' . $tahun . ' berhasil dihapus.');
    }
}