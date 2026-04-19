<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda - UniHealth</title>
    <!-- Direct link to pre-compiled Vite CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/app-T3EHGAm9.css')); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <!-- Navbar -->
    <header class="w-full bg-white sticky top-0 z-50 shadow-sm border-b border-emerald-100">
        <!-- Info Bar -->
        <div class="bg-emerald-600 w-full grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-emerald-500/50">
            <div class="py-2.5 px-6 text-[13px] md:text-[14px] text-center font-medium text-emerald-50">Jam Operasional 8:00 - 17:00 (Buka)</div>
            <div class="py-2.5 px-6 text-[13px] md:text-[14px] text-center font-medium text-emerald-50">Antrean Hari Ini : <span class="font-bold text-white">5</span></div>
            <div class="py-2.5 px-6 text-[13px] md:text-[14px] text-center font-medium text-emerald-50"><span class="font-bold text-white">3</span> Dokter Tersedia Hari Ini</div>
        </div>

        <div class="flex items-center justify-between px-8 py-4 w-full max-w-[1500px] mx-auto">
            <!-- Logo area -->
            <a href="/" class="flex items-center gap-3 md:gap-4 group">
                <img src="https://placehold.co/100x100/059669/ffffff?text=U" alt="UniHealth Logo" class="w-11 h-11 md:w-[52px] md:h-[52px] rounded-xl shadow-sm border border-emerald-100 group-hover:scale-105 transition-transform">
                <span class="text-[22px] md:text-[26px] font-bold tracking-tight text-emerald-800">UniHealth</span>
            </a>
            
            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-[15px] font-bold text-emerald-600 border-b-2 border-emerald-600 pb-0.5">Beranda</a>
                <a href="#" class="text-[15px] font-medium text-slate-600 hover:text-emerald-600 transition-colors">Tentang</a>
                <a href="#" class="text-[15px] font-medium text-slate-600 hover:text-emerald-600 transition-colors">Kontak</a>
                
                <div class="flex items-center gap-3 ml-4">
                    <a href="/register" class="text-[15px] font-bold border border-emerald-200 text-emerald-700 bg-emerald-50 px-6 py-2.5 rounded-full hover:bg-emerald-100 transition-all">Daftar</a>
                    <a href="/login" class="text-[15px] font-bold bg-emerald-600 text-white px-6 py-2.5 rounded-full hover:bg-emerald-700 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:-translate-y-0.5 transition-all">Masuk</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="w-full">
        <!-- Hero Section -->
        <div class="px-6 py-12 relative overflow-hidden bg-gradient-to-b from-white to-emerald-50/50">
            <!-- decorative blur backdrop -->
            <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-emerald-400 rounded-full mix-blend-multiply filter blur-[120px] opacity-20"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-teal-400 rounded-full mix-blend-multiply filter blur-[120px] opacity-20"></div>
            
            <div class="bg-white/90 backdrop-blur-md rounded-[32px] md:rounded-[40px] p-8 md:p-16 mt-4 grid grid-cols-1 md:grid-cols-12 gap-12 items-center mx-auto max-w-[1400px] shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-emerald-50 relative z-10">
                <div class="md:col-span-7 space-y-6 md:pr-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-emerald-200 bg-emerald-50">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p class="text-[14px] font-bold text-emerald-700 tracking-wide uppercase">Sistem Klinik Digital Kampus</p>
                    </div>
                    <h1 class="text-[40px] md:text-[56px] font-bold text-slate-800 leading-[1.1] tracking-tight">Semua Layanan Klinik<br><span class="text-emerald-600">Kampus, Satu Tempat</span></h1>
                    <p class="text-[18px] text-slate-600 pt-2 leading-relaxed max-w-[550px] font-medium">UniHealth menghadirkan pengalaman pendaftaran dan penjadwalan konsultasi klinik yang mudah dan revolusioner di dalam lingkungan kampus.</p>
                    <div class="pt-6 flex flex-col sm:flex-row gap-4">
                        <button class="bg-emerald-600 text-white px-8 py-4 rounded-full font-bold text-[16px] hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5 transition-all">Mulai Konsultasi</button>
                        <button class="bg-white border-2 border-emerald-100 text-emerald-700 px-8 py-4 rounded-full font-bold text-[16px] hover:bg-emerald-50 transition-all">Pelajari Lebih Lanjut</button>
                    </div>
                </div>
                
                <div class="md:col-span-5 bg-gradient-to-br from-emerald-50 to-teal-50/50 rounded-[28px] p-8 flex flex-col gap-5 border border-emerald-100 shadow-[0_4px_20px_rgb(16,185,129,0.08)] relative">
                    <div class="absolute -top-6 -right-6">
                        <img src="https://placehold.co/120x120/059669/ffffff?text=U" alt="Decoration" class="w-[72px] h-[72px] rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.12)] border-2 border-white rotate-12">
                    </div>
                    
                    <div class="bg-white rounded-[20px] p-5 shadow-sm font-bold text-[17px] text-emerald-800 mb-2 border-b-2 border-emerald-100 flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Penggunaan Layanan yang Mudah
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow flex gap-4 items-start group border border-slate-50">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">1</div>
                        <p class="text-[15px] font-medium text-slate-700 pt-1 leading-relaxed">Login atau daftar menggunakan akun email kampus anda</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow flex gap-4 items-start group border border-slate-50">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">2</div>
                        <p class="text-[15px] font-medium text-slate-700 pt-1 leading-relaxed">Daftar jadwal dengan memilih tanggal waktu dan dokter anda</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow flex gap-4 items-start group border border-slate-50">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">3</div>
                        <p class="text-[15px] font-medium text-slate-700 pt-1 leading-relaxed">Datang ke lokasi klinik kampus untuk melakukan konsultasi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Kami -->
        <div class="px-6 py-20 max-w-[1400px] mx-auto relative relative z-20">
            <div class="text-center mb-14">
                <h2 class="inline-block bg-emerald-100/80 text-emerald-800 py-2.5 px-8 rounded-full font-bold text-[16px] border border-emerald-200">Layanan Inti</h2>
                <p class="mt-5 text-[36px] font-bold text-slate-800 tracking-tight">Perawatan Komprehensif Untuk Anda</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <div class="bg-white rounded-[28px] p-8 flex flex-col items-center justify-center text-center shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://placehold.co/100x100/ecfdf5/059669?text=KU" alt="Konsultasi Umum" class="w-20 h-20 rounded-[20px] mb-6 group-hover:scale-110 transition-transform shadow-sm">
                    <span class="font-bold text-[18px] text-slate-800 group-hover:text-emerald-700 transition-colors">Konsultasi Umum</span>
                    <p class="text-[14px] text-slate-500 mt-3 font-medium leading-relaxed">Konsultasi kesehatan dasar kapan saja.</p>
                </div>
                <div class="bg-white rounded-[28px] p-8 flex flex-col items-center justify-center text-center shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://placehold.co/100x100/ecfdf5/059669?text=RM" alt="Rekam Medis" class="w-20 h-20 rounded-[20px] mb-6 group-hover:scale-110 transition-transform shadow-sm">
                    <span class="font-bold text-[18px] text-slate-800 group-hover:text-emerald-700 transition-colors">Penyimpanan Rekam Medis</span>
                    <p class="text-[14px] text-slate-500 mt-3 font-medium leading-relaxed">Riwayat kesehatan yang aman dan rapi.</p>
                </div>
                <div class="bg-white rounded-[28px] p-8 flex flex-col items-center justify-center text-center shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://placehold.co/100x100/ecfdf5/059669?text=SK" alt="Surat Sakit" class="w-20 h-20 rounded-[20px] mb-6 group-hover:scale-110 transition-transform shadow-sm">
                    <span class="font-bold text-[18px] text-slate-800 group-hover:text-emerald-700 transition-colors">Menyediakan Surat Sakit</span>
                    <p class="text-[14px] text-slate-500 mt-3 font-medium leading-relaxed">Penerbitan surat keterangan sah dokter.</p>
                </div>
                <div class="bg-white rounded-[28px] p-8 flex flex-col items-center justify-center text-center shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:border-emerald-200 hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] group transition-all duration-300 transform hover:-translate-y-2">
                    <img src="https://placehold.co/100x100/ecfdf5/059669?text=OV" alt="Obat" class="w-20 h-20 rounded-[20px] mb-6 group-hover:scale-110 transition-transform shadow-sm">
                    <span class="font-bold text-[18px] text-slate-800 group-hover:text-emerald-700 transition-colors">Stok Obat & Vitamin</span>
                    <p class="text-[14px] text-slate-500 mt-3 font-medium leading-relaxed">Penyediaan suplemen & obat mahasiswa.</p>
                </div>
            </div>
        </div>

        <!-- More Information -->
        <div class="px-6 py-8 max-w-[1400px] mx-auto bg-white mb-20 rounded-[40px] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 relative">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16">
                <!-- Left Column -->
                <div class="md:col-span-5 flex flex-col h-full bg-emerald-50 rounded-[32px] p-8 md:p-12 border border-emerald-100 relative overflow-hidden text-center md:text-left">
                    <div class="absolute -top-20 -left-20 w-60 h-60 bg-emerald-200 rounded-full mix-blend-multiply opacity-40 blur-[30px]"></div>
                    
                    <div class="bg-white text-emerald-800 py-3 px-6 rounded-full font-bold w-max mx-auto md:mx-0 shadow-sm border border-emerald-100 text-[15px] mb-10 relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Jadwal & Info
                    </div>
                    
                    <div class="bg-white rounded-[28px] p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex-1 flex flex-col justify-center border border-emerald-50 relative z-10">
                        <h3 class="font-bold mb-6 text-[20px] text-emerald-900 border-b border-emerald-100 pb-4 text-left">Jam Operasional</h3>
                        <div class="flex justify-between py-5 border-b border-emerald-50 text-[15px] font-bold text-slate-700 items-center">
                            <span class="flex items-center gap-3"><div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgb(16,185,129,0.5)]"></div>Senin - Jumat</span>
                            <span>8:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between py-5 border-b border-emerald-50 text-[15px] font-bold text-slate-700 items-center">
                            <span class="flex items-center gap-3"><div class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgb(245,158,11,0.5)]"></div>Sabtu</span>
                            <span>10:00 - 14:00</span>
                        </div>
                        <p class="text-[13px] text-emerald-700 font-bold mt-6 bg-emerald-50/80 py-3.5 px-4 rounded-xl border border-emerald-100/50 text-left">Jam operasional dapat berubah di tanggal merah</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="md:col-span-7 flex flex-col md:flex-row gap-8 items-stretch md:pt-14 md:pr-12 md:pb-12">
                    <div class="bg-white rounded-[32px] p-8 flex-1 border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col">
                        <h3 class="font-bold mb-6 text-[18px] text-slate-800 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            Informasi Penting
                        </h3>
                        <ul class="space-y-6 text-[15px] text-slate-600 font-medium list-none mt-2">
                            <li class="flex items-start gap-3"><svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Melayani mahasiswa dan staff aktif</li>
                            <li class="flex items-start gap-3"><svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Wajib membawa kartu identitas</li>
                            <li class="flex items-start gap-3"><svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Datang 10 menit sebelum jadwal temu</li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-[32px] p-8 flex-1 border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold mb-5 text-[18px] text-slate-800 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                Lokasi
                            </h3>
                            <p class="text-[14.5px] text-slate-600 leading-relaxed font-medium pl-1">Politeknik Negeri Batam.<br>Jl. Ahmad Yani, Batam Center,<br>Batam Kota, Kepri 29461</p>
                        </div>

                        <div class="mt-8 border-t border-slate-100 pt-6">
                            <h3 class="font-bold mb-4 text-[16px] text-slate-800 pl-1">Kontak Cepat</h3>
                            <div class="flex justify-between text-[14.5px] mb-3 font-medium pl-1">
                                <span class="text-slate-500">Email</span> 
                                <a href="mailto:health67@gmail.com" class="text-emerald-600 hover:underline">health67@gmail.com</a>
                            </div>
                            <div class="flex justify-between text-[14.5px] font-bold pl-1">
                                <span class="text-slate-500 font-medium">Telepon</span> 
                                <span class="text-slate-700">0671-2345-6789</span>
                            </div>
                        </div>
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
                    <li><a href="#" class="hover:text-emerald-400 hover:translate-x-1 inline-block transition-transform font-medium">Tentang Kami</a></li>
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
            <p>© 2026 UniHealth System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\SEM2\PBL\PBL-klinik-digital\resources\views/about.blade.php ENDPATH**/ ?>