<div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-8">
    <div class="mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-[20px] font-bold text-slate-800">{{ $title }}</h2>
        @if(isset($subtitle))
            <p class="text-[14px] text-slate-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    
    <form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" {{ $attributes }}>
        @csrf
        @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method(strtoupper($method))
        @endif
        
        <div class="space-y-6">
            {{ $slot }}
        </div>
        
        <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ $backUrl }}" class="px-6 py-2.5 rounded-[12px] text-slate-600 bg-slate-100 hover:bg-slate-200 font-medium text-[14px] transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-[12px] text-white bg-slate-500 hover:bg-slate-600 font-medium text-[14px] transition-colors shadow-sm">
                {{ $submitLabel ?? 'Simpan Data' }}
            </button>
        </div>
    </form>
</div>
