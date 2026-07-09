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
        
        <a href="/" class="absolute top-8 left-8 flex items-center justify-center w-10 h-10 rounded-full bg-slate-50 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-slate-200">
            ←
        </a>

        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="UniHealth Logo" class="w-14 h-14 rounded-[18px]">
        </div>

        <p class="text-center text-[13px] font-bold tracking-[0.2em] text-emerald-600 mb-2 uppercase">
            Selamat Datang Kembali
        </p>
        <h1 class="text-center text-[32px] font-bold text-slate-800 mb-4">Masuk ke UniHealth</h1>
        <p class="text-center text-[15px] font-medium text-slate-500 mb-8">
            Akses layanan kesehatan, jadwal pemeriksaan, dan informasi medis Anda.
        </p>

        @if ($errors->has('login'))
            <div class="mb-5 rounded-[16px] bg-rose-50 border border-rose-200 px-5 py-3">
                <p class="text-[14px] text-rose-600">{{ $errors->first('login') }}</p>
            </div>
        @elseif ($errors->has('email') || $errors->has('password'))
            <div class="mb-5 rounded-[16px] bg-rose-50 border border-rose-200 px-5 py-3">
                <p class="text-[14px] text-rose-600">
                    @if ($errors->has('email') && $errors->has('password'))
                        Tolong isi email dan kata sandi anda.
                    @elseif ($errors->has('email'))
                        Tolong isi email anda terlebih dahulu.
                    @elseif ($errors->has('password'))
                        Tolong isi kata sandi anda.
                    @endif
                </p>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-5 rounded-[16px] bg-emerald-50 border border-emerald-200 px-5 py-3">
                <p class="text-[14px] text-emerald-600">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="mb-2 block text-[15px] font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" 
                    class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-4 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
            </div>

            <div>
                <label class="mb-2 block text-[15px] font-semibold text-slate-700">Kata Sandi</label>
                <input type="password" name="password" placeholder="Masukkan kata sandi Anda" 
                    class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-4 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
            </div>

            <button type="submit" class="w-full rounded-[20px] bg-emerald-600 px-5 py-4 text-white font-semibold hover:bg-emerald-700 transition-all">
                Masuk
            </button>

            <div class="text-center mt-8">
                <p class="text-[14px] text-slate-600">
                    Belum memiliki akun? <a href="/register" class="font-bold text-emerald-600 hover:underline">Daftar sekarang</a>
                </p>
                <p class="text-[13px] text-slate-500 mt-3">
                    Membutuhkan bantuan? Hubungi layanan UniHealth
                </p>
            </div>
        </form>

    </div>

</body>
</html>