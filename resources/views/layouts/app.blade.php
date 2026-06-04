<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda - UniHealth</title>
    <!-- Direct link to pre-compiled Vite CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Home */
        .fade-in {
            opacity: 0;
            animation: fadeInUp 0.65s ease-out forwards;
        }

        .fade-in-1 { animation-delay: 0.05s; }
        .fade-in-2 { animation-delay: 0.20s; }
        .fade-in-3 { animation-delay: 0.35s; }
        .fade-in-4 { animation-delay: 0.50s; }

        /* About */
        .animate-fade-in-up {
            animation: fadeInUp 0.7s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
    </style>
</head>
<body class="bg-white text-slate-800">

<!-- Navbar -->
<header class="w-full bg-white sticky top-0 z-50 shadow-sm border-b border-emerald-100">

    <div class="flex items-center justify-between px-8 py-4 w-full max-w-[1500px] mx-auto">

        <a href="{{ route('home') }}"
           class="flex items-center gap-3 md:gap-4 group">

            <img src="{{ asset('images/logo.png') }}"
                 alt="UniHealth Logo"
                 class="w-11 h-11 md:w-[52px] md:h-[52px] rounded-xl shadow-sm border border-emerald-100">

            <span class="text-[22px] md:text-[26px] font-bold tracking-tight text-emerald-800">
                UniHealth
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-8">

        <a href="{{ route('home') }}"
        class="{{ request()->routeIs('home')
                ? 'text-[15px] font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-0.5'
                : 'text-[15px] font-semibold text-slate-600 hover:text-emerald-700 transition-colors' }}">
            Beranda
        </a>

        <a href="{{ route('about') }}"
        class="{{ request()->routeIs('about')
                ? 'text-[15px] font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-0.5'
                : 'text-[15px] font-semibold text-slate-600 hover:text-emerald-700 transition-colors' }}">
            Tentang Kami
        </a>

            <div class="flex items-center gap-3 ml-4">

                <a href="{{ route('register') }}"
                   class="text-[15px] font-bold border border-emerald-200 text-emerald-700 bg-emerald-50 px-6 py-2.5 rounded-full  hover:bg-emerald-600 hover:text-white hover:border-emerald-600 shadow-sm shadow-emerald-500/20 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Daftar
                </a>

                <a href="{{ route('login') }}"
                   class="text-[15px] font-bold bg-emerald-600 text-white px-6 py-2.5 rounded-full hover:bg-emerald-700 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Masuk
                </a>

            </div>

        </nav>
    </div>

    <!-- Info Bar -->
    <div class="bg-emerald-600 w-full grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-emerald-500/50">

        <div class="py-2.5 px-6 text-center text-emerald-50">

            Jam Operasional

            @if($jadwalHariIni)

                {{ sprintf('%02d:00', $jadwalHariIni->jam_buka) }}
                {{ sprintf('%02d:00', $jadwalHariIni->jam_tutup) }}
                ({{ $statusOperasional }})

            @else
                Tutup
            @endif

        </div>

        @if($statusOperasional !== 'Tutup')

            <div class="py-2.5 px-6 text-center text-emerald-50">
                Antrean Hari Ini :
                <span class="font-bold text-white">
                    {{ $jumlahAntrean }}
                </span>
            </div>

            <div class="py-2.5 px-6 text-center text-emerald-50">
                <span class="font-bold text-white">
                    {{ $jumlahDokterTersedia }}
                </span>
                Dokter Tersedia Hari Ini
            </div>

        @else

            <div class="py-2.5 px-6 text-center text-emerald-50">
                Klinik Sedang Tutup
            </div>

            <div class="py-2.5 px-6 text-center text-emerald-50">
                Silakan Datang Saat Jam Operasional
            </div>

        @endif

    </div>

</header>

<main>
    @yield('content')
</main>
</body>
</html>
