<?php

namespace App\Http\Controllers;

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

    public function show($slug) {
    // Cari berita berdasarkan slug-nya
    $news = \App\Models\News::with(['newsCategory', 'author'])->where('slug', $slug)->firstOrFail();
    
    // Ambil berita lain sebagai rekomendasi di samping (sidebar)
    $relatedNews = \App\Models\News::where('id', '!=', $news->id)->latest()->take(5)->get();

    return view('show', compact('news', 'relatedNews'));
}
}
