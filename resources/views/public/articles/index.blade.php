<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog | {{ config('app.name', 'Article Management') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50">
    <!-- Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200/60">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('public.articles.index') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30 transform group-hover:rotate-6 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5zm0 0h-3.75V4.5M10.5 7.5h.008v.008h-.008V7.5zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <span class="font-black text-xl tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Artiknesia</span>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 md:py-24">
        <div class="text-center space-y-4 mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Blog Kami</h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Temukan artikel menarik, tips berguna, dan insight terbaru dari tim kami.</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('public.articles.index') }}" method="GET" class="max-w-2xl mx-auto mb-12">
            <div class="relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}"
                    placeholder="Cari artikel..." 
                    class="w-full px-6 py-4 rounded-2xl border-2 border-slate-200 focus:border-indigo-500 focus:outline-none text-base shadow-sm transition-colors"
                >
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z" />
                    </svg>
                </button>
            </div>
        </form>
    </section>

    <!-- Articles Grid -->
    <section class="max-w-7xl mx-auto px-6 pb-16">
        @if($articles->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <article class="group bg-white rounded-2xl border border-slate-200/80 overflow-hidden hover:shadow-lg hover:border-indigo-200 transition-all duration-300">
                        <!-- Article Header Card -->
                        <!-- Article Header Card -->
                        <div class="aspect-video overflow-hidden relative group/image bg-slate-100">
                            @if($article->cover_image)
                                <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-full object-cover group-hover/image:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-200 group-hover/image:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity flex items-end p-4">
                                <span class="text-xs text-white font-medium bg-black/40 px-2.5 py-1 rounded-full backdrop-blur-sm">Lihat Detail</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-4">
                            <!-- Meta -->
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2 text-slate-500">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-[10px]">
                                        {{ substr($article->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="font-medium">{{ $article->user->name ?? 'Anonymous' }}</span>
                                </div>
                                <time datetime="{{ $article->published_at->toIso8601String() }}" class="text-slate-400">
                                    {{ $article->published_at->format('d M Y') }}
                                </time>
                            </div>

                            <!-- Title -->
                            <a href="{{ route('public.articles.show', $article->slug) }}" class="group/title block">
                                <h2 class="text-lg font-bold text-slate-900 line-clamp-2 group-hover/title:text-indigo-600 transition-colors">
                                    {{ $article->title }}
                                </h2>
                            </a>

                            <!-- Excerpt -->
                            <p class="text-sm text-slate-600 line-clamp-2">
                                {{ strip_tags($article->content) }}
                            </p>

                            <!-- Read More Link -->
                            <a href="{{ route('public.articles.show', $article->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700 group/link transition-colors pt-2">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16 space-y-4">
                <svg class="w-16 h-16 mx-auto text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3.042.525A9.006 9.006 0 002.25 9m14.25-9h.008v.008h-.008V9m0 0A8.966 8.966 0 0112 21c4.486 0 8.268-2.977 9.75-7m.75.75v-2.008.008v2m0 0h.008v-.008h-.008v.008zM3 9.75h.008v.008H3V9.75zm14.25 0h.008v.008h-.008V9.75z" />
                </svg>
                <p class="text-lg text-slate-500">Belum ada artikel yang dipublikasikan.</p>
                <p class="text-sm text-slate-400">Kembali lagi nanti untuk konten terbaru.</p>
            </div>
        @endif
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Article Management') }}. Semua hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
