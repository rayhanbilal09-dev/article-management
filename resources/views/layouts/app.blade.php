<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Article Management') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-page-in { animation: fadeSlideIn 0.3s ease forwards; }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col md:flex-row">

    <!-- Mobile Header -->
    <header class="flex items-center justify-between px-5 py-3.5 bg-white border-b border-slate-200 md:hidden w-full sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-md">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5zm0 0h-3.75V4.5" />
                </svg>
            </div>
            <span class="font-black text-base tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Artiknesia</span>
        </div>
        <button id="mobile-menu-btn" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="hidden md:flex flex-col w-64 lg:w-72 bg-white border-r border-slate-100 h-screen sticky top-0 z-40 shrink-0">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5zm0 0h-3.75V4.5" />
                </svg>
            </div>
            <div>
                <span class="font-black text-lg tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent block leading-none">Artiknesia</span>
                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Admin Portal</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
            <p class="px-3 mb-2 text-[10px] font-bold tracking-widest text-slate-400 uppercase">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200' }} transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </span>
                Dashboard
            </a>

            @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 group {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('users.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200' }} transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </span>
                Pengguna
            </a>

            <a href="{{ route('allowed-words.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 group {{ request()->routeIs('allowed-words.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('allowed-words.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200' }} transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                Kata Whitelist
            </a>

            <a href="{{ route('reports.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 group {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('reports.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200' }} transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a1 1 0 00.764-.97V4.34a1 1 0 00-1.236-.971l-2.22.522a9 9 0 01-6.108-.683l-.108-.054a9 9 0 00-6.086-.71L3 4.5M3 15V4.5" />
                    </svg>
                </span>
                Laporan Komentar
            </a>
            @endif

            <a href="{{ route('articles.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 group {{ request()->routeIs('articles.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('articles.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200' }} transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </span>
                Artikel
            </a>

            <div class="pt-4">
                <p class="px-3 mb-2 text-[10px] font-bold tracking-widest text-slate-400 uppercase">Publik</p>
                <a href="{{ route('public.articles.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-150 text-slate-600 hover:bg-slate-50 hover:text-slate-900 group">
                    <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 group-hover:bg-slate-200 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12c0 .778.099 1.533.284 2.253" />
                        </svg>
                    </span>
                    Blog Publik
                    <svg class="w-3 h-3 ml-auto text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </nav>

        <!-- User Profile -->
        <div class="p-3 border-t border-slate-100">
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                <div class="relative shrink-0">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-bold text-xs uppercase shadow-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="min-w-0 flex-1">
                    <span class="block text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <span class="block text-xs text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-h-screen md:h-screen md:overflow-y-auto">
        <!-- Top Bar -->
        <div class="hidden md:flex items-center gap-2 px-8 py-4 bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30">
            <span class="text-xs font-semibold text-indigo-500 uppercase tracking-wider">Admin</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-sm font-semibold text-slate-700">
                @if(request()->routeIs('dashboard')) Dashboard
                @elseif(request()->routeIs('users.*')) Pengguna
                @elseif(request()->routeIs('articles.create')) Tulis Artikel
                @elseif(request()->routeIs('articles.edit')) Edit Artikel
                @elseif(request()->routeIs('articles.show')) Detail Artikel
                @elseif(request()->routeIs('articles.*')) Artikel
                @elseif(request()->routeIs('allowed-words.*')) Kata Whitelist
                @elseif(request()->routeIs('reports.*')) Laporan Komentar
                @else Halaman
                @endif
            </span>
        </div>

        <!-- Page Content -->
        <div class="flex-1 p-5 md:p-8 max-w-7xl w-full mx-auto space-y-6 animate-page-in">

            <!-- Flash Messages -->
            @if(session('success'))
                <div id="flash-success" class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium shadow-sm" role="alert">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').remove()" class="shrink-0 text-emerald-600 hover:text-emerald-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div id="flash-error" class="flex items-center gap-3 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium shadow-sm" role="alert">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span class="flex-1">{{ session('error') }}</span>
                    <button onclick="document.getElementById('flash-error').remove()" class="shrink-0 text-rose-600 hover:text-rose-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('menu-icon');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'absolute', 'top-[57px]', 'left-0', 'right-0', 'h-auto', 'shadow-xl', 'border-b', 'border-slate-200');
                icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'absolute', 'top-[57px]', 'left-0', 'right-0', 'h-auto', 'shadow-xl', 'border-b', 'border-slate-200');
                icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            }
        });
    </script>
</body>
</html>
