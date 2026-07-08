@extends('layouts.app')
@section('title', 'Tentang Kami')
@section('content')
<body class="min-h-screen bg-slate-50 text-slate-800">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <div class="w-full">
        <!-- Hero Section -->
        <div class="px-4 md:px-6 py-10 md:py-16 relative overflow-hidden bg-gradient-to-b from-white to-emerald-50/50">
            <div class="max-w-[1400px] mx-auto text-center opacity-0 animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 md:px-5 md:py-2.5 rounded-full border border-emerald-200 bg-emerald-50 mb-4 md:mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-[12px] md:text-[14px] font-bold text-emerald-700 tracking-wide uppercase">Tentang Kami</p>
                </div>
                <h1 class="text-[28px] md:text-[56px] font-bold text-slate-800 leading-[1.15] md:leading-[1.1] tracking-tight">Mengenal Lebih Dekat<br><span class="text-emerald-600">UniHealth</span></h1>
                <p class="text-[14px] md:text-[18px] text-slate-600 pt-3 md:pt-4 leading-relaxed max-w-[650px] mx-auto font-medium">Sistem informasi kesehatan digital yang membantu klinik, puskesmas, dan rumah sakit dalam memberikan layanan kesehatan yang modern, efisien, dan terintegrasi.</p>
            </div>
        </div>

        <!-- Tentang Proyek Section -->
        <div class="px-4 md:px-6 pb-10 md:pb-16 max-w-[1400px] mx-auto">
            <div class="bg-white rounded-[24px] md:rounded-[36px] p-6 md:p-14 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-slate-100 opacity-0 animate-fade-in-up delay-100">
                <div class="flex items-center gap-3 mb-5 md:mb-8">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200 shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h2 class="text-[20px] md:text-[32px] font-bold text-slate-800 tracking-tight">Tentang Proyek</h2>
                </div>
                
                <div class="space-y-4 md:space-y-6 text-[13.5px] md:text-[17px] text-slate-600 leading-relaxed font-medium">
                    <p>UniHealth adalah sistem berbasis web yang dirancang untuk membantu proses administrasi dan pengelolaan layanan kesehatan pada klinik, puskesmas, dan rumah sakit secara digital. Sistem ini dibuat sebagai solusi atas berbagai kendala pada pengelolaan data medis secara konvensional, seperti penumpukan dokumen fisik, risiko kehilangan data, serta lambatnya proses pendaftaran dan penjadwalan pasien.</p>
                    
                    <p>Melalui UniHealth, seluruh data pasien, rekam medis, jadwal pemeriksaan, dan proses administrasi dapat disimpan dan dikelola secara terpusat dalam database. Dengan demikian, petugas klinik dapat melakukan pencarian data dengan lebih cepat, mengurangi kesalahan pencatatan, serta meningkatkan efisiensi pelayanan kepada pasien.</p>
                    
                    <p>Selain itu, sistem ini juga mendukung proses digitalisasi layanan kesehatan sehingga aktivitas klinik menjadi lebih terstruktur, akurat, dan mudah dipantau. Penggunaan teknologi web memungkinkan sistem dapat diakses dengan lebih fleksibel oleh admin, dokter, maupun petugas klinik sesuai hak akses masing-masing.</p>
                </div>
            </div>
        </div>

        <!-- Developer Section -->
        <div class="px-4 md:px-6 pb-10 md:pb-16 max-w-[1400px] mx-auto">
            <div class="text-center mb-8 md:mb-12 opacity-0 animate-fade-in-up delay-200">
                <h2 class="inline-block bg-emerald-100/80 text-emerald-800 py-2 px-5 md:py-2.5 md:px-8 rounded-full font-bold text-[13px] md:text-[16px] border border-emerald-200">Tim Pengembang</h2>
                <p class="mt-3 md:mt-5 text-[22px] md:text-[36px] font-bold text-slate-800 tracking-tight">Developer di Balik UniHealth</p>
            </div>

            <!-- Mobile: swipeable carousel | Desktop: grid -->
            <div class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 -mx-4 px-4 no-scrollbar md:grid md:grid-cols-3 md:gap-8 md:overflow-visible md:mx-0 md:px-0 md:pb-0 opacity-0 animate-fade-in-up delay-300">

                <!-- Developer 1: Michael -->
                <div class="min-w-[78%] sm:min-w-[50%] md:min-w-0 flex-shrink-0 snap-center md:flex-shrink md:snap-none bg-white rounded-[24px] md:rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 md:transform md:hover:-translate-y-2 text-center">
                    <img src="{{ asset('images/michael.jpeg') }}" alt="Michael Sando Turnip"
                         class="w-16 h-16 md:w-24 md:h-24 rounded-full object-cover mx-auto mb-4 md:mb-6 shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300 border-2 border-emerald-100">
                    <h3 class="font-bold text-[15px] md:text-[20px] text-slate-800 group-hover:text-emerald-700 transition-colors">Michael Sando Turnip</h3>
                    <div class="mt-3 md:mt-4 space-y-1.5 md:space-y-2">
                        <span class="inline-block bg-emerald-50 text-emerald-700 text-[11px] md:text-[13px] font-bold px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-emerald-200">Pengelola Basis Data</span>
                        <br>
                        <span class="inline-block bg-slate-50 text-slate-700 text-[11px] md:text-[13px] font-bold px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-slate-200">Pengembang Modul Admin</span>
                    </div>
                </div>

                <!-- Developer 2: Aprillia -->
                <div class="min-w-[78%] sm:min-w-[50%] md:min-w-0 flex-shrink-0 snap-center md:flex-shrink md:snap-none bg-white rounded-[24px] md:rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 md:transform md:hover:-translate-y-2 text-center">
                    <img src="{{ asset('images/april.jpeg') }}" alt="Aprillia Bunga Lestari"
                         class="w-16 h-16 md:w-24 md:h-24 rounded-full object-cover mx-auto mb-4 md:mb-6 shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform duration-300 border-2 border-rose-100">
                    <h3 class="font-bold text-[15px] md:text-[20px] text-slate-800 group-hover:text-emerald-700 transition-colors">Aprillia Bunga Lestari</h3>
                    <div class="mt-3 md:mt-4 space-y-1.5 md:space-y-2">
                        <span class="inline-block bg-sky-50 text-sky-700 text-[11px] md:text-[13px] font-bold px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-sky-200">Frontend Developer</span>
                        <br>
                        <span class="inline-block bg-slate-50 text-slate-700 text-[11px] md:text-[13px] font-bold px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-slate-200">Pengembang Modul Pasien</span>
                    </div>
                </div>

                <!-- Developer 3: Fenni -->
                <div class="min-w-[78%] sm:min-w-[50%] md:min-w-0 flex-shrink-0 snap-center md:flex-shrink md:snap-none bg-white rounded-[24px] md:rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 md:transform md:hover:-translate-y-2 text-center">
                    <img src="{{ asset('images/feyn.jpeg') }}" alt="Fenni Patrik Simanjuntak"
                         class="w-16 h-16 md:w-24 md:h-24 rounded-full object-cover mx-auto mb-4 md:mb-6 shadow-lg shadow-violet-500/20 group-hover:scale-110 transition-transform duration-300 border-2 border-violet-100">
                    <h3 class="font-bold text-[15px] md:text-[20px] text-slate-800 group-hover:text-emerald-700 transition-colors">Fenni Patrik Simanjuntak</h3>
                    <div class="mt-3 md:mt-4 space-y-1.5 md:space-y-2">
                        <span class="inline-block bg-violet-50 text-violet-700 text-[11px] md:text-[13px] font-bold px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-violet-200">Desainer Web</span>
                        <br>
                        <span class="inline-block bg-slate-50 text-slate-700 text-[11px] md:text-[13px] font-bold px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-slate-200">Pengembang Modul Dokter</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontak Section -->
        <div class="px-4 md:px-6 pb-14 md:pb-20 max-w-[1400px] mx-auto">
            <div class="bg-white rounded-[28px] md:rounded-[40px] p-6 md:p-14 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 opacity-0 animate-fade-in-up delay-600">
                <div class="text-center mb-6 md:mb-10">
                    <h2 class="inline-block bg-emerald-100/80 text-emerald-800 py-2 px-5 md:py-2.5 md:px-8 rounded-full font-bold text-[13px] md:text-[16px] border border-emerald-200">Kontak</h2>
                    <p class="mt-3 md:mt-5 text-[22px] md:text-[36px] font-bold text-slate-800 tracking-tight">Hubungi Kami</p>
                </div>

                <!-- Mobile: satu card, list rows -->
                <div class="md:hidden bg-slate-50 rounded-[20px] border border-slate-100 divide-y divide-slate-200">

                    <div class="flex items-center gap-4 p-4">
                        <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-slate-500">Email</p>
                            <a href="mailto:health67@gmail.com" class="text-[13.5px] text-emerald-600 font-semibold hover:underline break-all">health67@gmail.com</a>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-sky-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-slate-500">Telepon</p>
                            <p class="text-[13.5px] text-slate-700 font-semibold">0671-2345-6789</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4">
                        <div class="w-11 h-11 rounded-xl bg-amber-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-slate-500">Alamat</p>
                            <p class="text-[13.5px] text-slate-700 font-semibold leading-snug">Batam, Kepulauan Riau, Indonesia</p>
                        </div>
                    </div>

                </div>

                <!-- Desktop: grid 3 card (tetap seperti semula) -->
                <div class="hidden md:grid md:grid-cols-3 gap-8">
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
                        <p class="text-[15px] text-slate-700 font-semibold leading-relaxed">Batam, Kepulauan Riau,<br>Indonesia</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-emerald-950 text-emerald-50/70 py-16 px-8 mt-auto rounded-t-[20px] md:rounded-t-[40px] fade-in fade-in-4">
        <div class="max-w-[1400px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-16">
            <div class="md:col-span-5 lg:pr-10">
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://placehold.co/100x100/ffffff/064e3b?text=U" alt="Footer Logo" class="w-[50px] h-[50px] rounded-[14px] shadow-sm">
                    <span class="font-bold text-[28px] text-white tracking-tight">UniHealth</span>
                </div>
                <p class="text-[15px] pt-2 leading-relaxed max-w-sm mb-8">Sistem layanan kesehatan digital yang membantu klinik, puskesmas, dan rumah sakit dalam mengelola pendaftaran pasien, jadwal dokter, serta rekam medis secara efisien.</p>
            </div>
            
            <div class="md:col-span-2 md:border-l border-emerald-800/50 md:pl-8">
                <h4 class="font-bold text-white mb-6 text-[16px]">Menu Cepat</h4>
                <ul class="space-y-4 text-[15px]">
                    <li><a href="/login" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Masuk Akun</a></li>
                    <li><a href="/register" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Pendaftaran Pasien</a></li>
                    <li><a href="/about" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Tentang Kami</a></li>
                </ul>
            </div>
        

            <div class="md:col-span-3">
                <h4 class="font-bold text-white mb-6 text-[16px]">Hubungi Kami</h4>
                <div class="space-y-4 text-[14.5px]">
                    <p class="leading-relaxed"><strong class="text-white">Alamat Klinik:</strong><br>Batam, Kepulauan Riau,<br>Indonesia</p>
                    <p><strong class="text-white">Email:</strong><br><a href="mailto:health67@gmail.com" class="hover:text-emerald-400 transition-colors font-medium">health67@gmail.com</a></p>
                    <p><strong class="text-white">Telepon:</strong><br><span class="font-medium text-emerald-100">0671-2345-6789</span></p>
                </div>
            </div>
        </div>
        
        <div class="max-w-[1400px] mx-auto border-t border-emerald-900/50 mt-16 pt-8 flex justify-between items-center text-[14px]">
            <p>© 2026 UniHealth System. Seluruh hak dilindungi.</p>
        </div>
    </footer>
</body>
@endsection