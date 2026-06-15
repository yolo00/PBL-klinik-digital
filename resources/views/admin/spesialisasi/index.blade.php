@extends('admin.layouts.app')
@section('title', 'Manajemen Spesialisasi')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-[20px] font-bold text-slate-800">Daftar Spesialisasi</h2>
                <p class="text-[13px] text-slate-500 mt-0.5">Kelola data spesialisasi dokter dan biaya dasar konsultasi.</p>
            </div>
            <a href="{{ route('admin.spesialisasi.create') }}" class="px-5 py-2.5 bg-slate-500 text-white font-medium rounded-[12px] text-[14px] hover:bg-slate-600 transition-colors shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Spesialisasi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[13px] text-slate-500 font-semibold uppercase tracking-wide border-b border-slate-100 bg-slate-50">
                        <th class="px-6 py-4 rounded-tl-xl">ID</th>
                        <th class="px-6 py-4">Nama Spesialisasi</th>
                        <th class="px-6 py-4">Biaya Dasar</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-slate-800 font-medium divide-y divide-slate-50">
                    @forelse($spesialisasis as $sp)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-400 font-mono">#{{ $sp->id }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $sp->nama }}</td>
                        <td class="px-6 py-4 tabular-nums">Rp {{ number_format($sp->base_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.spesialisasi.edit', $sp) }}" class="px-4 py-1.5 rounded-full bg-gray-200 hover:bg-blue-100 hover:text-blue-700 text-slate-700 text-[13px] transition-colors shadow-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.spesialisasi.destroy', $sp) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus spesialisasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-1.5 rounded-full bg-gray-200 hover:bg-rose-100 hover:text-rose-700 text-slate-700 text-[13px] transition-colors shadow-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada data spesialisasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
