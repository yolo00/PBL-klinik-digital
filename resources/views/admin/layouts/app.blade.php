<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - UniHealth</title>
    <!-- Direct link to pre-compiled Vite CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.98) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex">
    <!-- Sidebar -->
    <aside class="w-[280px] bg-slate-950 text-slate-50 h-screen sticky top-0 flex flex-col shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="px-8 py-8 flex items-center gap-4 border-b border-slate-900/50 hover:bg-slate-900/20 transition">
            <img src="https://placehold.co/100x100/64748b/ffffff?text=U" alt="Logo" class="w-11 h-11 rounded-[14px]">
            <span class="font-bold text-[24px] text-white">UniHealth</span>
        </a>
        
        <div class="px-0 py-8 flex-1 overflow-y-auto w-full">
            <nav class="space-y-1 w-full flex flex-col">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-6 py-4 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/50 hover:text-white font-medium' }}">
                    Dashboard
                </a>
                
                <div class="pt-4 pb-2 px-6 flex items-center justify-between text-slate-500/70">
                    <span class="text-[14px] font-bold">Manajemen</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <div class="pl-4 pr-0 flex flex-col">
                    <a href="{{ route('admin.pasien') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('admin.pasien') ? 'bg-slate-800/80 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/40 hover:text-white font-medium' }}">
                        Data Pasien
                    </a>
                    <a href="{{ route('admin.dokter') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('admin.dokter') ? 'bg-slate-800/80 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/40 hover:text-white font-medium' }}">
                        Data Dokter
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('admin.jadwal') ? 'bg-slate-800/80 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/40 hover:text-white font-medium' }}">
                        Data Jadwal
                    </a>
                    <a href="{{ route('admin.rekam-medis') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('admin.rekam-medis') ? 'bg-slate-800/80 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/40 hover:text-white font-medium' }}">
                        Data Rekam Medis
                    </a>
                    <a href="{{ route('admin.pembayaran') }}" class="w-full flex items-center gap-4 pl-6 pr-4 py-4 transition-all {{ request()->routeIs('admin.pembayaran') ? 'bg-slate-800/80 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/40 hover:text-white font-medium' }}">
                        Data Pembayaran
                    </a>
                </div>

                <div class="pt-4">
                    <a href="#" class="flex items-center gap-4 px-6 py-4 transition-all text-slate-100/70 hover:bg-slate-900/50 hover:text-white font-medium">
                        Pengaturan Sistem
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden relative">
        <header class="h-[80px] flex justify-end items-center px-10 shrink-0 sticky top-0 z-20">
            <div class="relative group">
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="text-right">
                        <p class="text-[14px] font-bold text-slate-800 group-hover:text-slate-600 transition">Michael Admin</p>
                        <p class="text-[13px] text-slate-600 font-semibold">Admin</p>
                    </div>
                    <img src="https://placehold.co/100x100/475569/ffffff?text=MA" alt="Admin Profile" class="w-10 h-10 rounded-full shadow-sm group-hover:ring-2 ring-slate-500/30 transition">
                    <svg class="w-4 h-4 text-slate-500 ml-1 transition group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="py-2 flex flex-col">
                        <a href="#" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-600 transition">See Profile</a>
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
        </main>
    </div>
</body>
</html>
