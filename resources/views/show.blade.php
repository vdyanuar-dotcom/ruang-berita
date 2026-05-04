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
                <img src="{{ asset('images/RB.svg') }}" alt="Logo Ruang Berita" class="h-12 w-auto">
            </a>
            <a href="/" class="text-gray-600 hover:text-[#0006FF] font-medium">← Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 lg:flex gap-12">

        <article class="lg:w-2/3 bg-white p-6 md:p-10 rounded-2xl shadow-sm">
            <div class="flex items-center gap-3 text-sm mb-4">
                <span class="bg-blue-100 text-[#0006FF] px-3 py-1 rounded-full font-bold uppercase">
                    {{ $news->newsCategory->title}}
                </span>
                <span class="text-gray-400">•</span>
                <span class="text-gray-500">{{ $news->created_at->format('d M Y') }}</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $news->title }}
            </h1>

            <div class="flex items-center gap-3 mb-8 pb-8 border-b">
                <div class="w-10 h-10 bg-[#0006FF] rounded-full flex items-center justify-center text-white font-bold">
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

            <div class="mt-12 pt-8 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-6 bg-gradient-to-b from-[#0006FF] to-[#000499] rounded-full"></div>
                    <h3 class="text-xl font-bold text-gray-800">Berita Terkait</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedNews as $related)
                    <a href="{{ route('news.show', $related->slug) }}" class="group">
                        <div class="aspect-video rounded-lg overflow-hidden mb-3">
                            <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <h4 class="text-sm font-bold leading-tight group-hover:text-[#0006FF] transition">
                            {{ Str::limit($related->title, 55) }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 pt-8 border-t flex items-center gap-4">
                <span class="text-sm font-bold text-gray-400 uppercase">Bagikan:</span>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Facebook</button>
                <button class="bg-sky-400 text-white px-4 py-2 rounded-lg text-sm">Twitter</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">WhatsApp</button>
            </div>
        </article>

        <aside class="lg:w-1/3 mt-12 lg:mt-0">
            {{-- BAGIAN 1: BERITA TERPOPULER --}}
            <h3 class="text-xl font-bold mb-6 border-l-4 border-[#0006FF] pl-4 uppercase tracking-wider">
                Berita Terpopuler
            </h3>
            <div class="space-y-6 mb-12">
                @foreach($popularNews as $key => $popular)
                <a href="{{ route('news.show', $popular->slug) }}" class="flex items-start gap-4 group">
                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 group-hover:bg-gradient-to-br group-hover:from-[#0006FF] group-hover:to-[#000499] group-hover:text-white transition-all text-gray-400 font-bold text-lg">
                        {{ $key + 1 }}
                    </div>

                    <div class="flex-grow">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#0006FF]">
                            {{ $popular->newsCategory->title }}
                        </span>
                        <h4 class="text-sm font-bold leading-snug group-hover:underline decoration-[#0006FF]">
                            {{ Str::limit($popular->title, 60) }}
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-1">
                            {{ $popular->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- BAGIAN 2: BERITA TERKAIT (Berikan Judul Baru) --}}
            @if(isset($relatedNews) && $relatedNews->count() > 0)
            <h3 class="text-xl font-bold mb-6 border-l-4 border-[#0006FF] pl-4 uppercase tracking-wider">
                Berita Terkait
            </h3>
            <div class="space-y-6">
                @foreach($relatedNews as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="flex gap-4 group">
                    <img src="{{ asset('storage/' . $item->thumbnail) }}"
                        class="w-20 h-20 object-cover rounded-lg shrink-0 shadow-sm group-hover:opacity-80 transition">
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#0006FF] transition leading-tight">
                            {{ Str::limit($item->title, 50) }}
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-2">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </aside>

    </main>

    <footer class="bg-white border-t mt-20 py-10 text-center text-gray-400 text-sm">
        &copy; 2026 Ruang Berita.
    </footer>

</body>

</html>