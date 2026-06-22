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
        @if($article->cover_image)
            <div class="w-full aspect-[21/9] md:aspect-[3/1] rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 mb-10 shadow-sm">
                <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-full object-cover" alt="{{ $article->title }}">
            </div>
        @endif

        <div class="article-content mb-16">
            {!! nl2br(e($article->content)) !!}
        </div>

        <!-- Article Gallery -->
        @if($article->media->count() > 0)
            <div class="border-t border-slate-200 pt-10 pb-6 mb-12">
                <h3 class="font-extrabold text-xl text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5.5 h-5.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    Galeri Media Pendukung
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($article->media as $media)
                        <div class="group bg-white border border-slate-200 rounded-2xl overflow-hidden p-3 shadow-sm hover:shadow-md transition-shadow">
                            <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-900 relative">
                                @if($media->type === 'image')
                                    <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" alt="{{ $media->caption ?? 'Gallery Image' }}">
                                    </a>
                                @else
                                    <video src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover" controls preload="metadata"></video>
                                @endif
                            </div>
                            @if($media->caption)
                                <p class="text-xs text-slate-500 font-semibold text-center mt-2.5 px-1 leading-relaxed">
                                    {{ $media->caption }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Rating and Feedback Section -->
        <section class="border-t border-slate-200 pt-10 mt-12">
            <div class="bg-white border border-slate-200/60 rounded-2xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="font-extrabold text-xl text-slate-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Penilaian Artikel
                        </h3>
                        <p class="text-sm text-slate-600">Berikan penilaian Anda untuk membantu kami meningkatkan kualitas konten.</p>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <div class="text-center md:text-right">
                            <p class="text-3xl font-black text-slate-900" id="avg-rating-text">{{ $article->average_rating }}</p>
                            <p class="text-xs font-semibold text-slate-500"><span id="total-ratings-text">{{ $article->ratings()->count() }}</span> penilaian</p>
                        </div>
                        
                        <div class="h-10 w-px bg-slate-200"></div>
                        
                        <div>
                            @auth
                                @php
                                    $userRating = $article->ratings()->where('user_id', auth()->id())->first()?->rating ?? 0;
                                @endphp
                                <p class="text-xs font-bold text-slate-500 mb-1">Rating Anda:</p>
                                <div class="flex items-center gap-1" id="star-rating-widget" data-user-rating="{{ $userRating }}" data-article-id="{{ $article->id }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" data-rating="{{ $i }}" class="rating-star-btn text-slate-300 hover:scale-110 transition-transform focus:outline-none">
                                            <svg class="w-4 h-4 fill-current {{ $i <= $userRating ? 'text-amber-400' : 'text-slate-300' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <span id="rating-status-msg" class="text-xs text-indigo-600 font-semibold block mt-1 h-4"></span>
                            @else
                                <div class="text-center">
                                    <div class="flex gap-1 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 text-slate-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <a href="{{ route('login') }}" class="text-xs text-indigo-600 hover:underline font-bold">Login untuk memberi rating</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <section class="mt-12 border-t border-slate-200 pt-10 space-y-8">
            <h3 class="font-extrabold text-xl text-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025 10.325 10.325 0 00-2.28-2.28C1.845 15.347 1 13.743 1 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                Komentar ({{ $article->allComments()->count() }})
            </h3>

            <!-- Alert messages -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->has('body'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-start gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="font-bold">Komentar Ditolak:</p>
                        <p class="font-medium text-xs mt-0.5">{{ $errors->first('body') }}</p>
                    </div>
                </div>
            @endif

            <!-- Comment Form -->
            @auth
                <form action="{{ route('articles.comments.store', $article) }}" method="POST" class="space-y-4 bg-slate-50 border border-slate-100 rounded-2xl p-5 shadow-sm">
                    @csrf
                    <div>
                        <label for="body" class="block text-sm font-bold text-slate-700 mb-2">Tulis Komentar</label>
                        <textarea id="body" name="body" rows="4" required placeholder="Tulis komentar Anda di sini... (Pastikan mengandung kata-kata yang diizinkan jika filter aktif)" class="w-full rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm p-4 bg-white shadow-inner">{{ old('body') }}</textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition-colors shadow-md shadow-indigo-600/10">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 text-center shadow-sm">
                    <p class="text-slate-600 text-sm font-medium mb-3">Silakan login untuk bergabung dalam diskusi dan menulis komentar.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition-colors shadow-md shadow-indigo-600/10">
                        Login Sekarang
                    </a>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6 mt-8">
                @forelse($article->comments as $comment)
                    <!-- Parent Comment -->
                    <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow relative">
                        <div class="flex items-start gap-4">
                            <!-- Avatar -->
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                {{ substr($comment->user->name ?? 'U', 0, 1) }}
                            </div>
                            
                            <!-- Comment Body -->
                            <div class="flex-grow space-y-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-bold text-slate-900 text-sm block md:inline">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                        @if($comment->user_id === $article->user_id)
                                            <span class="ml-1 px-2 py-0.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Penulis</span>
                                        @endif
                                        <span class="md:ml-2 text-slate-400 text-xs font-medium block md:inline">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center gap-2">
                                        @auth
                                            @if(auth()->id() === $comment->user_id || auth()->user()->isSuperAdmin())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-rose-600 p-1 rounded-lg hover:bg-rose-50 transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <button type="button" class="open-report-modal text-slate-400 hover:text-amber-600 p-1 rounded-lg hover:bg-amber-50 transition-colors" data-comment-id="{{ $comment->id }}" title="Laporkan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a1 1 0 00.764-.97V4.34a1 1 0 00-1.236-.971l-2.22.522a9 9 0 01-6.108-.683l-.108-.054a9 9 0 00-6.086-.71L3 4.5M3 15V4.5"/></svg>
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                                
                                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $comment->body }}</p>
                                
                                <div class="pt-1">
                                    @auth
                                        <button type="button" class="toggle-reply-btn text-indigo-600 hover:text-indigo-700 font-bold text-xs flex items-center gap-1 focus:outline-none" data-target="reply-form-{{ $comment->id }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                                            Balas
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <!-- Reply Form (Hidden by default) -->
                        @auth
                            <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 pl-14 pt-4 border-t border-slate-100">
                                <form action="{{ route('articles.comments.store', $article) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <div>
                                        <textarea name="body" rows="2" required placeholder="Tulis balasan Anda..." class="w-full rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-xs p-3 bg-slate-50/50 shadow-inner"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2 text-right">
                                        <button type="button" class="toggle-reply-btn px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition-colors focus:outline-none" data-target="reply-form-{{ $comment->id }}">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                                            Kirim Balasan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endauth

                        <!-- Nested Replies -->
                        @if($comment->replies->count() > 0)
                            <div class="mt-4 pl-10 md:pl-14 space-y-4 border-t border-slate-100 pt-4">
                                @foreach($comment->replies as $reply)
                                    <div class="bg-slate-50/60 border border-slate-100/80 rounded-xl p-4 relative">
                                        <div class="flex items-start gap-3">
                                            <!-- Mini Avatar -->
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-sm">
                                                {{ substr($reply->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            
                                            <!-- Reply Content -->
                                            <div class="flex-grow space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <span class="font-bold text-slate-900 text-xs">{{ $reply->user->name ?? 'Anonymous' }}</span>
                                                        @if($reply->user_id === $article->user_id)
                                                            <span class="ml-1 px-1.5 py-0.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-[9px] font-bold rounded-full uppercase tracking-wider">Penulis</span>
                                                        @endif
                                                        <span class="ml-2 text-slate-400 text-[10px] font-medium">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    
                                                    <!-- Actions -->
                                                    <div class="flex items-center gap-2">
                                                        @auth
                                                            @if(auth()->id() === $reply->user_id || auth()->user()->isSuperAdmin())
                                                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-slate-400 hover:text-rose-600 p-0.5 rounded transition-colors" title="Hapus">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            
                                                            <button type="button" class="open-report-modal text-slate-400 hover:text-amber-600 p-0.5 rounded transition-colors" data-comment-id="{{ $reply->id }}" title="Laporkan">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a1 1 0 00.764-.97V4.34a1 1 0 00-1.236-.971l-2.22.522a9 9 0 01-6.108-.683l-.108-.054a9 9 0 00-6.086-.71L3 4.5M3 15V4.5"/></svg>
                                                            </button>
                                                        @endauth
                                                    </div>
                                                </div>
                                                
                                                <p class="text-slate-700 text-xs leading-relaxed whitespace-pre-line">{{ $reply->body }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-8 text-center">
                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25M12 13.875V9.75M3.75 7.5h16.5M5.625 7.5h12.75M5.625 7.5A2.25 2.25 0 018 5.25h8a2.25 2.25 0 012.25 2.25M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375"/></svg>
                        <p class="text-slate-500 text-sm font-semibold">Belum ada komentar.</p>
                        <p class="text-slate-400 text-xs mt-1">Jadilah yang pertama untuk menulis komentar di artikel ini!</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Article Footer -->
        <footer class="border-t border-slate-200 pt-8 space-y-6 mt-12">
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

    <!-- Report Comment Modal -->
    @auth
        <div id="report-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" id="close-report-backdrop"></div>
            
            <!-- Modal Box -->
            <div class="relative bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl border border-slate-200 transform scale-95 transition-transform duration-300 z-10">
                <h4 class="font-extrabold text-lg text-slate-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Laporkan Komentar
                </h4>
                <p class="text-slate-500 text-xs mb-4">Mohon pilih alasan pelaporan komentar ini agar admin dapat meninjaunya secara objektif.</p>
                
                <form id="report-form" action="" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="reason" class="block text-xs font-bold text-slate-700 mb-1">Alasan Pelaporan</label>
                        <select id="reason" name="reason" required class="w-full rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3 bg-slate-50/50">
                            <option value="">-- Pilih Alasan --</option>
                            <option value="Spam / Iklan tidak relevan">Spam / Iklan tidak relevan</option>
                            <option value="Komentar kasar / Abusive / Kebencian">Komentar kasar / Abusive / Kebencian</option>
                            <option value="Pelecehan / Bullying">Pelecehan / Bullying</option>
                            <option value="Konten seksual / Tidak pantas">Konten seksual / Tidak pantas</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" id="close-report-modal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors focus:outline-none">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-md shadow-rose-600/10">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Article Management') }}. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Threaded comments: Toggle reply form
            document.querySelectorAll('.toggle-reply-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetForm = document.getElementById(targetId);
                    if (targetForm) {
                        targetForm.classList.toggle('hidden');
                    }
                });
            });

            // 2. Report comment modal handling
            const reportModal = document.getElementById('report-modal');
            const reportForm = document.getElementById('report-form');
            const closeReportBtn = document.getElementById('close-report-modal');
            const closeReportBackdrop = document.getElementById('close-report-backdrop');

            document.querySelectorAll('.open-report-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    if (reportForm && reportModal) {
                        // Set the form action dynamically
                        reportForm.action = `/comments/${commentId}/report`;
                        reportModal.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                });
            });

            function hideReportModal() {
                if (reportModal) {
                    reportModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            if (closeReportBtn) closeReportBtn.addEventListener('click', hideReportModal);
            if (closeReportBackdrop) closeReportBackdrop.addEventListener('click', hideReportModal);

            // 3. Interactive Star Rating Widget
            const starWidget = document.getElementById('star-rating-widget');
            if (starWidget) {
                const articleId = starWidget.getAttribute('data-article-id');
                const starBtns = starWidget.querySelectorAll('.rating-star-btn');
                const statusMsg = document.getElementById('rating-status-msg');
                const avgText = document.getElementById('avg-rating-text');
                const totalText = document.getElementById('total-ratings-text');
                
                let currentRating = parseInt(starWidget.getAttribute('data-user-rating') || '0');

                // Function to update star icons visually
                function updateStars(rating) {
                    starBtns.forEach(btn => {
                        const starVal = parseInt(btn.getAttribute('data-rating'));
                        const svg = btn.querySelector('svg');
                        if (starVal <= rating) {
                            svg.classList.remove('text-slate-300');
                            svg.classList.add('text-amber-400');
                        } else {
                            svg.classList.remove('text-amber-400');
                            svg.classList.add('text-slate-300');
                        }
                    });
                }

                starBtns.forEach(btn => {
                    // Hover event: highlight up to hovered star
                    btn.addEventListener('mouseenter', function() {
                        const hoverRating = parseInt(this.getAttribute('data-rating'));
                        updateStars(hoverRating);
                    });

                    // Click event: send rating via Fetch API
                    btn.addEventListener('click', function() {
                        const newRating = parseInt(this.getAttribute('data-rating'));
                        statusMsg.textContent = 'Menyimpan...';
                        statusMsg.className = 'text-xs text-indigo-600 font-semibold block mt-1 h-4';

                        fetch(`/articles/${articleId}/ratings`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ rating: newRating })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                currentRating = newRating;
                                starWidget.setAttribute('data-user-rating', currentRating);
                                updateStars(currentRating);
                                
                                // Update stats in UI
                                if (avgText) avgText.textContent = data.average_rating;
                                if (totalText) totalText.textContent = data.total_ratings;
                                
                                statusMsg.textContent = data.message || 'Rating berhasil disimpan!';
                                statusMsg.className = 'text-xs text-emerald-600 font-semibold block mt-1 h-4';
                                
                                setTimeout(() => {
                                    statusMsg.textContent = '';
                                }, 3000);
                            } else {
                                throw new Error(data.message || 'Gagal menyimpan rating.');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            updateStars(currentRating);
                            statusMsg.textContent = 'Gagal menyimpan rating. Coba lagi.';
                            statusMsg.className = 'text-xs text-rose-600 font-semibold block mt-1 h-4';
                        });
                    });
                });

                // Mouse leave: revert to current user rating
                starWidget.addEventListener('mouseleave', function() {
                    updateStars(currentRating);
                });
            }
        });
    </script>
</body>
</html>
