<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pasien Dashboard') - UniHealth</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Outfit', sans-serif; }

        .sidebar-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #4ed28e;
            color: #ffffff;
            font-weight: 700;
        }
        .sidebar-link {
            color: rgba(255,255,255,0.55);
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.10);
            color: #ffffff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="h-screen bg-slate-50 text-slate-800 flex overflow-hidden">

    <aside class="w-[280px] bg-emerald-950 text-emerald-50 h-screen sticky top-0 flex flex-col shrink-0 z-50">

        {{-- Logo --}}
        <a href="{{ route('pasien.dashboard') }}" class="px-8 py-8 flex items-center gap-4 border-b border-emerald-900/50 hover:bg-emerald-900/30 transition-all duration-300">
            <img src="{{ asset('images/logo.png') }}" alt="UniHealth Logo" class="w-11 h-11 md:w-[52px] md:h-[52px] rounded-xl shadow-sm border border-emerald-100 transition-transform duration-300 hover:scale-105 hover:-rotate-3">
            <span class="font-bold text-[24px] text-white">UniHealth</span>
        </a>

        <nav class="flex-1 py-8 px-4 space-y-1 overflow-y-auto">

            {{-- Home --}}
            <a href="{{ route('pasien.dashboard') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('pasien.dashboard') ? 'sidebar-active' : 'sidebar-link' }}">
                <i class="fa-solid fa-house w-5 text-center"></i>
                Home
            </a>

            {{-- Layanan --}}
            <div class="pt-5 pb-2 px-2 text-emerald-500/50">
                <span class="text-[11px] font-bold uppercase tracking-widest">Layanan Pasien</span>
            </div>

            <a href="{{ route('pasien.buat-janji') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('pasien.buat-janji') ? 'sidebar-active' : 'sidebar-link' }}">
                <i class="fa-solid fa-calendar-plus w-5 text-center"></i>
                Buat Janji Temu
            </a>
            <a href="{{ route('pasien.riwayat') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('pasien.riwayat') ? 'sidebar-active' : 'sidebar-link' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                Riwayat Jadwal
            </a>
            <a href="{{ route('pasien.rekam-medis') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('pasien.rekam-medis') || request()->routeIs('pasien.rekam-medis.detail') ? 'sidebar-active' : 'sidebar-link' }}">
                <i class="fa-solid fa-file-waveform w-5 text-center"></i>
                Rekam Medis
            </a>

        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- ===== HEADER (sticky, hijau medis) ===== -->
        <header class="h-[72px] bg-[#4ed28e] flex justify-between items-center px-10 shrink-0 sticky top-0 z-20">
            <p class="text-[15px] font-bold text-white">@yield('page-title', '')</p>

            <div class="relative group">
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="text-right">
                        <p class="text-[14px] font-bold text-white group-hover:text-emerald-50 transition">Aprillia Bunga</p>
                        <p class="text-[12px] text-emerald-900/70 font-semibold uppercase tracking-wide">Pasien</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/30 flex items-center justify-center text-white shadow-sm group-hover:ring-2 ring-white/40 transition">
                        <i class="fa-solid fa-user text-[15px]"></i>
                    </div>
                    <svg class="w-4 h-4 text-white ml-1 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="py-2 flex flex-col">
                        <a href="#" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                            <i class="fa-solid fa-user mr-2 text-slate-400"></i>Profil Saya
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-pasien').submit();"
                           class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                        </a>
                        <form id="logout-form-pasien" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>
                </div>
            </div>
        </header>
        <!-- ===== END HEADER ===== -->

        <main class="flex-1 overflow-y-auto bg-slate-50 p-8">
            <div class="max-w-[1200px] mx-auto animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>