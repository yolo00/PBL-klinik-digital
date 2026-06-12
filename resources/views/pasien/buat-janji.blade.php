@extends('pasien.layouts.app')
@section('title', 'Buat Janji Temu')
@section('content')

    <section class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">Buat Janji Temu</h1>
        <p class="text-gray-500 text-lg">Silakan pilih dokter, tanggal, dan waktu kunjungan Anda.</p>
    </section>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-2xl">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('pasien.store_jadwal') }}" method="POST" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-10">
        @csrf 
        
        {{-- 1. DROPDOWN BARU: FILTER SPESIALISASI --}}
        <div class="space-y-4">
            <label class="block text-lg font-bold text-gray-800">🩺 Pilih Jenis Dokter (Spesialisasi)</label>
            <select id="id_spesialisasi" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none">
                <option value="all">Semua Spesialisasi / Jenis Dokter</option>
                @foreach($spesialisasis as $spesialis)
                    <option value="{{ $spesialis->id }}">
                        {{ $spesialis->nama_spesialisasi ?? ($spesialis->nama ?? 'Spesialis') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 2. DROPDOWN SEBELUMNYA (Diberikan id="id_dokter") --}}
        <div class="space-y-4">
            <label class="block text-lg font-bold text-gray-800">👤 Pilih Dokter</label>
            <select name="id_dokter" id="id_dokter" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none" required>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}">
                        {{ $dokter->user->nama ?? ($dokter->user->name ?? 'Dokter Tanpa Nama') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800">📅 Pilih Tanggal</label>
                <input type="date" name="tanggal" required class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none">
            </div>

            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-800">⏰ Pilih Waktu</label>
                <select name="jam" class="w-full p-5 bg-gray-50 border border-gray-200 rounded-2xl outline-none" required>
                    @for($i = 8; $i <= 16; $i++)
                        <option value="{{ $i }}">{{ $i }}:00 WIB</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="pt-10 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-8 rounded-3xl gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Biaya Pendaftaran</p>
                <p class="text-3xl font-black text-gray-900">Rp75.000</p>
            </div>
            <button type="submit" class="w-full md:w-auto bg-slate-500 text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-blue-600 transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-3">
                📅 Daftar Jadwal Sekarang
            </button>
        </div>
    </form>

    {{-- SCRIPT JAVASCRIPT AJAX UNTUK PROSES FILTER DINAMIS --}}
    <script>
        document.getElementById('id_spesialisasi').addEventListener('change', function() {
            const spesialisasiId = this.value;
            const dokterSelect = document.getElementById('id_dokter');
            
            // Set status memuat data biar user tahu sistem sedang bekerja
            dokterSelect.innerHTML = '<option value="">Memuat daftar dokter...</option>';
            
            // Panggil API route Laravel menggunakan Fetch API secara async
            fetch(`/pasien/get-dokter/${spesialisasiId}`)
                .then(response => response.json())
                .then(data => {
                    dokterSelect.innerHTML = ''; // Kosongkan placeholder memuat data
                    
                    if (data.length === 0) {
                        dokterSelect.innerHTML = '<option value="">Tidak ada dokter untuk spesialisasi ini</option>';
                        return;
                    }
                    
                    // Masukkan data dokter hasil filter ke dalam opsi select baru
                    data.forEach(dokter => {
                        const option = document.createElement('option');
                        option.value = dokter.id;
                        option.textContent = dokter.nama;
                        dokterSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    dokterSelect.innerHTML = '<option value="">Gagal mengambil data dokter</option>';
                });
        });
    </script>
@endsection