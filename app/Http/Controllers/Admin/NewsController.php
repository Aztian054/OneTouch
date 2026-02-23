<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of all news
     */
    public function index()
    {
        $news = News::orderBy('order', 'asc')->get();
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date' => 'nullable|date',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:0',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'order.required' => 'Urutan wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/news'), $imageName);
            $validated['image'] = 'assets/news/' . $imageName;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified news
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news in storage
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date' => 'nullable|date',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:0',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'order.required' => 'Urutan wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/news'), $imageName);
            $validated['image'] = 'assets/news/' . $imageName;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', "Berita '{$news->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified news from storage
     */
    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}