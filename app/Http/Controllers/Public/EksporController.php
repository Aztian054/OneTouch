<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DataEkspor;
use Illuminate\Http\Request;

class EksporController extends Controller
{
    public function index(Request $request)
    {
        // Get all years for filter
        $years = DataEkspor::selectRaw('DISTINCT tahun')->orderBy('tahun')->pluck('tahun');
        
        // Get unique categories for filters
        $categories = [
            'komoditas' => 'Komoditas',
            'negara_tujuan' => 'Negara Tujuan Ekspor',
            'unit_pelaksana' => 'Unit Pelaksana Teknis',
            'eksportir' => 'Eksportir',
        ];

        // Get all export data for client-side filtering
        $eksporData = DataEkspor::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'bulan' => $item->bulan,
                    'bulan_nama' => $item->nama_bulan,
                    'tahun' => $item->tahun,
                    'frekuensi' => $item->frekuensi,
                    'volume' => $item->volume,
                    'nilai' => $item->nilai,
                    'komoditas' => $item->komoditas ?? 'Lainnya',
                    'negara_tujuan' => $item->negara_tujuan ?? 'Lainnya',
                    'unit_pelaksana' => $item->unit_pelaksana ?? 'Lainnya',
                    'eksportir' => $item->eksportir ?? 'Lainnya',
                ];
            });

        // Get summary data for ALL data (not just latest year)
        $totalNilaiUSD = $eksporData->sum('nilai');
        $summary = [
            'total_frekuensi' => $eksporData->sum('frekuensi'),
            'total_volume' => $eksporData->sum('volume'),
            'total_nilai_idr' => $totalNilaiUSD * 15500, // IDR conversion rate
            'total_nilai_usd' => $totalNilaiUSD,
            'year' => $years->isNotEmpty() ? $years->last() . ' - ' . $years->first() : 'Data tidak tersedia',
        ];

        return view('public.ekspor', compact('eksporData', 'years', 'categories', 'summary'));
    }
}
