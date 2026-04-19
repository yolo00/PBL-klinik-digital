<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - UniHealth</title>
    <!-- Direct link to pre-compiled Vite CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-100 flex items-center justify-center p-6 bg-fixed">
    <div class="w-full max-w-[500px] rounded-[40px] bg-white/90 backdrop-blur-xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative">
        <div class="flex justify-center mb-4">
            <img src="https://placehold.co/100x100/059669/ffffff?text=U" alt="UniHealth Logo" class="w-14 h-14 rounded-[18px] shadow-sm">
        </div>
        
        <p class="text-center text-[13px] font-bold tracking-[0.2em] text-emerald-600 mb-2 uppercase">Selamat Datang Kembali</p>
        <h1 class="text-center text-[32px] font-bold text-slate-800 mb-4 tracking-tight">Masuk ke UniHealth</h1>
        <p class="text-center text-[15px] font-medium text-slate-500 mb-8 mx-4">Akses jadwal klinik dan janji temu pasien Anda di kampus.</p>
        
        <form action="#" method="POST" class="space-y-5" onsubmit="event.preventDefault(); if(document.getElementById('email').value === '000') { window.location.href='/admin/dashboard'; } else { window.location.href='/'; }">
            @csrf
            <div>
                <label class="mb-2 block text-[15px] font-semibold text-slate-700">Email</label>
                <input type="text" id="email" placeholder="Masukkan email anda" class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-4 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm" />
            </div>

            <div>
                <label class="mb-2 block text-[15px] font-semibold text-slate-700">Kata Sandi</label>
                <div class="relative">
                    <input type="password" placeholder="Masukkan kata sandi anda" class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-4 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm" />
                    <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full rounded-[20px] bg-emerald-600 px-5 py-4 text-[16px] font-semibold text-white hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/30 transition-all shadow-lg shadow-emerald-500/25 transform hover:-translate-y-0.5">Masuk</button>
            </div>
            
            <div class="text-center mt-8">
                <p class="text-[14px] text-slate-600 font-medium">Belum punya akun? <a href="/register" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">Daftar sekarang</a></p>
                <p class="text-[13px] text-slate-500 font-semibold mt-3 hover:text-emerald-600 cursor-pointer transition-colors">Punya pertanyaan? Hubungi Kami</p>
            </div>
        </form>
    </div>
</body>
</html>
