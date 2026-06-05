<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Artiknesia Portal</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex items-center justify-center p-4 relative overflow-hidden bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-50/50 via-slate-50 to-slate-100/50">

    <!-- Decorative glowing blobs -->
    <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-indigo-200/30 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-violet-200/30 blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-[460px] space-y-6 relative z-10 animate-fade-in duration-300">
        
        <!-- Brand logo center -->
        <div class="flex flex-col items-center justify-center text-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-xl shadow-indigo-600/20">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5zm0 0h-3.75V4.5M10.5 7.5h.008v.008h-.008V7.5zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Buat Akun Portal</h1>
                <p class="text-slate-450 text-xs font-semibold mt-1 uppercase tracking-wider">Register to access administrative tools</p>
            </div>
        </div>

        <!-- Form register card -->
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200/60 rounded-3xl p-8 shadow-xl shadow-slate-100/80">
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name Input -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold text-slate-700">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        placeholder="Nama lengkap Anda..."
                        class="w-full px-4 py-2.5 bg-white/80 border @error('name') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">
                    @error('name')
                        <p class="text-xs font-semibold text-rose-600 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-slate-700">Alamat Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 bg-white/80 border @error('email') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 transition-all duration-200">
                    @error('email')
                        <p class="text-xs font-semibold text-rose-600 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Minimal 6 karakter..."
                        class="w-full px-4 py-2.5 bg-white/80 border @error('password') border-rose-350 focus:border-rose-500 focus:ring-rose-500/10 @else border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/10 @enderror rounded-xl text-sm placeholder-slate-450 focus:outline-none focus:ring-2 transition-all duration-200">
                    @error('password')
                        <p class="text-xs font-semibold text-rose-600 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Confirmation Input -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        placeholder="Ulangi password..."
                        class="w-full px-4 py-2.5 bg-white/80 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/10 rounded-xl text-sm placeholder-slate-450 focus:outline-none focus:ring-2 transition-all duration-200">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-855 text-white font-bold text-sm shadow-lg shadow-indigo-600/15 hover:shadow-xl hover:shadow-indigo-600/25 transition-all duration-150 mt-4">
                    Mendaftar Sekarang
                </button>
            </form>
        </div>

        <!-- Footer link -->
        <p class="text-center text-xs text-slate-500 font-semibold">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 hover:underline transition-all">Masuk Akun</a>
        </p>

    </div>

</body>
</html>
