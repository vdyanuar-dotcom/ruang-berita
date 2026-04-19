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
                        <img src="{{ asset('images/RB.svg') }}" alt="Logo Ruang Berita" class="h-12 w-auto">
                    </a>
                    <div class="hidden md:flex space-x-4">
                        <a href="/" class="text-gray-700 hover:text-[#0006FF]">Beranda</a>
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-[#0006FF]">Kategori ▼</button>
                            <div class="absolute hidden group-hover:block bg-white shadow-lg p-2 rounded w-48 border-t-2 border-blue-600">
                                @foreach($categories as $item)
                                <a href="{{ route('newsCategory.show', $item->slug) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r from-[#0006FF] to-[#000499] hover:text-white transition-all">
                                    {{ $item->title }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <input type="text" placeholder="Cari berita..." class="border rounded-full px-4 py-1 text-sm focus:outline-blue-500">
                    <a href="/admin/login" class="bg-gradient-to-r from-[#0006FF] to-[#000499] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Masuk</a>
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
                    <span class="bg-gradient-to-r from-[#0006FF] to-[#000499] px-3 py-1 rounded-full text-xs uppercase font-bold">Berita Terbaru</span>

                    <h2 class="text-2xl md:text-4xl font-bold mt-3 leading-tight">
                        <a href="{{ route('news.show', $headline->slug) }}" class="hover:text-blue-300 transition">{{ $headline->title }}</a>
                    </h2>

                    <div class="flex items-center gap-4 mt-4 text-sm text-gray-300">
                        <span class="font-bold text-[#0006FF] uppercase">{{ $headline->newsCategory->title ?? 'Umum' }}</span>
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
        <div class="mb-8 flex items-center">
            <div class="w-1.5 h-8 rounded-full bg-gradient-to-b from-[#0006FF] to-[#000499]"></div>

            <h3 class="text-2xl font-bold ml-4 text-gray-800 tracking-tight">
                @if(isset($category))
                Kategori: <span class="text-[#0006FF]">{{ $category->title }}</span>
                @else
                Berita <span class="text-[#0006FF]">Terkini</span>
                @endif
            </h3>
        </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($allNews as $news)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition flex flex-col h-full">

                <img src="{{ asset('storage/' . $news->thumbnail) }}" class="w-full h-48 object-cover">

                <div class="p-5 flex flex-col flex-grow">
                    <span class="text-[#0006FF] text-[10px] font-extrabold uppercase tracking-widest mb-2">
                        {{ $news->newsCategory->title }}
                    </span>

                    <h4 class="text-xl font-bold leading-tight mb-3">
                        {{ Str::limit($news->title, 50) }}
                    </h4>

                    <p class="text-gray-500 text-sm line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($news->content), 100) }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-xs text-gray-400">Oleh: {{ $news->author->name ?? 'Admin' }}</span>
                        <a href="{{ route('news.show', $news->slug) }}"
                            class="text-[#0006FF] font-bold text-sm hover:underline">
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