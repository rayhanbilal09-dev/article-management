@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in duration-300">
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
            <p class="text-slate-500 mt-1 text-sm">Sesuaikan konten, status, jadwal publikasi, atau kelola media artikel ini.</p>
        </div>
    </div>

    <!-- Main Form Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Form Fields -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6">
                <form id="edit-article-form" action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                            rows="10"
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

            <!-- Gallery Media Manager -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Galeri Media Artikel</h3>
                    <p class="text-slate-500 text-xs mt-0.5">Kelola gambar & video pendukung artikel ini. Seret / ubah urutan media sesuka Anda.</p>
                </div>

                <!-- Media Upload form (direct upload) -->
                <form id="upload-media-form" action="{{ route('articles.media.upload', $article->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-200/50">
                    @csrf
                    <div class="flex-1 w-full relative">
                        <input type="file" name="media[]" id="gallery_media" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*,video/*" multiple>
                        <div class="w-full px-4 py-2.5 bg-white border border-slate-250 rounded-xl text-sm text-slate-500 flex items-center justify-between pointer-events-none">
                            <span id="gallery-file-label">Pilih file tambahan...</span>
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        </div>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-indigo-600/10">
                        Unggah
                    </button>
                </form>

                <!-- Media Items Grid -->
                <div id="media-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($article->media as $media)
                        <div id="media-card-{{ $media->id }}" data-id="{{ $media->id }}" class="media-card group flex flex-col bg-slate-50 border border-slate-200/60 rounded-2xl overflow-hidden p-3 space-y-3 relative hover:border-indigo-300 transition-all">
                            
                            <!-- Media Preview Wrapper -->
                            <div class="aspect-video w-full bg-slate-900 rounded-xl overflow-hidden relative">
                                @if($media->type === 'image')
                                    <img src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover" alt="Media image">
                                @else
                                    <video src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover" controls preload="metadata"></video>
                                @endif

                                <!-- Media Type Badge -->
                                <span class="absolute top-2 left-2 px-2 py-0.5 bg-black/60 backdrop-blur-sm text-white rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    {{ $media->type }}
                                </span>

                                <!-- Cover Image Indicator -->
                                <span id="cover-badge-{{ $media->id }}" class="cover-badge absolute top-2 right-2 px-2.5 py-0.5 bg-emerald-600 text-white rounded-full text-[10px] font-bold uppercase tracking-wider {{ $article->cover_image === $media->file_path ? '' : 'hidden' }}">
                                    Cover
                                </span>
                            </div>

                            <!-- Caption Input -->
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterangan / Caption</label>
                                <div class="relative flex items-center">
                                    <input 
                                        type="text" 
                                        value="{{ $media->caption }}" 
                                        placeholder="Tulis caption..." 
                                        onblur="saveCaption({{ $media->id }}, this.value)"
                                        class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-indigo-500 transition-colors pr-8">
                                    <span id="saving-indicator-{{ $media->id }}" class="absolute right-2.5 hidden">
                                        <svg class="animate-spin h-3.5 w-3.5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Controls -->
                            <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                                <div class="flex items-center gap-1.5">
                                    @if($media->type === 'image')
                                        <button type="button" onclick="setAsCover({{ $media->id }})" class="px-2.5 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-650 text-[11px] font-semibold rounded-lg transition-colors flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                            Cover
                                        </button>
                                    @endif
                                    
                                    <!-- Reorder Arrows -->
                                    <button type="button" onclick="moveMedia({{ $media->id }}, 'up')" class="p-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-500 rounded-lg transition-colors" title="Geser Kiri/Atas">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                                    </button>
                                    <button type="button" onclick="moveMedia({{ $media->id }}, 'down')" class="p-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-500 rounded-lg transition-colors" title="Geser Kanan/Bawah">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                    </button>
                                </div>

                                <button type="button" onclick="deleteMedia({{ $media->id }})" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition-colors" title="Hapus Media">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div id="no-media-alert" class="col-span-full py-8 text-center text-slate-400 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center gap-1.5">
                            <svg class="w-8 h-8 text-slate-350" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            <span class="text-xs font-semibold">Belum ada media di artikel ini</span>
                            <span class="text-[10px]">Gunakan input di atas untuk mengunggah media.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Settings, Cover & Status -->
        <div class="space-y-6">
            
            <!-- Cover Image Preview Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-800">Cover Image</h3>
                
                <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-slate-50 border border-slate-200">
                    <div id="cover-preview-placeholder" class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center {{ $article->cover_image ? 'hidden' : '' }}">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        <p class="text-xs text-slate-400">Belum ada cover. Pilih dari galeri di kiri atau upload via form edit di bawah.</p>
                    </div>

                    <div id="cover-preview-container" class="w-full h-full {{ $article->cover_image ? '' : 'hidden' }}">
                        <img id="cover-preview-img" src="{{ $article->cover_image ? asset('storage/' . $article->cover_image) : '' }}" class="w-full h-full object-cover" alt="Article Cover">
                        <button type="button" onclick="removeCover()" class="absolute top-3 right-3 p-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg shadow-md hover:scale-105 active:scale-95 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Fast upload cover input inside main form action -->
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Unggah Cover Baru</label>
                    <input 
                        type="file" 
                        name="cover_image" 
                        form="edit-article-form"
                        accept="image/*"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                </div>
            </div>

            <!-- Publishing Settings Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-800">Publishing Settings</h3>

                <!-- Author (Superadmin Only) -->
                @if(Auth::user()->isSuperAdmin())
                    <div class="space-y-2">
                        <label for="user_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Penulis (Author)</label>
                        <div class="relative">
                            <select 
                                id="user_id"
                                name="user_id" 
                                form="edit-article-form"
                                class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-indigo-500 rounded-xl text-xs focus:outline-none appearance-none transition-colors">
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
                    </div>
                @endif

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <div class="relative">
                        <select 
                            id="status"
                            name="status" 
                            form="edit-article-form"
                            class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-indigo-500 rounded-xl text-xs focus:outline-none appearance-none transition-colors">
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft (Simpan Internal)</option>
                            <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Scheduled Publish -->
                <div id="schedule-container" class="space-y-2 hidden">
                    <label for="published_at" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Jadwal Publikasi</label>
                    <input 
                        type="datetime-local" 
                        id="published_at"
                        name="published_at" 
                        form="edit-article-form"
                        value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-indigo-500 rounded-xl text-xs focus:outline-none transition-all">
                    <p class="text-[10px] text-slate-400 leading-normal">Ubah tanggal untuk menjadwalkan artikel ini di masa mendatang.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts for interactive Media Gallery and Dynamic Status Layouts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status select layout toggle
        const statusSelect = document.getElementById('status');
        const scheduleContainer = document.getElementById('schedule-container');

        function toggleSchedule() {
            if (statusSelect.value === 'published') {
                scheduleContainer.classList.remove('hidden');
            } else {
                scheduleContainer.classList.add('hidden');
            }
        }

        statusSelect.addEventListener('change', toggleSchedule);
        toggleSchedule();

        // Label update for gallery media upload form
        const galleryInput = document.getElementById('gallery_media');
        const labelText = document.getElementById('gallery-file-label');
        
        galleryInput.addEventListener('change', function(e) {
            const count = e.target.files.length;
            if (count > 0) {
                labelText.textContent = `${count} file terpilih`;
            } else {
                labelText.textContent = 'Pilih file tambahan...';
            }
        });
    });

    // Save caption via AJAX PUT
    function saveCaption(mediaId, caption) {
        const spinner = document.getElementById(`saving-indicator-${mediaId}`);
        if(spinner) spinner.classList.remove('hidden');

        fetch(`/media/${mediaId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ caption: caption })
        })
        .then(res => {
            if (!res.ok) throw new Error();
            return res.json();
        })
        .catch(() => alert('Gagal menyimpan caption'))
        .finally(() => {
            if(spinner) spinner.classList.add('hidden');
        });
    }

    // Set existing image as cover via AJAX
    function setAsCover(mediaId) {
        fetch(`/articles/{{ $article->id }}/set-cover`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ media_id: mediaId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove Cover badge from all other media items
                document.querySelectorAll('.cover-badge').forEach(badge => badge.classList.add('hidden'));
                
                // Show Cover badge on this item
                const activeBadge = document.getElementById(`cover-badge-${mediaId}`);
                if (activeBadge) activeBadge.classList.remove('hidden');

                // Update Cover Preview Card
                const previewImg = document.getElementById('cover-preview-img');
                const previewContainer = document.getElementById('cover-preview-container');
                const placeholder = document.getElementById('cover-preview-placeholder');

                if (data.cover_image_url) {
                    previewImg.src = data.cover_image_url;
                    previewContainer.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
            } else {
                alert(data.error || 'Gagal mengatur cover');
            }
        })
        .catch(() => alert('Gagal mengatur cover'));
    }

    // Remove cover image via AJAX
    function removeCover() {
        if (!confirm('Apakah Anda yakin ingin menghapus cover image?')) return;

        fetch(`/articles/{{ $article->id }}/set-cover`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ media_id: null })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.cover-badge').forEach(badge => badge.classList.add('hidden'));
                document.getElementById('cover-preview-container').classList.add('hidden');
                document.getElementById('cover-preview-placeholder').classList.remove('hidden');
                document.getElementById('cover-preview-img').src = '';
            }
        })
        .catch(() => alert('Gagal menghapus cover'));
    }

    // Delete media item via AJAX
    function deleteMedia(mediaId) {
        if (!confirm('Apakah Anda yakin ingin menghapus file media ini secara permanen?')) return;

        fetch(`/media/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const card = document.getElementById(`media-card-${mediaId}`);
                card.remove();

                // Check if grid is empty now
                const grid = document.getElementById('media-grid');
                if (grid.querySelectorAll('.media-card').length === 0) {
                    grid.innerHTML = `
                        <div id="no-media-alert" class="col-span-full py-8 text-center text-slate-400 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center gap-1.5">
                            <svg class="w-8 h-8 text-slate-350" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            <span class="text-xs font-semibold">Belum ada media di artikel ini</span>
                            <span class="text-[10px]">Gunakan input di atas untuk mengunggah media.</span>
                        </div>
                    `;
                }
            }
        })
        .catch(() => alert('Gagal menghapus media'));
    }

    // Move media item in DOM & Save Order via AJAX
    function moveMedia(mediaId, direction) {
        const card = document.getElementById(`media-card-${mediaId}`);
        if (!card) return;

        if (direction === 'up') {
            const prev = card.previousElementSibling;
            if (prev && prev.classList.contains('media-card')) {
                card.parentNode.insertBefore(card, prev);
                saveOrder();
            }
        } else if (direction === 'down') {
            const next = card.nextElementSibling;
            if (next && next.classList.contains('media-card')) {
                card.parentNode.insertBefore(next, card);
                saveOrder();
            }
        }
    }

    // Send order layout to database
    function saveOrder() {
        const cards = document.querySelectorAll('.media-card');
        const order = Array.from(cards).map(card => card.dataset.id);

        fetch(`/articles/{{ $article->id }}/media/reorder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order: order })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) alert('Gagal menyimpan urutan media');
        })
        .catch(() => alert('Gagal menyimpan urutan media'));
    }
</script>
@endsection