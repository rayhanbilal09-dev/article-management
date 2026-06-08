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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar for premium feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col md:flex-row">

    <!-- Mobile Header -->
    <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 md:hidden w-full sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5zm0 0h-3.75V4.5M10.5 7.5h.008v.008h-.008V7.5zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
            </div>
            <span class="font-extrabold text-lg tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Artiknesia</span>
        </div>
        <button id="mobile-menu-btn" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Sidebar Layout -->
    <aside id="sidebar" class="hidden md:flex flex-col w-full md:w-64 lg:w-72 bg-white border-r border-slate-200/80 h-auto md:h-screen sticky top-0 z-40 transition-all duration-300">
        <!-- Logo Header -->
        <div class="hidden md:flex items-center gap-3 px-8 py-7 border-b border-slate-100">
            <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30 transform hover:rotate-6 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5zm0 0h-3.75V4.5M10.5 7.5h.008v.008h-.008V7.5zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
            </div>
            <div>
                <span class="font-black text-xl tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Artiknesia</span>
                <span class="block text-[10px] text-slate-400 font-semibold tracking-wider uppercase">Portal Admin v1.0</span>
            </div>
        </div>

        <!-- Menu Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <!-- Section Header -->
            <p class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-3">Main Menu</p>

            <!-- Dashboard Link -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 shadow-sm shadow-indigo-600/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Users Link (Superadmin Only) -->
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('users.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm shadow-indigo-600/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span>Users</span>
                </a>
            @endif

            <!-- Articles Link -->
            <a href="{{ route('articles.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 group {{ request()->routeIs('articles.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm shadow-indigo-600/5' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('articles.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span>Articles</span>
            </a>

            <!-- Public Blog Link -->
            <hr class="my-3 border-slate-200" />
            <p class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-3">Public</p>
            <a href="{{ route('public.articles.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 group text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3.042.525A9.006 9.006 0 002.25 9m14.25-9h.008v.008h-.008V9m0 0A8.966 8.966 0 0112 21c4.486 0 8.268-2.977 9.75-7m.75.75v-2.008.008v2m0 0h.008v-.008h-.008v.008zM3 9.75h.008v.008H3V9.75zm14.25 0h.008v.008h-.008V9.75z" />
                </svg>
                <span>Lihat Blog Publik</span>
            </a>
        </nav>
                <span>Articles</span>
            </a>
        </nav>

        <!-- User Profile Card in Sidebar -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col gap-3">
            <div class="flex items-center gap-3 p-2 rounded-xl">
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm shadow-sm uppercase">
                        {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="min-w-0">
                    <span class="block text-sm font-semibold text-slate-800 truncate" title="{{ Auth::user()->name ?? 'Guest' }}">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </span>
                    <span class="block text-[10px] text-slate-400 font-medium truncate" title="{{ Auth::user()->email ?? '' }}">
                        {{ Auth::user()->email ?? '' }}
                    </span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-rose-100 text-xs font-bold text-rose-600 hover:bg-rose-50/60 transition-all duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Panel -->
    <main class="flex-1 flex flex-col min-h-screen md:h-screen md:overflow-y-auto">
        <!-- Top Sticky Header for Desktop -->
        <header class="hidden md:flex items-center justify-between px-8 py-5 bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span class="font-medium text-indigo-600">Admin Portal</span>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="font-semibold text-slate-700">
                    @if(request()->routeIs('dashboard'))
                        Dashboard
                    @elseif(request()->routeIs('users.*'))
                        Users
                    @elseif(request()->routeIs('articles.*'))
                        Articles
                    @else
                        Halaman
                    @endif
                </span>
            </div>

            <!-- Header Action Info -->
            <div class="flex items-center gap-4">
                <div class="px-3.5 py-1.5 rounded-full bg-indigo-50 text-xs font-semibold text-indigo-600 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-ping"></span>
                    Sistem Aktif
                </div>
            </div>
        </header>

        <!-- Main Body Area -->
        <div class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto space-y-6">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="flex items-center justify-between p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-sm animate-fade-in duration-300" role="alert" id="success-alert">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="p-1 rounded-lg text-emerald-600 hover:bg-emerald-100 transition-colors" onclick="document.getElementById('success-alert').remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center justify-between p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-100 shadow-sm animate-fade-in duration-300" role="alert" id="error-alert">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="p-1 rounded-lg text-rose-600 hover:bg-rose-100 transition-colors" onclick="document.getElementById('error-alert').remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Content Slot -->
            @yield('content')

        </div>
    </main>

    <!-- Mobile Navigation Toggle Script -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const menuIcon = document.getElementById('menu-icon');
            
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'absolute', 'top-[73px]', 'left-0', 'right-0', 'bg-white', 'border-b', 'border-slate-200', 'h-auto', 'shadow-xl');
                menuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'absolute', 'top-[73px]', 'left-0', 'right-0', 'bg-white', 'border-b', 'border-slate-200', 'h-auto', 'shadow-xl');
                menuIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            }
        });
    </script>
</body>
</html>
