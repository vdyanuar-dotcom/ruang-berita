<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Berita - Informasi Terkini</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    <a href="/">
                        <img src="{{ asset('images/ruangberita.svg') }}" alt="Logo Ruang Berita" class="h-16 w-auto">
                    </a>
                    <div class="hidden md:flex space-x-4">
                        <a href="/" class="text-gray-700 hover:text-blue-600">Beranda</a>
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-blue-600">Kategori ▼</button>
                            <div class="absolute hidden group-hover:block bg-white shadow-lg p-2 rounded w-48 border-t-2 border-blue-600">
                                @foreach($categories as $item)
                                <a href="{{ route('newsCategory.show', $item->slug) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-700 hover:text-white transition-all">
                                    {{ $item->title }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <input type="text" placeholder="Cari berita..." class="border rounded-full px-4 py-1 text-sm focus:outline-blue-500">
                    <a href="/admin/login" class="bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        @if(!isset($category))
        <section class="mb-10">
            @if($headline)
            <div class="relative h-64 md:h-[450px] bg-gray-900 rounded-2xl overflow-hidden shadow-xl group">
                <img src="{{ asset('storage/' . $headline->thumbnail) }}"
                    class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-500"
                    alt="{{ $headline->title }}">

                <div class="absolute bottom-0 left-0 p-8 text-white w-full bg-gradient-to-t from-black via-black/50 to-transparent">
                    <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 px-3 py-1 rounded-full text-xs uppercase font-bold">Berita Terbaru</span>

                    <h2 class="text-2xl md:text-4xl font-bold mt-3 leading-tight">
                        <a href="{{ route('news.show', $headline->slug) }}" class="hover:text-blue-400 transition">{{ $headline->title }}</a>
                    </h2>

                    <div class="flex items-center gap-4 mt-4 text-sm text-gray-300">
                        <span class="font-bold text-blue-500 uppercase">{{ $headline->newsCategory->title ?? 'Umum' }}</span>
                        <span>•</span>
                        <span>{{ $headline->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            @endif
        </section>
        @endif

        @if(isset($category))
        <h3 class="text-2xl font-bold mb-2 border-l-4 border-blue-600 pl-4">
            Kategori: <span class="text-blue-600">{{ $category->title }}</span>
        </h3>
        <p class="text-gray-500 mb-6 ml-5 text-sm">Menampilkan berita terbaru dalam kategori ini.</p>
        @else
        <h3 class="text-2xl font-bold mb-6 border-l-4 border-blue-600 pl-4">Berita Terkini</h3>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($allNews as $news)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                <img src="{{ asset('storage/' . $news->thumbnail) }}" class="w-full h-48 object-cover">
                <div class="p-5">
                    <span class="text-blue-600 text-xs font-bold uppercase">{{ $news->newsCategory->title }}</span>
                    <h4 class="text-xl font-bold mt-2 leading-tight">{{ $news->title }}</h4>
                    <p class="text-gray-500 text-sm mt-3 line-clamp-3">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                    <div class="mt-4 flex justify-between items-center border-t pt-4">
                        <span class="text-xs text-gray-400">Oleh: {{ $news->author->name ?? 'Admin' }}</span>
                        <a href="{{ route('news.show', $news->slug) }}" class="text-blue-600 ...">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </main>

    <footer class="bg-white border-t mt-12 py-8 text-center text-gray-500 text-sm">
        &copy; 2026 Ruang Berita. All rights reserved.
    </footer>

</body>

</html>