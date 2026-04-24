<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pasien Dashboard') - UniHealth</title>

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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex">
    <aside class="w-[280px] bg-emerald-950 text-emerald-50 h-screen sticky top-0 flex flex-col shrink-0 z-50">
        <div class="px-8 py-8 flex items-center gap-4 border-b border-emerald-900/50">
            <div class="w-11 h-11 bg-emerald-500 rounded-[14px] flex items-center justify-center font-bold text-xl text-white">U</div>
            <span class="font-bold text-[24px] text-white">UniHealth</span>
        </div>
        
            <div class="px-0 py-8 flex-1 overflow-y-auto w-full">
            <nav class="space-y-1 w-full flex flex-col">
                <a href="{{ route('pasien.dashboard') }}" class="flex items-center gap-4 px-6 py-4 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white font-bold' : 'text-slate-100/70 hover:bg-slate-900/50 hover:text-white font-medium' }}">
                    Dashboard
                </a>
            
            <div class="px-6 mt-6 mb-2 text-xs font-bold text-emerald-500/50 uppercase tracking-widest leading-loose">Layanan Pasien</div>
            <a href="{{ route('pasien.buat-janji') }}" class="flex items-center gap-4 px-6 py-4 transition {{ request()->routeIs('pasien.buat-janji') ? 'bg-sidebar-active border-l-4 border-klinik-green text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white' }}">
                Buat Janji Temu
            </a>
            <a href="{{ route('pasien.riwayat') }}" class="flex items-center gap-4 px-6 py-4 transition {{ request()->routeIs('pasien.riwayat') ? 'bg-sidebar-active border-l-4 border-klinik-green text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white' }}">
                Riwayat Jadwal
            </a>
            <a href="{{ route('pasien.rekam-medis') }}" class="flex items-center gap-4 px-6 py-4 transition {{ request()->routeIs('pasien.rekam-medis') ? 'bg-sidebar-active border-l-4 border-klinik-green text-white font-bold' : 'text-emerald-100/70 hover:bg-emerald-900/40 hover:text-white' }}">
                Rekam Medis
            </a>
        </nav>
    </aside>

    <main class="flex-1 min-w-0 flex flex-col h-screen overflow-hidden">
        <div class="flex-1 overflow-y-auto bg-slate-50 p-8">
            <div class="max-w-[1200px] mx-auto animate-fade-in">
                @yield('content')
            </div>
        </div>
    </main>
</body>
</html>