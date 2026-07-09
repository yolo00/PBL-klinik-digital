<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - UniHealth</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app-T3EHGAm9.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-100 flex items-center justify-center p-6 py-12 bg-fixed">
    <div class="w-full max-w-[600px] rounded-[40px] bg-white/90 backdrop-blur-xl p-10 px-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative">
        <!-- Back Button -->
        <a href="/" class="absolute top-8 left-8 flex items-center justify-center w-10 h-10 rounded-full bg-slate-50 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-slate-200 hover:border-emerald-200 shadow-sm group" title="Kembali ke Beranda">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-0.5 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
        </a>

        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="UniHealth Logo" class="w-14 h-14 rounded-[18px] shadow-sm">
        </div>
        
        <p class="text-center text-[13px] font-bold tracking-[0.2em] text-emerald-600 mb-2 uppercase">Pendaftaran Akun Pasien</p>
        <h1 class="text-center text-[36px] font-bold text-slate-800 mb-4 tracking-tight">Daftar untuk Menggunakan UniHealth</h1>
        <p class="text-center text-[15px] font-medium text-slate-500 mb-8 max-w-sm mx-auto">Akses layanan kesehatan, jadwal pemeriksaan, dan janji temu dengan tenaga medis secara mudah melalui UniHealth.</p>
        
        <form action="{{ route('register.submit') }}" method="POST" class="space-y-5">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-[20px] text-[13px] font-medium border border-red-100 shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- Nama --}}
            <div class="col-span-2 md:col-span-1">
                <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" maxlength="100" pattern="[A-Za-zÀ-ÿ\s]+" title="Nama hanya boleh berisi huruf, spasi, titik, apostrof, dan tanda hubung" required placeholder="Masukkan nama lengkap"
                    class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-3.5 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30" />
            </div>

            {{-- Email --}}
            <div class="col-span-2 md:col-span-1">
                <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" maxlength="100" required 
                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Format email tidak valid. Harus mengandung domain (contoh: user@example.com)" 
                    placeholder="Masukkan alamat email"
                    class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-3.5 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30" />
            </div>


            {{-- Tanggal Lahir --}}
            <div>
                <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Tanggal Lahir</label>
                <input type="text" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}" required placeholder="Pilih tanggal lahir"
                    class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-3.5 text-[15px] text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30 cursor-pointer" />
            </div>

            {{-- Jenis Kelamin & No HP --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-2 md:col-span-1">
                    <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Jenis Kelamin</label>
                    <div class="flex gap-6 items-center h-[54px] px-4 py-[11px] bg-slate-50 rounded-[20px] border border-slate-200 shadow-sm">
                        <label class="flex items-center gap-2 cursor-pointer relative">
                            <input type="radio" name="jenis_kelamin" value="L" class="peer sr-only" required {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 bg-white transition-colors flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            </div>
                            <span class="text-[13px] font-medium text-slate-700">Laki-Laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer relative">
                            <input type="radio" name="jenis_kelamin" value="P" class="peer sr-only" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 bg-white transition-colors flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            </div>
                            <span class="text-[13px] font-medium text-slate-600">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Nomor Kontak</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" maxlength="15" inputmode="numeric" pattern="[0-9]+" title="Nomor telepon hanya boleh berisi angka" required placeholder="Masukkan nomor telepon"
                        class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-3.5 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30" />
                </div>
            </div>

            {{-- Password --}}
            
            <div class="col-span-2 md:col-span-1">
                <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required placeholder="Buat kata sandi Anda" maxlength="100" oncopy="return false" oncut="return false" onpaste="return false"
                        class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-3.5 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30" />
                    <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors" onclick="const p=this.previousElementSibling; p.type=p.type==='password'?'text':'password';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                <p class="mt-1 text-xs text-slate-600">
                    Kata sandi harus berisi minimal 6 karakter.
                </p>
            </div>
            

            <div class="col-span-2 md:col-span-1">
                <label class="mb-1.5 block text-[15px] font-semibold text-slate-700">Konfirmasi Sandi</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Masukkan ulang kata sandi" maxlength="100" oncopy="return false" oncut="return false" onpaste="return false"
                        class="w-full rounded-[20px] border border-slate-200 bg-slate-50 px-5 py-3.5 text-[15px] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all shadow-sm focus:shadow-md focus:shadow-emerald-500/30" />
                    <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors" onclick="const p=this.previousElementSibling; p.type=p.type==='password'?'text':'password';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            

            <div class="pt-6">
                <button type="submit" id="btn-daftar"
                    class="w-full md:w-[70%] mx-auto block rounded-[20px] bg-emerald-600 px-5 py-4 text-[16px] font-bold text-white hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/30 transition-all shadow-lg shadow-emerald-500/25 transform hover:-translate-y-0.5">
                    Buat Akun Pasien
                </button>
            </div>
            
            <div class="text-center mt-6">
                <p class="text-[14px] text-slate-600 font-medium">Sudah memiliki akun? <a href="/login" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">Masuk di sini</a></p>
                <p class="text-[13px] text-slate-500 font-semibold mt-3 hover:text-emerald-600 cursor-pointer transition-colors">Membutuhkan bantuan? Hubungi Kami</p>
            </div>
        </form>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tgl_lahir", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                maxDate: "today",
                disableMobile: "true"
            });
        });
    </script>
</body>
</html>
