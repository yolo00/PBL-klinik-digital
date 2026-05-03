<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - UniHealth</title>
    <meta name="description" content="Tentang Web Klinik Digital UniHealth - Sistem berbasis web untuk administrasi dan pengelolaan layanan kesehatan klinik secara digital.">
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in-up { animation: fadeInUp 0.7s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <!-- Navbar -->
    <header class="w-full bg-white sticky top-0 z-50 shadow-sm border-b border-emerald-100">
        
        <div class="flex items-center justify-between px-8 py-4 w-full max-w-[1500px] mx-auto">
            <!-- Logo area -->
            <a href="/" class="flex items-center gap-3 md:gap-4 group">
                <img src="{{ asset('images/logo.png') }}" alt="UniHealth Logo" class="w-11 h-11 md:w-[52px] md:h-[52px] rounded-xl shadow-sm border border-emerald-100 group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-300">
                <span class="text-[22px] md:text-[26px] font-bold tracking-tight text-emerald-800">UniHealth</span>
            </a>
            
            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-[15px] font-semibold text-slate-600 hover:text-emerald-700 transition-colors">Beranda</a>
                <a href="{{ route('about') }}" class="text-[15px] font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-0.5">Tentang Kami</a>
                <div class="flex items-center gap-3 ml-4">
                    <a href="{{ route('register') }}" class="text-[15px] font-bold border border-emerald-200 text-emerald-700 bg-emerald-50 px-6 py-2.5 rounded-full hover:bg-emerald-600 hover:text-white hover:border-emerald-600 shadow-sm shadow-emerald-500/20 hover:shadow-lg hover:-translate-y-0.5 transition-all">Daftar</a>
                    <a href="{{ route('login') }}" class="text-[15px] font-bold bg-emerald-600 text-white px-6 py-2.5 rounded-full hover:bg-emerald-700 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:-translate-y-0.5 transition-all">Masuk</a>
                </div>
            </nav>
        </div>
        <!-- Info Bar -->
        <div class="bg-emerald-600 w-full grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-emerald-500/50">
            <div class="py-2.5 px-6 text-[13px] md:text-[14px] text-center font-medium text-emerald-50">Jam Operasional 8:00 - 17:00 (Buka)</div>
            <div class="py-2.5 px-6 text-[13px] md:text-[14px] text-center font-medium text-emerald-50">Antrean Hari Ini : <span class="font-bold text-white">5</span></div>
            <div class="py-2.5 px-6 text-[13px] md:text-[14px] text-center font-medium text-emerald-50"><span class="font-bold text-white">3</span> Dokter Tersedia Hari Ini</div>
        </div>
    </header>

    <main class="w-full">
        <!-- Hero Section -->
        <div class="px-6 py-16 relative overflow-hidden bg-gradient-to-b from-white to-emerald-50/50">
            <div class="max-w-[1400px] mx-auto text-center opacity-0 animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-emerald-200 bg-emerald-50 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-[14px] font-bold text-emerald-700 tracking-wide uppercase">Tentang Kami</p>
                </div>
                <h1 class="text-[40px] md:text-[56px] font-bold text-slate-800 leading-[1.1] tracking-tight">Mengenal Lebih Dekat<br><span class="text-emerald-600">UniHealth</span></h1>
                <p class="text-[18px] text-slate-600 pt-4 leading-relaxed max-w-[650px] mx-auto font-medium">Sistem klinik digital yang menghadirkan layanan kesehatan modern, efisien, dan terintegrasi untuk lingkungan kampus.</p>
            </div>
        </div>

        <!-- Tentang Proyek Section -->
        <div class="px-6 pb-16 max-w-[1400px] mx-auto">
            <div class="bg-white rounded-[36px] p-8 md:p-14 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-slate-100 opacity-0 animate-fade-in-up delay-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h2 class="text-[28px] md:text-[32px] font-bold text-slate-800 tracking-tight">Tentang Proyek</h2>
                </div>
                
                <div class="space-y-6 text-[16px] md:text-[17px] text-slate-600 leading-relaxed font-medium">
                    <p>Web Klinik Digital adalah sebuah sistem berbasis web yang dirancang untuk membantu proses administrasi dan pengelolaan layanan kesehatan di klinik secara digital. Sistem ini dibuat sebagai solusi atas berbagai kendala pada pengelolaan data medis secara konvensional, seperti penumpukan dokumen fisik, risiko kehilangan data, serta lambatnya proses pendaftaran dan penjadwalan pasien.</p>
                    
                    <p>Melalui Web Klinik Digital, seluruh data pasien, rekam medis, jadwal pemeriksaan, dan proses administrasi dapat disimpan dan dikelola secara terpusat dalam database. Dengan demikian, petugas klinik dapat melakukan pencarian data dengan lebih cepat, mengurangi kesalahan pencatatan, serta meningkatkan efisiensi pelayanan kepada pasien.</p>
                    
                    <p>Selain itu, sistem ini juga mendukung proses digitalisasi layanan kesehatan sehingga aktivitas klinik menjadi lebih terstruktur, akurat, dan mudah dipantau. Penggunaan teknologi web memungkinkan sistem dapat diakses dengan lebih fleksibel oleh admin, dokter, maupun petugas klinik sesuai hak akses masing-masing.</p>
                </div>
            </div>
        </div>

        <!-- Developer Section -->
        <div class="px-6 pb-16 max-w-[1400px] mx-auto">
            <div class="text-center mb-12 opacity-0 animate-fade-in-up delay-200">
                <h2 class="inline-block bg-emerald-100/80 text-emerald-800 py-2.5 px-8 rounded-full font-bold text-[16px] border border-emerald-200">Tim Pengembang</h2>
                <p class="mt-5 text-[36px] font-bold text-slate-800 tracking-tight">Developer di Balik UniHealth</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Developer 1: Michael -->
                <div class="bg-white rounded-[32px] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2 text-center opacity-0 animate-fade-in-up delay-300">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 mx-auto mb-6 flex items-center justify-center text-white text-[36px] font-bold shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">M</div>
                    <h3 class="font-bold text-[20px] text-slate-800 group-hover:text-emerald-700 transition-colors">Michael Sando Turnip</h3>
                    <div class="mt-4 space-y-2">
                        <span class="inline-block bg-emerald-50 text-emerald-700 text-[13px] font-bold px-4 py-1.5 rounded-full border border-emerald-200">Pengelola Database</span>
                        <br>
                        <span class="inline-block bg-slate-50 text-slate-700 text-[13px] font-bold px-4 py-1.5 rounded-full border border-slate-200">Developer Halaman Admin</span>
                    </div>
                </div>

                <!-- Developer 2: Aprillia -->
                <div class="bg-white rounded-[32px] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2 text-center opacity-0 animate-fade-in-up delay-400">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-rose-400 to-pink-600 mx-auto mb-6 flex items-center justify-center text-white text-[36px] font-bold shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform duration-300">A</div>
                    <h3 class="font-bold text-[20px] text-slate-800 group-hover:text-emerald-700 transition-colors">Aprillia Bunga</h3>
                    <div class="mt-4 space-y-2">
                        <span class="inline-block bg-sky-50 text-sky-700 text-[13px] font-bold px-4 py-1.5 rounded-full border border-sky-200">Frontend Developer</span>
                        <br>
                        <span class="inline-block bg-slate-50 text-slate-700 text-[13px] font-bold px-4 py-1.5 rounded-full border border-slate-200">Developer Halaman Pasien</span>
                    </div>
                </div>

                <!-- Developer 3: Fenni -->
                <div class="bg-white rounded-[32px] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2 text-center opacity-0 animate-fade-in-up delay-500">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-violet-400 to-indigo-600 mx-auto mb-6 flex items-center justify-center text-white text-[36px] font-bold shadow-lg shadow-violet-500/20 group-hover:scale-110 transition-transform duration-300">F</div>
                    <h3 class="font-bold text-[20px] text-slate-800 group-hover:text-emerald-700 transition-colors">Fenni Patrik Simanjuntak</h3>
                    <div class="mt-4 space-y-2">
                        <span class="inline-block bg-violet-50 text-violet-700 text-[13px] font-bold px-4 py-1.5 rounded-full border border-violet-200">Developer Halaman Dokter</span>
                        <br>
                        <span class="inline-block bg-slate-50 text-slate-700 text-[13px] font-bold px-4 py-1.5 rounded-full border border-slate-200">Desainer Logo Web</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontak Section -->
        <div class="px-6 pb-20 max-w-[1400px] mx-auto">
            <div class="bg-white rounded-[40px] p-8 md:p-14 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 opacity-0 animate-fade-in-up delay-600">
                <div class="text-center mb-10">
                    <h2 class="inline-block bg-emerald-100/80 text-emerald-800 py-2.5 px-8 rounded-full font-bold text-[16px] border border-emerald-200">Kontak</h2>
                    <p class="mt-5 text-[36px] font-bold text-slate-800 tracking-tight">Hubungi Kami</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Email -->
                    <div class="bg-emerald-50 rounded-[28px] p-8 border border-emerald-100 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-[17px] text-slate-800 mb-2">Email</h3>
                        <a href="mailto:health67@gmail.com" class="text-[15px] text-emerald-600 font-semibold hover:underline">health67@gmail.com</a>
                    </div>

                    <!-- Telepon -->
                    <div class="bg-sky-50 rounded-[28px] p-8 border border-sky-100 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-sky-600 text-white flex items-center justify-center mx-auto mb-5 shadow-lg shadow-sky-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <h3 class="font-bold text-[17px] text-slate-800 mb-2">Telepon</h3>
                        <p class="text-[15px] text-slate-700 font-semibold">0671-2345-6789</p>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-amber-50 rounded-[28px] p-8 border border-amber-100 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-amber-600 text-white flex items-center justify-center mx-auto mb-5 shadow-lg shadow-amber-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-[17px] text-slate-800 mb-2">Alamat</h3>
                        <p class="text-[15px] text-slate-700 font-semibold leading-relaxed">Jl. Ahmad Yani, Batam Center,<br>Batam Kota, 29461</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-emerald-950 text-emerald-50/70 py-16 px-8 mt-auto rounded-t-[40px]">
        <div class="max-w-[1400px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-16">
            <div class="md:col-span-5 lg:pr-10">
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://placehold.co/100x100/ffffff/064e3b?text=U" alt="Footer Logo" class="w-[50px] h-[50px] rounded-[14px] shadow-sm">
                    <span class="font-bold text-[28px] text-white tracking-tight">UniHealth</span>
                </div>
                <p class="text-[15px] pt-2 leading-relaxed max-w-sm mb-8">Sistem terintegrasi yang menghadirkan layanan kesehatan, pendaftaran, dan jadwal dokter yang aman dan mudah di kampus.</p>
            </div>
            
            <div class="md:col-span-2 md:border-l border-emerald-800/50 md:pl-8">
                <h4 class="font-bold text-white mb-6 text-[16px]">Menu Cepat</h4>
                <ul class="space-y-4 text-[15px]">
                    <li><a href="/login" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Masuk Akun</a></li>
                    <li><a href="/register" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Pendaftaran Pasien</a></li>
                    <li><a href="/about" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Tentang Kami</a></li>
                </ul>
            </div>
            
            <div class="md:col-span-2">
                <h4 class="font-bold text-white mb-6 text-[16px]">Layanan</h4>
                <ul class="space-y-4 text-[15px]">
                    <li><a href="#" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Konsultasi Umum</a></li>
                    <li><a href="#" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Ambil Obat</a></li>
                    <li><a href="#" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Surat Dokter</a></li>
                </ul>
            </div>

            <div class="md:col-span-3">
                <h4 class="font-bold text-white mb-6 text-[16px]">Hubungi Kami</h4>
                <div class="space-y-4 text-[14.5px]">
                    <p class="leading-relaxed"><strong class="text-white">Alamat Kampus:</strong><br>Jl. Ahmad Yani, Batam Center,<br>Batam Kota, 29461</p>
                    <p><strong class="text-white">Email:</strong><br><a href="mailto:health67@gmail.com" class="hover:text-emerald-400 transition-colors font-medium">health67@gmail.com</a></p>
                    <p><strong class="text-white">Telepon:</strong><br><span class="font-medium text-emerald-100">0671-2345-6789</span></p>
                </div>
            </div>
        </div>
        
        <div class="max-w-[1400px] mx-auto border-t border-emerald-900/50 mt-16 pt-8 flex justify-between items-center text-[14px]">
            <p>&copy; 2026 UniHealth System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
