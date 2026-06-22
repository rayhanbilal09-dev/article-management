@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kata & Kalimat Whitelist</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola daftar kata/kalimat yang diizinkan untuk diinput dalam komentar dan balasan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Word Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4 sticky top-24">
                <h3 class="font-bold text-slate-900 text-base">Tambah Kata Whitelist</h3>
                <p class="text-xs text-slate-500">Jika whitelist berisi data, komentar pengguna wajib mengandung minimal salah satu kata/kalimat di daftar ini agar bisa diposting. Jika whitelist kosong, semua komentar diperbolehkan.</p>
                
                <form method="POST" action="{{ route('allowed-words.store') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label for="word" class="block text-xs font-bold text-slate-700">Kata / Kalimat</label>
                        <input
                            type="text"
                            name="word"
                            id="word"
                            required
                            placeholder="Contoh: bagus, bermanfaat"
                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        @error('word')
                            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-indigo-600/10">
                        Tambah Kata
                    </button>
                </form>
            </div>
        </div>

        <!-- Words List Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-900 text-sm">Daftar Kata Aktif ({{ $allowedWords->total() }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400 w-16">#</th>
                                <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Kata/Kalimat</th>
                                <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Tanggal Ditambahkan</th>
                                <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($allowedWords as $index => $allowedWord)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-5 py-4 text-xs font-medium text-slate-400">
                                        {{ ($allowedWords->currentPage() - 1) * $allowedWords->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-5 py-4 font-bold text-slate-800">
                                        {{ $allowedWord->word }}
                                    </td>
                                    <td class="px-5 py-4 text-xs text-slate-500">
                                        {{ $allowedWord->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <form method="POST" action="{{ route('allowed-words.destroy', $allowedWord) }}" onsubmit="return confirm('Hapus kata ini dari whitelist?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-700 px-3 py-1.5 rounded-lg hover:bg-rose-50 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-500">
                                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <p class="font-bold text-sm">Whitelist Kosong</p>
                                        <p class="text-xs text-slate-400 mt-1">Seluruh komentar dan balasan pengguna akan langsung diizinkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($allowedWords->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $allowedWords->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
