@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in duration-300">
    <!-- Header Section -->
    <div class="flex items-center gap-4">
        <a href="{{ route('articles.index') }}" 
           class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors shadow-sm"
           title="Kembali ke Daftar Artikel">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Artikel</h1>
            <p class="text-slate-500 mt-1 text-sm">Sesuaikan konten, status, atau penulis artikel ini.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <form action="{{ route('articles.update', $article->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Grid: Author and Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Author Select (Superadmin Only) -->
                @if(Auth::user()->isSuperAdmin())
                    <div class="space-y-2">
                        <label for="user_id" class="block text-sm font-bold text-slate-700">Penulis (Author)</label>
                        <div class="relative">
                            <select 
                                id="user_id"
                                name="user_id" 
                                class="w-full px-4 py-3 bg-white border border-slate-250 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 rounded-xl text-sm focus:outline-none appearance-none transition-all duration-200">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $article->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                        </div>
                        @error('user_id')
                            <p class="text-xs font-semibold text-rose-600 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @endif

                <!-- Status Select -->
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-bold text-slate-700">Status Publikasi</label>
                    <div class="relative">
                        <select 
                            id="status"
                            name="status" 
                            class="w-full px-4 py-3 bg-white border border-slate-250 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 rounded-xl text-sm focus:outline-none appearance-none transition-all duration-200">
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft (Simpan Internal)</option>
                            <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </div>
                    </div>
                    @error('status')
                        <p class="text-xs font-semibold text-rose-600 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Title Input -->
            <div class="space-y-2">
                <label for="title" class="block text-sm font-bold text-slate-700">Judul Artikel</label>
                <input 
                    type="text" 
                    id="title"
                    name="title" 
                    value="{{ old('title', $article->title) }}"
                    placeholder="Masukkan judul artikel yang menarik..."
                    class="w-full px-4 py-3 bg-white border @error('title') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-250 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">
                @error('title')
                    <p class="text-xs font-semibold text-rose-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Content Area -->
            <div class="space-y-2">
                <label for="content" class="block text-sm font-bold text-slate-700">Konten / Isi Artikel</label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="8"
                    placeholder="Tuliskan isi artikel lengkap Anda di sini..."
                    class="w-full px-4 py-3 bg-white border @error('content') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-250 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <p class="text-xs font-semibold text-rose-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('articles.index') }}" 
                   class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm shadow-md shadow-indigo-600/10 hover:shadow-lg transition-all duration-150">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
