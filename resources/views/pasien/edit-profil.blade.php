@extends('pasien.layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xl font-bold text-emerald-950">Informasi Pribadi</h2>
            <p class="text-sm text-slate-500">Perbarui foto dan informasi profil medis Anda secara lengkap.</p>
        </div>

        <form action="{{ route('pasien.profil.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            {{-- Bagian Edit Foto Profil --}}
            <div class="flex flex-col items-center mb-10">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-emerald-50 shadow-md">
                        <img id="preview-foto" src="https://ui-avatars.com/api/?name=Aprillia+Bunga&background=059669&color=fff&size=128" 
                             alt="Profile" class="w-full h-full object-cover">
                    </div>
                    <label for="foto-input" class="absolute inset-0 flex items-center justify-center bg-emerald-950/40 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-300">
                        <i class="fa-solid fa-camera text-white text-2xl"></i>
                    </label>
                    <input type="file" id="foto-input" name="foto_profil" class="hidden" accept="image/*" onchange="previewImage(this)">
                </div>
                <p class="mt-3 text-xs text-slate-400">Klik foto untuk mengganti (Max: 2MB)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="Aprillia Bunga" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                    <div class="flex gap-4 mt-3">
                        <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" class="text-emerald-600 focus:ring-emerald-500"> Laki-laki
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" class="text-emerald-600 focus:ring-emerald-500"> Perempuan
                        </label>
                    </div>
                </div>

                {{-- Tempat & Tanggal Lahir --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Contoh: Muntok"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="aprillia.bunga@student.polibatam.ac.id" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- No WhatsApp --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">No. WhatsApp / HP</label>
                    <input type="text" name="no_hp" placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Golongan Darah --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                    <select name="golongan_darah" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="" disabled selected>Pilih Golongan Darah</option>
                        <option value="A+">A + (Rhesus Positif)</option>
                        <option value="A-">A - (Rhesus Negatif)</option>
                        <option value="B+">B + (Rhesus Positif)</option>
                        <option value="B-">B - (Rhesus Negatif)</option>
                        <option value="AB+">AB + (Rhesus Positif)</option>
                        <option value="AB-">AB - (Rhesus Negatif)</option>
                        <option value="O+">O + (Rhesus Positif)</option>
                        <option value="O-">O - (Rhesus Negatif)</option>
                        <option value="TIDAK_TAHU">Belum Tahu / Belum Cek</option>
                    </select>
                </div>

                {{-- Pekerjaan --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" placeholder="Contoh: Karyawan, Wiraswasta"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

                {{-- Alamat Lengkap --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap Domisili</label>
                    <textarea name="alamat" rows="2" placeholder="Tuliskan alamat lengkap saat ini..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition"></textarea>
                </div>

                {{-- Alergi & Riwayat Penyakit --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alergi (Obat/Makanan)</label>
                    <textarea name="alergi" rows="2" placeholder="Sebutkan alergi jika ada..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Riwayat Penyakit Kronis</label>
                    <textarea name="riwayat_penyakit" rows="2" placeholder="Misal: Asma, Diabetes, Jantung..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition"></textarea>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-end gap-4">
                <a href="{{ route('pasien.dashboard') }}" class="px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-800 transition">Batal</a>
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
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-foto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 2500,
            customClass: {
                popup: 'rounded-3xl',
            }
        });
    @endif
</script>
@endpush
@endsection