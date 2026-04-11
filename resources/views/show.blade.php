<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - Ruang Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #374151;
            font-size: 1.125rem;
        }

        /* Membuat teks berita menjadi rata kanan-kiri */
        .content-berita {
            text-align: justify;
            text-justify: inter-word;
            /* Memastikan spasi antar kata rapi */
        }

        /* Opsional: Menambahkan indentasi (menjorok) pada awal paragraf */
        .content-berita p {
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-sm sticky top-0 z-50 mb-8">
        <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="/">
                <img src="{{ asset('images/ruangberita.svg') }}" alt="Logo Ruang Berita" class="h-16 w-auto">
            </a>
            <a href="/" class="text-gray-600 hover:text-blue-600 font-medium">← Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 lg:flex gap-12">

        <article class="lg:w-2/3 bg-white p-6 md:p-10 rounded-2xl shadow-sm">
            <div class="flex items-center gap-3 text-sm mb-4">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold uppercase">
                    {{ $news->newsCategory->title}}
                </span>
                <span class="text-gray-400">•</span>
                <span class="text-gray-500">{{ $news->created_at->format('d M Y') }}</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $news->title }}
            </h1>

            <div class="flex items-center gap-3 mb-8 pb-8 border-b">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                    {{ substr($news->author->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">{{ $news->author->name ?? 'Redaksi Ruang Berita' }}</p>
                    <p class="text-xs text-gray-500">Jurnalis</p>
                </div>
            </div>

            <figure class="mb-10">
                <img src="{{ asset('storage/' . $news->thumbnail) }}" class="w-full rounded-xl shadow-lg">
                <figcaption class="text-center text-sm text-gray-400 mt-3 italic">
                    Sumber Foto: Dokumentasi Ruang Berita
                </figcaption>
            </figure>

            <div class="content-berita prose prose-lg max-w-none text-gray-700">
                {!! $news->content !!}
            </div>

            <!-- <div class="mt-12 pt-8 border-t flex items-center gap-4">
                <span class="text-sm font-bold text-gray-400 uppercase">Bagikan:</span>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Facebook</button>
                <button class="bg-sky-400 text-white px-4 py-2 rounded-lg text-sm">Twitter</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">WhatsApp</button>
            </div> -->
        </article>

        <aside class="lg:w-1/3 mt-12 lg:mt-0">
            <h3 class="text-xl font-bold mb-6 border-l-4 border-blue-600 pl-4 uppercase tracking-wider">Berita Terpopuler</h3>
            <div class="space-y-6">
                @foreach($relatedNews as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="flex gap-4 group">
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-24 h-24 object-cover rounded-lg shrink-0">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition leading-snug">
                            {{ Str::limit($item->title, 60) }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </a>
                @endforeach
            </div>

        </aside>

    </main>

    <footer class="bg-white border-t mt-20 py-10 text-center text-gray-400 text-sm">
        &copy; 2026 Ruang Berita.
    </footer>

</body>

</html>