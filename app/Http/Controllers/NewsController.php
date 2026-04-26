<?php

namespace App\Http\Controllers;

use App\Models\News;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // Headline (1 berita paling baru)
        $headline = \App\Models\News::latest()->first();

        // Berita Terkini (6 berita setelah headline)
        $allNews = \App\Models\News::latest()->skip(1)->take(6)->get();

        // Berita Lainnya (berita sisanya, mulai dari urutan ke-8)
        $listNews = \App\Models\News::latest()->skip(7)->take(10)->get();

        // Berita Terpopuler untuk Sidebar
        $popularNews = \App\Models\News::orderBy('view_count', 'desc')->take(5)->get();

        return view('welcome', compact('headline', 'allNews', 'listNews', 'popularNews'));
    }

    public function category($slug)
    {
        // 1. Cari kategori berdasarkan slug
        $category = \App\Models\NewsCategory::where('slug', $slug)->firstOrFail();

        // 2. Ambil kategori untuk navbar (jika tidak pakai View Share)
        $categories = \App\Models\NewsCategory::all();

        // 3. Ambil berita berdasarkan kategori
        // Kita masukkan semua berita kategori ini ke listNews agar muncul ke bawah
        $listNews = \App\Models\News::with(['newsCategory', 'author'])
            ->where('news_category_id', $category->id)
            ->latest()
            ->get();

        // 4. Kirim variabel yang dibutuhkan Blade (gridNews/allNews kita kosongkan saja)
        return view('welcome', [
            'category' => $category,
            'categories' => $categories,
            'allNews' => collect(), // Kosongkan grid agar tidak dobel
            'listNews' => $listNews, // Masukkan data ke sini
            'headline' => null      // Sembunyikan headline di halaman kategori
        ]);
    }

    public function show($slug)
    {
        // 1. Ambil detail berita utama
        $news = \App\Models\News::with(['newsCategory', 'author'])->where('slug', $slug)->firstOrFail();

        // 2. Tambahkan view count (yang tadi kita buat)
        $news->increment('view_count');

        // 3. AMBIL BERITA TERKAIT
        $relatedNews = \App\Models\News::where('news_category_id', $news->news_category_id) // Kategori sama
            ->where('id', '!=', $news->id) // Jangan tampilkan berita yang sedang dibaca
            ->latest()
            ->take(3) // Ambil 3 berita saja
            ->get();

        // 4. Berita Terpopuler untuk Sidebar (supaya tidak error)
        $popularNews = \App\Models\News::orderBy('view_count', 'desc')->take(5)->get();

        return view('show', compact('news', 'relatedNews', 'popularNews'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        // Cari berita berdasarkan judul atau konten
        $allNews = \App\Models\News::with(['newsCategory', 'author'])
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->latest()
            ->get();

        // Ambil data sidebar agar tidak error
        $categories = \App\Models\NewsCategory::all();
        $popularNews = \App\Models\News::orderBy('view_count', 'desc')->take(5)->get();

        // Kita gunakan view yang sama (welcome), tapi tanpa headline agar fokus ke hasil
        return view('welcome', [
            'allNews' => $allNews,
            'categories' => $categories,
            'popularNews' => $popularNews,
            'headline' => null, // Sembunyikan headline saat searching
            'listNews' => collect(), // Kosongkan list bawah saat searching
            'searchTitle' => "Hasil Pencarian: \"{$query}\""
        ]);
    }
}
