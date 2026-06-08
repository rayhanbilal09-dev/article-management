<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $article->title }} | {{ config('app.name', 'Article Management') }}</title>

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

        .article-content {
            @apply prose prose-sm md:prose-base prose-indigo max-w-none;
        }

        .article-content h1, .article-content h2, .article-content h3 {
            @apply font-bold text-slate-900 mt-6 mb-4;
        }

        .article-content h1 {
            @apply text-3xl;
        }

        .article-content h2 {
            @apply text-2xl;
        }

        .article-content h3 {
            @apply text-xl;
        }

        .article-content p {
            @apply text-slate-700 leading-relaxed mb-4;
        }

        .article-content a {
            @apply text-indigo-600 hover:text-indigo-700 underline;
        }

        .article-content ul, .article-content ol {
            @apply my-4 ml-6;
        }

        .article-content li {
            @apply mb-2 text-slate-700;
        }

        .article-content blockquote {
            @apply border-l-4 border-indigo-600 pl-4 py-2 my-4 italic text-slate-600;
        }

        .article-content code {
            @apply bg-slate-100 text-slate-900 px-2 py-1 rounded text-sm font-mono;
        }

        .article-content pre {
            @apply bg-slate-900 text-slate-100 p-4 rounded-lg overflow-x-auto my-4;
        }

        .article-content pre code {
            @apply bg-transparent text-slate-100 px-0 py-0;
        }
    </style>
</head>
<body class="bg-slate-50">
    <!-- Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200/60">
        <nav class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('public.articles.index') }}" class="flex items-center gap-2 group hover:opacity-80 transition-opacity">
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
                @endauth
            </div>
        </nav>
    </header>

    <!-- Article Content -->
    <article class="max-w-4xl mx-auto px-6 py-12 md:py-16">
        <!-- Back Link -->
        <a href="{{ route('public.articles.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold mb-8 group transition-colors">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Blog
        </a>

        <!-- Article Header -->
        <header class="space-y-6 mb-8 pb-8 border-b border-slate-200">
            <!-- Category/Status Badge -->
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold uppercase tracking-wide">
                    Dipublikasikan
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $article->title }}
            </h1>

            <!-- Meta Information -->
            <div class="flex flex-col md:flex-row md:items-center gap-4 text-slate-600">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold">
                        {{ substr($article->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">{{ $article->user->name ?? 'Anonymous' }}</p>
                        <p class="text-sm text-slate-500">{{ $article->user->email ?? '' }}</p>
                    </div>
                </div>

                <span class="hidden md:block text-slate-300">•</span>

                <div class="flex items-center gap-2 text-sm">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <time datetime="{{ $article->published_at->toIso8601String() }}">
                        {{ $article->published_at->format('d F Y \p\u\k\u\l H:i') }}
                    </time>
                </div>
            </div>
        </header>

        <!-- Article Body -->
        <div class="article-content mb-16">
            {!! nl2br(e($article->content)) !!}
        </div>

        <!-- Article Footer -->
        <footer class="border-t border-slate-200 pt-8 space-y-6">
            <!-- Author Card -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                        {{ substr($article->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 mb-1">{{ $article->user->name ?? 'Anonymous' }}</h3>
                        <p class="text-sm text-slate-600 mb-3">Penulis artikel ini di Artiknesia Blog Platform.</p>
                        <p class="text-xs text-slate-500">{{ $article->user->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Back to Blog -->
            <div class="text-center">
                <a href="{{ route('public.articles.index') }}" class="inline-block px-6 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition-colors">
                    ← Kembali ke Daftar Artikel
                </a>
            </div>
        </footer>
    </article>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Article Management') }}. Semua hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
