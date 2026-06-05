@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-fade-in duration-300">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview Dashboard</h1>
            <p class="text-slate-500 mt-1.5 text-sm">Selamat datang kembali! Berikut ringkasan performa data portal Anda saat ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-slate-400 bg-slate-100/80 px-3 py-1.5 rounded-lg border border-slate-200">
                Hari ini: {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Quick Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <!-- Users Card -->
        <div class="relative overflow-hidden bg-white rounded-3xl border border-slate-150 shadow-sm p-6 hover:shadow-md transition-all duration-300 group">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-indigo-50 rounded-full opacity-60 group-hover:scale-110 transition-transform"></div>
            <div class="relative flex items-center justify-between">
                <div class="space-y-2">
                    <span class="text-sm font-semibold text-slate-400 uppercase tracking-wider block">Total Users</span>
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight block">{{ $totalUsers }}</span>
                    <span class="text-xs text-indigo-600 font-medium inline-flex items-center gap-1 mt-2">
                        Kelola Akun & Hak Akses
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                </div>
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="absolute inset-0 z-10"></a>
        </div>

        <!-- Articles Card -->
        <div class="relative overflow-hidden bg-white rounded-3xl border border-slate-150 shadow-sm p-6 hover:shadow-md transition-all duration-300 group">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-violet-50 rounded-full opacity-60 group-hover:scale-110 transition-transform"></div>
            <div class="relative flex items-center justify-between">
                <div class="space-y-2">
                    <span class="text-sm font-semibold text-slate-400 uppercase tracking-wider block">Total Articles</span>
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight block">{{ $totalArticles }}</span>
                    <span class="text-xs text-violet-600 font-medium inline-flex items-center gap-1 mt-2">
                        Tulis & Review Artikel
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                </div>
                <div class="w-14 h-14 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('articles.index') }}" class="absolute inset-0 z-10"></a>
        </div>
    </div>

    <!-- Details Section: Recent Activity lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Articles -->
        <div class="bg-white rounded-3xl border border-slate-150 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Artikel Terbaru</h2>
                    <p class="text-xs text-slate-400">Daftar artikel yang baru saja dipublikasikan atau dibuat.</p>
                </div>
                <a href="{{ route('articles.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-slate-100 overflow-x-auto flex-1">
                @forelse($recentArticles as $article)
                    <div class="p-5 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                        <div class="space-y-1 min-w-0">
                            <a href="{{ route('articles.show', $article->id) }}" class="font-semibold text-sm text-slate-800 hover:text-indigo-600 transition-colors block truncate">
                                {{ $article->title }}
                            </a>
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <span>Oleh: <span class="font-medium text-slate-600">{{ $article->user->name ?? 'User Hapus' }}</span></span>
                                <span>•</span>
                                <span>{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div>
                            @if($article->status === 'published')
                                <span class="px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full">
                                    Published
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-[11px] font-bold tracking-wide uppercase bg-slate-100 text-slate-600 border border-slate-200 rounded-full">
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">
                        Belum ada artikel yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-3xl border border-slate-150 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">User Terbaru</h2>
                    <p class="text-xs text-slate-400">Anggota atau kontributor yang baru saja bergabung.</p>
                </div>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-slate-100 overflow-x-auto flex-1">
                @forelse($recentUsers as $user)
                    <div class="p-5 flex items-center gap-3.5 hover:bg-slate-50/50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-600 border border-slate-200 uppercase">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                        <div class="space-y-0.5 min-w-0">
                            <span class="font-semibold text-sm text-slate-800 block truncate">{{ $user->name }}</span>
                            <span class="text-xs text-slate-400 block truncate">{{ $user->email }}</span>
                        </div>
                        <div class="ml-auto text-xs text-slate-400">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">
                        Belum ada user yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
