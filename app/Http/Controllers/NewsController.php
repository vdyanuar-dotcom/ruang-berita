<?php

namespace App\Http\Controllers;

use App\Models\News;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // Ambil 1 berita paling baru untuk banner
        $headline = \App\Models\News::with(['newsCategory', 'author'])->latest()->first();

        // Ambil berita sisanya (skip berita pertama agar tidak double)
        $allNews = \App\Models\News::with(['newsCategory', 'author'])
            ->latest()
            ->skip(1)
            ->take(6)
            ->get();

        return view('welcome', compact('headline', 'allNews'));
    }

    public function category($slug)
    {
        // 1. Cari kategori berdasarkan slug
        $category = \App\Models\NewsCategory::where('slug', $slug)->firstOrFail();

        // 2. Ambil semua kategori untuk navbar agar tidak error
        $categories = \App\Models\NewsCategory::all();

        // 3. Ambil berita (Sesuaikan kolom 'news_category_id' di bawah ini)
        $news = \App\Models\News::with(['newsCategory', 'author'])
            ->where('news_category_id', $category->id) // <--- PASTIKAN NAMA KOLOM INI BENAR
            ->latest()
            ->paginate(9);

        return view('welcome', [
            'allNews' => $news,
            'category' => $category,
            'categories' => $categories,
            'headline' => null
        ]);
    }

    public function show($slug)
    {
        // 1. Ambil berita yang sedang dibaca
        $news = \App\Models\News::with(['newsCategory', 'author'])->where('slug', $slug)->firstOrFail();

        // 2. Ambil berita terkait untuk sidebar
        $relatedNews = \App\Models\News::where('news_category_id', $news->news_category_id)
            ->where('id', '!=', $news->id)
            ->limit(5)
            ->get();

        // 3. AMBIL SEMUA KATEGORI (Agar Navbar tidak error)
        $categories = \App\Models\NewsCategory::all();

        // 4. Pastikan variabel $category diset null atau kirim kategori berita ini
        $category = null;

        // Lempar semua variabel ke view
        return view('show', compact('news', 'relatedNews', 'categories', 'category'));
    }
}
