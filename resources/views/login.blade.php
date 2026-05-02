<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - UniHealth</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-100 flex items-center justify-center p-6 bg-fixed">
    <div class="w-full max-w-[500px] rounded-[40px] bg-white/90 backdrop-blur-xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative">
        <!-- Back Button -->
        <a href="/" class="absolute top-8 left-8 flex items-center justify-center w-10 h-10 rounded-full bg-slate-50 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-slate-200 hover:border-emerald-200 shadow-sm group" title="Kembali ke Beranda">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-0.5 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        </a>

        <div class="flex justify-center mb-4">
            <img src="https://placehold.co/100x100/059669/ffffff?text=U" alt="UniHealth Logo" class="w-14 h-14 rounded-[18px] shadow-sm">
        </div>

        <p class="text-center text-[13px] font-bold tracking-[0.2em] text-emerald-600 mb-2 uppercase">Selamat Datang Kembali</p>
        <h1 class="text-center text-[32px] font-bold text-slate-800 mb-4 tracking-tight">Masuk ke UniHealth</h1>
        <p class="text-center text-[15px] font-medium text-slate-500 mb-8 mx-4">Akses jadwal klinik dan janji temu pasien Anda di kampus.</p>

        {{-- Pesan error login --}}
        @if ($errors->has('login'))
            <div class="mb-5 rounded-[16px] bg-rose-50 border border-rose-200 px-5 py-3 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-rose-500 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p class="text-[14px] font-medium text-rose-600">{{ $errors->first('login') }}</p>
            </div>
        @endif

        {{-- Pesan sukses (misal: setelah register) --}}
        @if (session('success'))
            <div class="mb-5 rounded-[16px] bg-emerald-50 border border-emerald-200 px-5 py-3 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500 shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <p class="text-[14px] font-medium text-emerald-600">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-[15px] font-semibold text-slate-700">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email anda"
                    class="w-full rounded-[20px] border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-slate-50' }} px-5 py-4 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30"
                />
                @error('email')
                    <p class="mt-1.5 text-[13px] text-rose-500 font-medium pl-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-[15px] font-semibold text-slate-700">Kata Sandi</label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Masukkan kata sandi anda"
                        class="w-full rounded-[20px] border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50' : 'border-slate-200 bg-slate-50' }} px-5 py-4 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30"
                    />
                    <button type="button" onclick="togglePassword()" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors">
                        <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-[13px] text-rose-500 font-medium pl-2">{{ $message }}</p>
                @enderror
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

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const iconEye = document.getElementById('icon-eye');
            const iconEyeOff = document.getElementById('icon-eye-off');

            if (input.type === 'password') {
                input.type = 'text';
                iconEye.classList.add('hidden');
                iconEyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconEye.classList.remove('hidden');
                iconEyeOff.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
