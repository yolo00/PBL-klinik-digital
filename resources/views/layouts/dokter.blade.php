<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - UniHealth</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .sidebar-active { background: rgba(255, 255, 255, 0.15); border-left: 4px solid #10b981; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800">
    <div class="flex h-screen overflow-hidden">

        <aside class="w-72 bg-[#064e3b] flex flex-col h-full text-white">
            <div class="p-8">
                <img src="/path-to-logo/unihealth.png" alt="UniHealth" class="h-8">
            </div>
            
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scroll">
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('dokter.dashboard') ? 'sidebar-active' : 'hover:bg-white/5' }}">
                    <i class="fa-solid fa-grid-2"></i> Dashboard
                </a>
                <a href="{{ route('dokter.jadwal') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('dokter.jadwal') ? 'sidebar-active' : 'hover:bg-white/5' }}">
                    <i class="fa-solid fa-calendar-day"></i> Jadwal Saya
                </a>
                <a href="{{ route('dokter.pengaturan') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('dokter.pengaturan') ? 'sidebar-active' : 'hover:bg-white/5' }}">
                    <i class="fa-solid fa-clock"></i> Pengaturan Jadwal
                </a>
                <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('dokter.pasien') ? 'sidebar-active' : 'hover:bg-white/5' }}">
                    <i class="fa-solid fa-user-injured"></i> Pasien
                </a>
                <a href="{{ route('dokter.rekam-medis') }}" class="flex items-center gap-4 px-4 py-4 rounded-xl {{ request()->routeIs('dokter.rekam-medis') ? 'sidebar-active' : 'hover:bg-white/5' }}">
                    <i class="fa-solid fa-file-waveform"></i> Rekam Medis
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
            
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 px-8 py-4 flex justify-between items-center">
                <div></div>
                <a href="{{ route('dokter.profil') }}">
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">Dr. Fenni</p>
                        <p class="text-[10px] font-black text-emerald-500 uppercase">Dokter</p>
                    </div>
                    <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-400">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                </a>
            </header>

            <main class="flex-1 overflow-y-auto custom-scroll p-8 md:p-12">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
                
                <div class="h-20"></div>
            </main>
        </div>

    </div>

</body>
</html>