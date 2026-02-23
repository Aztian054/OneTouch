<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of all pages
     */
    public function index()
    {
        $pages = Page::orderBy('order', 'asc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified page
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'hero_image' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:0',
        ], [
            'title.required' => 'Judul halaman wajib diisi.',
            'order.required' => 'Urutan wajib diisi.',
        ]);

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', "Halaman '{$page->title}' berhasil diperbarui.");
    }
}