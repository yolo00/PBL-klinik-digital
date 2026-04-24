<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< Updated upstream
    <title>@yield('title', config('app.name'))</title>

    <!-- Direct link to pre-compiled Vite CSS to avoid XAMPP path and CDN network issues -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <style>
=======
    <title>UniHealth</title>

    <!-- Direct link to pre-compiled Vite CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
        <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'klinik-blue': '#3B98E8',
                        'klinik-green': '#68C96A',
                        'sidebar-dark': '#01291E',
                        'sidebar-active': '#034534',
                        'klinik-bg': '#F6F6F6',
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
>>>>>>> Stashed changes
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.98) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>
<<<<<<< Updated upstream
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen bg-gradient-to-b from-sky-50 via-white to-slate-100">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='%23047f52'/%3E%3Cpath d='M32 18a10 10 0 110 20 10 10 0 010-20zm0 26c-7.18 0-13 5.82-13 13h26c0-7.18-5.82-13-13-13z' fill='%23eff6ff'/%3E%3C/svg%3E" alt="Logo" class="h-14 w-14 rounded-2xl bg-white p-2 shadow-sm">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">UniHealth</p>
                        <p class="text-lg font-bold text-slate-900">Klinik Digital</p>
                    </div>
                </a>
                <nav class="flex items-center gap-4 text-sm font-medium text-slate-700">
                    <a href="{{ route('home') }}" class="text-slate-900 hover:text-sky-600">Beranda</a>
                    <a href="{{ route('about') }}" class="hover:text-sky-600">Tentang</a>
                    <a href="{{ route('contact') }}" class="hover:text-sky-600">Kontak</a>
                    <a href="{{ route('register') }}" class="rounded-full border border-emerald-600 px-4 py-2 text-emerald-600 hover:bg-emerald-50">Daftar</a>
                    <a href="{{ route('login') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Masuk</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-10 animate-fade-in">
            @yield('content')
=======
<body class="min-h-screen bg-slate-50 text-slate-800 flex">
    <!-- Sidebar -->
    <aside class="w-[280px] bg-emerald-950 text-emerald-50 h-screen sticky top-0 flex flex-col shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="px-8 py-8 flex items-center gap-4 border-b border-emerald-900/50 hover:bg-emerald-900/20 transition">
            <img src="https://placehold.co/100x100/10b981/ffffff?text=U" alt="Logo" class="w-11 h-11 rounded-[14px]">
            <span class="font-bold text-[24px] text-white">UniHealth</span>
        </a>
        
        <div class="px-0 py-8 flex-1 overflow-y-auto w-full">
            <nav class="space-y-1 w-full flex flex-col">
                <a href="{{ route('pasien.dashboard') }}"class="flex items-center gap-4 pl-6 pr-4 py-4 transition {{ request()->routeIs('pasien.dashboard') ? 'bg-sidebar-active border-l-4 border-klinik-green text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white font-medium' }}">
                        Dashboard
                </a>              
                <div class="pt-4 pb-2 px-6 flex items-center justify-between text-emerald-500/70">
                    <span class="text-[14px] font-bold">Layanan Pasien</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <div class="pl-4 pr-0 flex flex-col">
                    <a href="{{ route('pasien.buat-janji') }}" class="flex items-center gap-4 pl-6 pr-4 py-4 transition {{ request()->routeIs('pasien.buat-janji') ? 'bg-sidebar-active border-l-4 border-klinik-green text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white font-medium' }}">
                        Buat Janji Temu
                    </a>
                    <a href="{{ route('pasien.riwayat') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('pasien.riwayat') ? 'bg-emerald-800/80 text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white font-medium' }}">
                        Riwayat Jadwal
                    </a>
                    <a href="{{ route('pasien.rekam-medis') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('pasien.rekam-medis') ? 'bg-emerald-800/80 text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white font-medium' }}">
                        Riwayat Rekam Medis
                    </a>               
                </div>
            </nav>
        </div>
    </aside>
                
                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="py-2 flex flex-col">
                        <a href="#" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">See Profile</a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition">Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8 md:p-10 relative">
            <div class="relative z-10 w-full max-w-[1200px] mx-auto animate-fade-in">
                @yield('content')
            </div>
>>>>>>> Stashed changes
        </main>
    </div>
</body>
</html>
