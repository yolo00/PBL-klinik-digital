<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Dope Ass Wizard Hat                           -->
    <!--                 0*
                       /|\
                      / | \
                     /  *  \
                    / .*.*. \
                   / .*.*.*. \
                  /  .*.*.*  \
                 / .*.*.*.*.  \
                / .*.*.*.*.*.. \
               /  .*. ☆  .*.*  \
              / .*.*.*.  *.*.*.. \
             / .*.*. ✦ ✦ .*.*.*..\
            /  .*.✧   ☆    ✧.*.*  \___
           /______________________________\
    ,,----/________________________________\---------,,,,
--`|                                                    |;;====
----\___________________________________________________/
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - UniHealth</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.98) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .sidebar-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid rgb(14, 63, 146);
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
    </style>
</head>
<body class="h-screen bg-slate-50 text-slate-800 flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-[280px] bg-slate-950 text-slate-50 h-screen sticky top-0 flex flex-col shrink-0 z-50">

        {{-- Logo --}}
        <a href="{{ route('admin.dashboard') }}" class="px-8 py-8 flex items-center gap-4 border-b border-slate-900/50 hover:bg-slate-900/30 transition-all duration-300">
            <img src="{{ asset('images/logo.png') }}" alt="UniHealth Logo" class="w-11 h-11 md:w-[52px] md:h-[52px] rounded-xl shadow-sm border border-slate-600 transition-transform duration-300 hover:scale-105 hover:-rotate-3">
            <span class="font-bold text-[24px] text-white">UniHealth</span>
        </a>

        <div class="py-8 flex-1 overflow-y-auto w-full">
            <nav class="space-y-1 w-full flex flex-col px-4">

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid w-5 shrink-0 text-center"></i>
                    Dashboard
                </a>

                {{-- Manajemen --}}
                <div class="pt-5 pb-2 px-2 flex items-center justify-between text-slate-500/70">
                    <span class="text-[11px] font-bold uppercase tracking-widest">Manajemen</span>
                </div>

                <a href="{{ route('admin.pasien.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.pasien*') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-user-injured w-5 text-center"></i>
                    Data Pasien
                </a>
                <a href="{{ route('admin.dokter.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.dokter*') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-user-doctor w-5 text-center"></i>
                    Data Dokter
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.jadwal.index') || request()->routeIs('admin.jadwal.create') || request()->routeIs('admin.jadwal.show') || request()->routeIs('admin.jadwal.edit') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-calendar-day w-5 text-center"></i>
                    Data Jadwal
                </a>
                <a href="{{ route('admin.rekam-medis.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.rekam-medis*') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-file-waveform w-5 text-center"></i>
                    Data Rekam Medis
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.pembayaran*') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-money-bill-wave w-5 text-center"></i>
                    Data Pembayaran
                </a>

                {{-- Sistem --}}
                <div class="pt-5 pb-2 px-2 text-slate-500/70">
                    <span class="text-[11px] font-bold uppercase tracking-widest">Sistem</span>
                </div>

                <a href="{{ route('admin.jadwal-sistem') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('admin.jadwal-sistem') || request()->routeIs('admin.cuti-dokter*') ? 'sidebar-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-sliders w-5 shrink-0 text-center"></i>
                    Jadwal Sistem
                </a>

            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <!-- ===== HEADER (sticky, lighter slate) ===== -->
        <header class="h-[72px] bg-slate-100 border-b border-slate-200 flex justify-end items-center px-10 shrink-0 sticky top-0 z-20">
            <div class="relative group">
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="text-right">
                        <p class="text-[14px] font-bold text-slate-800 group-hover:text-slate-600 transition">Michael Admin</p>
                        <p class="text-[12px] text-slate-500 font-semibold uppercase tracking-wide">Admin</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-300 flex items-center justify-center text-slate-600 shadow-sm group-hover:ring-2 ring-slate-400/40 transition">
                        <i class="fa-solid fa-user text-[15px]"></i>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="py-2 flex flex-col">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();"
                           class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                        </a>
                        <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>
                </div>
            </div>
        </header>
        <!-- ===== END HEADER ===== -->

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-slate-50 p-8 md:p-10 relative">
            <div class="relative z-10 w-full max-w-[1200px] mx-auto animate-fade-in">

                @if(session('success'))
                    <div class="mb-6 px-5 py-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-[14px] text-[14px] font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 px-5 py-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-[14px] text-[14px] font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>