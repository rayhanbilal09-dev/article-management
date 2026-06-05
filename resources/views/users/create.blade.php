@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in duration-300">
    <!-- Header Section -->
    <div class="flex items-center gap-4">
        <a href="{{ route('users.index') }}" 
           class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors shadow-sm"
           title="Kembali ke Daftar User">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah User Baru</h1>
            <p class="text-slate-500 mt-1 text-sm">Silakan isi formulir di bawah ini untuk menambahkan pengguna baru.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <form action="{{ route('users.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            <!-- Name Input -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name"
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap user..."
                    class="w-full px-4 py-3 bg-white border @error('name') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-250 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">
                @error('name')
                    <p class="text-xs font-semibold text-rose-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-bold text-slate-700">Alamat Email</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="contoh: user@artiknesia.com"
                    class="w-full px-4 py-3 bg-white border @error('email') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-250 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">
                @error('email')
                    <p class="text-xs font-semibold text-rose-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Min. 6 karakter..."
                    class="w-full px-4 py-3 bg-white border @error('password') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-250 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">
                @error('password')
                    <p class="text-xs font-semibold text-rose-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('users.index') }}" 
                   class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm shadow-md shadow-indigo-600/10 hover:shadow-lg transition-all duration-150">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection