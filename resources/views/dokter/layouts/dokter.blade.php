<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - UniHealth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .sidebar { background: linear-gradient(180deg, #1a3a6b 0%, #1e4d8c 60%, #1565c0 100%); }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; border-radius: 10px;
            color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 500;
            transition: all 0.2s ease; margin-bottom: 2px; text-decoration: none;
        }
        .nav-item:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.18); color: #fff; font-weight: 600; }
        .nav-icon { width: 18px; text-align: center; font-size: 15px; }
        .top-header { background: linear-gradient(90deg, #1565c0 0%, #1976d2 100%); }
        .stat-card { background:#fff; border-radius:14px; padding:20px 22px; border:1px solid #e8f0fe; transition:box-shadow 0.2s; }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(21,101,192,0.10); }
        .stat-icon { width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:17px; margin-bottom:14px; }
        .data-table thead tr { background: #f0f4ff; }
        .data-table thead th { padding:12px 16px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:#5c7aaa; }
        .data-table tbody td { padding:14px 16px; font-size:13px; color:#334155; border-bottom:1px solid #f1f5fb; }
        .data-table tbody tr:hover { background: #f8faff; }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .badge-menunggu   { background:#fff8e1; color:#f59e0b; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-konfirmasi { background:#e3f2fd; color:#1976d2; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-selesai    { background:#e8f5e9; color:#388e3c; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-batal      { background:#fce4ec; color:#e53935; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .cal-day { width:32px; height:32px; display:flex; align-items:center; justify-content:center; border-radius:8px; font-size:13px; font-weight:500; color:#475569; }
        .cal-day.today { background:#1565c0; color:#fff; font-weight:700; }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-thumb { background:rgba(21,101,192,0.2); border-radius:10px; }
    </style>
</head>
<body class="bg-[#f0f4f8] text-slate-800">
<div class="flex h-screen overflow-hidden">

    <aside class="sidebar w-[280px] h-screen sticky top-0 flex flex-col shrink-0 z-50">
        <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-8 py-8 border-b border-white/10">
            <img src="{{ asset('images/logo.png') }}" alt="UniHealth Logo"
                class="w-11 h-11 rounded-xl shadow-sm border border-blue-100">
            <span class="text-white font-bold text-[24px]">UniHealth</span>
        </a>

        <nav class="flex-1 px-4 py-5 overflow-y-auto">
            <a href="{{ route('dokter.dashboard') }}" class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span> Dashboard
            </a>

            <div class="pt-4 pb-1.5 px-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-white/30">Manajemen</span>
            </div>

            <a href="{{ route('dokter.jadwal') }}" class="nav-item {{ request()->routeIs('dokter.jadwal') || request()->routeIs('dokter.jadwal.buat-rekam') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span> Jadwal Saya
            </a>
            <a href="{{ route('dokter.pengaturan') }}" class="nav-item {{ request()->routeIs('dokter.pengaturan') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-sliders"></i></span> Pengaturan Jadwal
            </a>
            <a href="{{ route('dokter.pasien') }}" class="nav-item {{ request()->routeIs('dokter.pasien') || request()->routeIs('dokter.rekam.riwayat') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-user-injured"></i></span> Pasien Saya
            </a>
            <a href="{{ route('dokter.rekam-medis') }}" class="nav-item {{ request()->routeIs('dokter.rekam-medis') || request()->routeIs('dokter.rekam.show') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-notes-medical"></i></span> Rekam Medis
            </a>
        </nav>

        <div class="px-4 pb-6 border-t border-white/10 pt-4">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-dokter').submit();"
               class="nav-item text-red-300 hover:!bg-red-500/20 hover:!text-red-200">
                <span class="nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span> Keluar
            </a>
        </div>
        <form id="logout-form-dokter" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
        <header class="top-header h-[72px] flex items-center justify-between px-10 shrink-0 sticky top-0 z-20 shadow-sm">
            <p class="text-white/70 text-xs font-medium">@yield('breadcrumb', 'UniHealth — Sistem Manajemen Klinik')</p>
            <div class="flex items-center gap-4">
                <button class="relative w-9 h-9 rounded-full bg-white/15 flex items-center justify-center text-white hover:bg-white/25 transition">
                    <i class="fa-solid fa-bell text-sm"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-400 rounded-full border border-blue-700"></span>
                </button>
                <div class="relative group flex items-center gap-3 cursor-pointer">
                    <div class="text-right">
                        <p class="text-white font-semibold text-sm leading-tight">{{ auth()->user()->nama ?? 'Dokter' }}</p>
                        <p class="text-blue-200 text-[11px] font-medium uppercase tracking-wide">Dokter</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-white border-2 border-white/30">
                        <i class="fa-solid fa-user-doctor text-sm"></i>
                    </div>
                    <div class="absolute right-0 top-full mt-2 w-44 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
                        <div class="py-1.5">
                            <a href="{{ route('dokter.profil') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                <i class="fa-solid fa-user text-slate-400 w-4"></i> Profil Saya
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-dokter').submit();"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @if(session('success'))
        <div class="mx-8 mt-5 px-5 py-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center gap-2.5">
            <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mx-8 mt-5 px-5 py-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium flex items-center gap-2.5">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i> {{ session('error') }}
        </div>
        @endif

        <main class="flex-1 overflow-y-auto p-8 md:p-12">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
