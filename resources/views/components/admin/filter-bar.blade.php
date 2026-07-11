@props([
    'action',
    'searchPlaceholder' => 'Cari...',
    'resetUrl' => null,
    'searchName' => 'search'
])

<form method="GET" action="{{ $action }}" class="space-y-4 mb-6">
    <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
        <input 
            type="text" 
            name="{{ $searchName }}" 
            value="{{ request($searchName) }}" 
            placeholder="{{ $searchPlaceholder }}"
            class="flex-1 px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
        >
        
        <div class="flex gap-2 flex-wrap sm:flex-nowrap">
            {{ $slot }}
            
            <button 
                type="submit" 
                class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm"
            >
                Cari
            </button>
            
            @if($resetUrl)
                <a 
                    href="{{ $resetUrl }}" 
                    class="flex-1 sm:flex-none px-6 py-3 bg-slate-200 text-slate-700 font-medium rounded-xl hover:bg-slate-300 transition-colors"
                >
                    Reset
                </a>
            @endif
        </div>
    </div>
</form>
