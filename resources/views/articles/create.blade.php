@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('articles.index') }}"
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all shadow-sm"
           title="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Tulis Artikel Baru</h1>
            <p class="text-sm text-slate-500 mt-0.5">Bagikan ide dan wawasan Anda ke publik.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Media Section Header -->
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-sm font-bold text-slate-700">Media Artikel</h2>
                <p class="text-xs text-slate-400 mt-0.5">Upload gambar sampul dan file galeri (opsional).</p>
            </div>

            <!-- Media Upload Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6 border-b border-slate-100">

                <!-- Cover Image -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wider">Cover Image</label>
                    <div class="relative group min-h-[150px] flex flex-col items-center justify-center border-2 border-dashed border-slate-200 hover:border-indigo-300 rounded-xl bg-white transition-all cursor-pointer">
                        <input type="file" name="cover_image" id="cover_image" accept="image/*"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                        <!-- Placeholder -->
                        <div id="cover-placeholder" class="flex flex-col items-center gap-2 text-center p-4">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-600">Klik untuk upload</p>
                                <p class="text-[11px] text-slate-400">JPG, PNG, WEBP · Maks. 10MB</p>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div id="cover-preview-wrap" class="hidden absolute inset-0 rounded-xl overflow-hidden">
                            <img id="cover-preview-img" src="" class="w-full h-full object-cover" alt="Preview Cover">
                            <div class="absolute inset-0 bg-black/20 flex items-start justify-end p-2">
                                <button type="button" id="remove-cover-btn"
                                        class="p-1 bg-rose-600 hover:bg-rose-700 text-white rounded-lg shadow transition-colors z-20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('cover_image')
                        <p class="text-xs text-rose-600 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Gallery Media -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wider">Galeri Media</label>
                    <div class="relative group min-h-[150px] flex flex-col items-center justify-center border-2 border-dashed border-slate-200 hover:border-indigo-300 rounded-xl bg-white transition-all cursor-pointer">
                        <input type="file" name="media[]" id="gallery_media" accept="image/*,video/*" multiple
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                        <!-- Placeholder -->
                        <div id="gallery-placeholder" class="flex flex-col items-center gap-2 text-center p-4">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-600">Pilih file media</p>
                                <p class="text-[11px] text-slate-400">Gambar &amp; Video · Maks. 50MB</p>
                            </div>
                        </div>

                        <!-- Selected state -->
                        <div id="gallery-selected" class="hidden flex-col items-center gap-2 p-4 text-center">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-slate-800" id="gallery-count">0 file dipilih</p>
                            <button type="button" id="clear-gallery-btn" class="text-[11px] text-rose-500 hover:text-rose-700 font-semibold underline transition-colors">Hapus pilihan</button>
                        </div>
                    </div>
                    @error('media.*')
                        <p class="text-xs text-rose-600 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Form Fields -->
            <div class="p-6 space-y-5">

                <!-- Author & Status Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Author (read-only) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Penulis</label>
                        <div class="flex items-center gap-2.5 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-[10px] font-bold uppercase shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-600">{{ Auth::user()->name }}</span>
                            <span class="ml-auto text-[10px] font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">Anda</span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5">
                        <label for="status" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Status Publikasi</label>
                        <div class="relative">
                            <select id="status" name="status"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/10 rounded-xl text-sm focus:outline-none appearance-none transition-all">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan)</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </div>
                        @error('status')
                            <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Scheduled Publish -->
                <div id="schedule-container" class="hidden space-y-1.5">
                    <label for="published_at" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Jadwal Terbit</label>
                    <input type="datetime-local" id="published_at" name="published_at"
                           value="{{ old('published_at') }}"
                           class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/10 rounded-xl text-sm focus:outline-none transition-all">
                    <p class="text-xs text-slate-400">Kosongkan untuk publikasi langsung. Isi untuk menjadwalkan.</p>
                    @error('published_at')
                        <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Judul Artikel</label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title') }}"
                           placeholder="Masukkan judul artikel yang menarik..."
                           class="w-full px-3 py-2.5 bg-white border @error('title') border-rose-300 focus:border-rose-400 focus:ring-rose-400/10 @else border-slate-200 focus:border-indigo-400 focus:ring-indigo-400/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all">
                    @error('title')
                        <p class="text-xs text-rose-600 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="space-y-1.5">
                    <label for="content" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Konten Artikel</label>
                    <textarea id="content" name="content" rows="9"
                              placeholder="Tuliskan isi artikel Anda di sini..."
                              class="w-full px-3 py-2.5 bg-white border @error('content') border-rose-300 focus:border-rose-400 focus:ring-rose-400/10 @else border-slate-200 focus:border-indigo-400 focus:ring-indigo-400/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all resize-y">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-xs text-rose-600 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <a href="{{ route('articles.index') }}"
                       class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-sm shadow-indigo-600/20 hover:shadow-md transition-all">
                        Simpan Artikel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Status → schedule toggle
    const statusEl = document.getElementById('status');
    const scheduleEl = document.getElementById('schedule-container');
    function toggleSchedule() {
        scheduleEl.classList.toggle('hidden', statusEl.value !== 'published');
    }
    statusEl.addEventListener('change', toggleSchedule);
    toggleSchedule();

    // Cover preview
    const coverInput   = document.getElementById('cover_image');
    const coverPlaceholder = document.getElementById('cover-placeholder');
    const coverWrap    = document.getElementById('cover-preview-wrap');
    const coverImg     = document.getElementById('cover-preview-img');
    const removeCover  = document.getElementById('remove-cover-btn');

    coverInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            coverImg.src = e.target.result;
            coverPlaceholder.classList.add('hidden');
            coverWrap.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    removeCover.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        coverInput.value = '';
        coverImg.src = '';
        coverPlaceholder.classList.remove('hidden');
        coverWrap.classList.add('hidden');
    });

    // Gallery preview
    const galleryInput     = document.getElementById('gallery_media');
    const galleryPlaceholder = document.getElementById('gallery-placeholder');
    const gallerySelected  = document.getElementById('gallery-selected');
    const galleryCount     = document.getElementById('gallery-count');
    const clearGallery     = document.getElementById('clear-gallery-btn');

    galleryInput.addEventListener('change', function () {
        const n = this.files.length;
        if (n > 0) {
            galleryCount.textContent = `${n} file dipilih`;
            galleryPlaceholder.classList.add('hidden');
            gallerySelected.classList.remove('hidden');
            gallerySelected.classList.add('flex');
        }
    });

    clearGallery.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        galleryInput.value = '';
        galleryPlaceholder.classList.remove('hidden');
        gallerySelected.classList.add('hidden');
        gallerySelected.classList.remove('flex');
    });
});
</script>
@endsection
