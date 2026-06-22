@extends('pasien.layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xl font-bold text-emerald-950">Informasi Pribadi</h2>
            <p class="text-sm text-slate-500">Perbarui informasi profil dan data medis Anda.</p>
        </div>

        <form action="{{ route('pasien.profil.update') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                    <div class="flex gap-4 mt-3">
                        <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" {{ $user->jenis_kelamin == 'L' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500"> Laki-laki
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" {{ $user->jenis_kelamin == 'P' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500"> Perempuan
                        </label>
                    </div>
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $user->tgl_lahir) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- No WhatsApp --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">No. WhatsApp / HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Golongan Darah --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                    <select name="gol_darah" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="" disabled {{ !isset($pasien->gol_darah) ? 'selected' : '' }}>Pilih Golongan Darah</option>
                        @foreach(['A', 'B', 'AB', 'O'] as $gol)
                            <option value="{{ $gol }}" {{ ($pasien->gol_darah ?? '') == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Alergi & Riwayat Penyakit (SUDAH AMAN & BEBAS CRASH) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alergi (Pisahkan dengan koma, contoh: Debu, Kacang, Udang)</label>
                    <textarea name="alergi" rows="2" placeholder="Sebutkan alergi jika ada..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('alergi', ($pasien && $pasien->alergi) ? $pasien->alergi->pluck('nama_alergi')->implode(', ') : '') }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Riwayat Penyakit Kronis</label>
                    <textarea name="riwayat_penyakit" rows="2" placeholder="Misal: Asma, Diabetes, Jantung..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('riwayat_penyakit', $pasien->riwayat_penyakit ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-end gap-4">
                <a href="{{ route('pasien.profil') }}" class="px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="px-10 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 2500,
            customClass: { popup: 'rounded-3xl' }
        });
    @endif
</script>
@endpush
@endsection