@extends('pasien.layouts.app')
@section('title', 'Pembayaran')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('pasien.riwayat') }}" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Pembayaran</h3>
    </div>
    <p class="text-slate-500 mb-8">Mohon selesaikan pembayaran untuk dapat memulai konsultasi</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col items-center">
            <p class="text-sm font-bold text-slate-700 mb-6 uppercase tracking-wider">Pindai kode QR ini untuk melakukan pembayaran</p>
            
            <div class="bg-slate-50 p-6 rounded-2xl border-2 border-dashed border-slate-200 mb-8">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=UniHealth-Payment-0020102040ID" alt="QR Code Pembayaran" class="w-56 h-56">
            </div>

            <div class="w-full bg-blue-50 rounded-2xl p-6 border border-blue-100">
                <p class="text-xs font-bold text-blue-800 mb-3 uppercase tracking-widest text-center">Butuh Bantuan?</p>
                <p class="text-xs text-blue-600 text-center mb-4 leading-relaxed">Hubungi kami jika mengalami kendala pembayaran</p>
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-center gap-2 text-sm font-bold text-blue-800">
                        <span>WhatsApp: 0871-2345-6789</span>
                    </div>
                    <div class="flex items-center justify-center gap-2 text-sm font-bold text-blue-800">
                        <span>Email: health67@gmail.com</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="bg-slate-100/80 rounded-3xl p-6 border border-slate-200">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nominal</p>
                <h4 class="text-2xl font-black text-slate-900 mb-4">Rp 50.000</h4>
                
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kode payment :</p>
                <p class="text-[11px] font-mono text-slate-600 mb-4 break-all">0020102040ID.w.bpk.www.593502</p>

                <div class="flex justify-between items-center bg-white/50 p-3 rounded-xl">
                    <p class="text-[10px] font-bold text-slate-500">Sisa Waktu</p>
                    <p class="text-sm font-black text-red-500">59:32</p>
                </div>
            </div>

            <div class="bg-slate-100/80 rounded-3xl p-6 border border-slate-200">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Jadwal</p>
                
                <div class="mb-4">
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Tanggal dan Sesi</p>
                    <p class="text-sm font-bold text-slate-800">8 April 2026 . 11.00 WIB</p>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Dokter</p>
                    <p class="text-sm font-bold text-slate-800">Dr. Fenni | Dokter umum</p>
                </div>
            </div>

            <button class="w-full bg-emerald-500 hover:bg-emerald-600 py-4 rounded-2xl text-white font-bold text-sm shadow-lg shadow-emerald-100 transition duration-300 transform hover:-translate-y-1">
                SAYA SUDAH BAYAR
            </button>
        </div>
    </div>
</div>
@endsection