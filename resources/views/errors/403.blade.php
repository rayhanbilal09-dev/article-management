<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-50">
    <div class="max-w-md w-full mx-auto px-6 text-center space-y-6">
        <div class="space-y-3">
            <div class="inline-block p-4 rounded-2xl bg-red-100">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c.866 1.5 2.926 2.875 5.303 2.875s4.437-1.375 5.303-2.875M3.75 4.5h16.5M12 15h.008v.008H12V15Z" />
                </svg>
            </div>
            <h1 class="text-4xl font-black text-slate-900">403</h1>
            <h2 class="text-2xl font-bold text-slate-800">Akses Ditolak</h2>
        </div>

        <p class="text-slate-600 text-lg">
            Anda tidak memiliki izin untuk mengakses halaman ini. Hubungi administrator jika Anda merasa ini adalah kesalahan.
        </p>

        <div class="flex gap-3">
            <a href="{{ route('dashboard') }}" class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                Kembali ke Dashboard
            </a>
            <a href="{{ route('public.articles.index') }}" class="flex-1 px-4 py-3 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold rounded-lg transition-colors">
                Lihat Artikel Publik
            </a>
        </div>
    </div>
</body>
</html>
