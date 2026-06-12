@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in duration-300">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('articles.index') }}" 
               class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors shadow-sm"
               title="Kembali ke Daftar Artikel">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Detail Artikel</h1>
                <p class="text-slate-500 mt-1 text-sm">Membaca detail dan konten artikel yang telah dibuat.</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('articles.edit', $article->id) }}" 
               class="inline-flex items-center gap-2 bg-white border border-slate-250 hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-colors">
                <svg class="w-4.5 h-4.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Edit Artikel
            </a>
        </div>
    </div>

    <!-- Article Content Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        
        <!-- Cover Image Banner -->
        @if($article->cover_image)
            <div class="w-full aspect-[21/9] md:aspect-[3/1] bg-slate-100 border-b border-slate-200 overflow-hidden">
                <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-full object-cover" alt="Article Cover Banner">
            </div>
        @endif

        <div class="p-6 md:p-10 space-y-8">
            <!-- Meta Details Header -->
            <div class="space-y-4 border-b border-slate-100 pb-6">
                <div class="flex flex-wrap items-center gap-3">
                    @if($article->status === 'published')
                        @if($article->published_at && $article->published_at->isFuture())
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-blue-50 text-blue-700 border border-blue-100 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Scheduled (Terjadwal)
                            </span>
                            @if($article->published_at)
                                <span class="text-xs text-slate-400 font-medium">
                                    Dijadwalkan terbit pada {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y H:i') }}
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-550"></span>
                                Published
                            </span>
                            @if($article->published_at)
                                <span class="text-xs text-slate-400 font-medium">
                                    Dipublikasikan pada {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y H:i') }}
                                </span>
                            @endif
                        @endif
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-slate-100 text-slate-600 border border-slate-200 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            Draft
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Belum dipublikasikan</span>
                    @endif
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">
                    {{ $article->title }}
                </h2>

                <!-- Author Card Info -->
                <div class="flex items-center gap-3 pt-2">
                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 font-bold text-sm flex items-center justify-center uppercase">
                        {{ substr($article->user->name ?? 'U', 0, 2) }}
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-slate-800">{{ $article->user->name ?? 'User Terhapus' }}</span>
                        <span class="block text-[11px] text-slate-400 font-medium">{{ $article->user->email ?? 'N/A' }} • Penulis Utama</span>
                    </div>
                </div>
            </div>

            <!-- Article Content Body -->
            <article class="prose max-w-none text-slate-700 leading-relaxed text-base space-y-4 whitespace-pre-line border-b border-slate-100 pb-8">
                {{ $article->content }}
            </article>

            <!-- Gallery Media Grid Section -->
            @if($article->media->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">Galeri Media Pendukung</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($article->media as $media)
                            <div class="group bg-slate-50 border border-slate-100 rounded-2xl overflow-hidden p-2.5 space-y-2 hover:shadow-md transition-all">
                                <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-900 relative">
                                    @if($media->type === 'image')
                                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" alt="Gallery image">
                                        </a>
                                    @else
                                        <video src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover" controls preload="metadata"></video>
                                    @endif
                                </div>
                                @if($media->caption)
                                    <p class="text-xs text-slate-500 font-medium text-center truncate px-2" title="{{ $media->caption }}">
                                        {{ $media->caption }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
