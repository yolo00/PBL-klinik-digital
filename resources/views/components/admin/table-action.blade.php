<div class="flex items-center justify-center gap-2">
    @if(isset($viewUrl))
        <a href="{{ $viewUrl }}" class="px-5 py-2 rounded-full bg-gray-200 hover:bg-slate-100 hover:text-slate-700 text-slate-700 text-[13px] transition-colors shadow-sm">Lihat</a>
    @endif
    
    @if(isset($editUrl))
        <a href="{{ $editUrl }}" class="px-5 py-2 rounded-full bg-gray-200 hover:bg-blue-100 hover:text-blue-700 text-slate-700 text-[13px] transition-colors shadow-sm">Edit</a>
    @endif
    
    @if($showDelete ?? true)
        <button type="button" class="px-5 py-2 rounded-full bg-gray-200 hover:bg-rose-100 hover:text-rose-700 text-slate-700 text-[13px] transition-colors shadow-sm">Hapus</button>
    @endif
</div>
