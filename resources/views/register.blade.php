@extends('layouts.app')

@section('title', 'Daftar | UniHealth')

@section('content')
    <section class="mx-auto max-w-lg rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="space-y-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Bergabung dengan UniHealth</p>
                <h1 class="mt-3 text-3xl font-bold text-slate-900">Buat akun baru</h1>
                <p class="mt-3 text-slate-600">Daftarkan diri Anda sebagai pasien klinik kampus dan mulai kelola janji temu Anda.</p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="mb-2 block text-sm font-medium text-slate-700">Nama Depan</label>
                        <input id="first_name" name="first_name" type="text" placeholder="Nama depan" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                    </div>
                    <div>
                        <label for="last_name" class="mb-2 block text-sm font-medium text-slate-700">Nama Belakang</label>
                        <input id="last_name" name="last_name" type="text" placeholder="Nama belakang" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                    </div>
                </div>

                <div>
                    <label for="nim" class="mb-2 block text-sm font-medium text-slate-700">NIM (Nomor Induk Mahasiswa)</label>
                    <input id="nim" name="nim" type="text" placeholder="Contoh: 20210001" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                </div>

                <div>
                    <label for="reg_email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email</label>
                    <input id="reg_email" name="email" type="email" placeholder="anda@kampus.ac.id" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" />
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Nomor Telepon</label>
                    <input id="phone" name="phone" type="tel" placeholder="08xxxxxxxxxx" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" />
                </div>

                <div>
                    <label for="reg_password" class="mb-2 block text-sm font-medium text-slate-700">Kata Sandi</label>
                    <input id="reg_password" name="password" type="password" placeholder="Buat kata sandi (min. 8 karakter)" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi kata sandi Anda" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                </div>

                <button type="submit" class="w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Daftar Sekarang</button>
            </form>

            <p class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Masuk di sini</a>
            </p>
        </div>
    </section>
@endsection
