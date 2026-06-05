@extends('layouts.app')

@section('content')
<div class="space-y-6 animate-fade-in duration-300">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Artikel</h1>
            <p class="text-slate-500 mt-1 text-sm">Tulis, publikasikan, dan kelola konten artikel Anda dalam satu tempat.</p>
        </div>
        <a href="{{ route('articles.create') }}" 
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-indigo-600/10 hover:shadow-lg transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tulis Artikel
        </a>
    </div>

    <!-- Table & Filtering Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Filter/Search Bar -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/20">
            <form method="GET" action="{{ route('articles.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan judul artikel..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-250 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all duration-200">
                </div>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-all duration-150">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('articles.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-650 text-sm font-semibold rounded-xl transition-all duration-150">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-450">ID</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-450">Judul Artikel</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-450">Penulis</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-450">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-450 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($articles as $article)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="px-6 py-4.5 text-sm font-medium text-slate-400">#{{ $article->id }}</td>
                            <td class="px-6 py-4.5 max-w-sm">
                                <span class="font-semibold text-slate-800 text-sm block truncate" title="{{ $article->title }}">
                                    {{ $article->title }}
                                </span>
                                <span class="text-xs text-slate-400 block mt-0.5">{{ $article->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4.5 text-sm text-slate-600 font-medium">
                                {{ $article->user->name ?? 'User Terhapus' }}
                            </td>
                            <td class="px-6 py-4.5 text-sm">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-550"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-slate-100 text-slate-600 border border-slate-200 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4.5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('articles.show', $article->id) }}" 
                                       class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-150" 
                                       title="Lihat Detail Artikel">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('articles.edit', $article->id) }}" 
                                       class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-150" 
                                       title="Edit Artikel">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all duration-150" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" 
                                                title="Hapus Artikel">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <span class="text-sm font-semibold">Artikel tidak ditemukan</span>
                                    <span class="text-xs text-slate-400">Silakan buat baru atau gunakan kata kunci pencarian lain.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/10">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection