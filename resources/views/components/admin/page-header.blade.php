@props([
    'title',
    'subtitle' => null,
    'action' => null,
    'actionUrl' => null,
    'actionLabel' => 'Tambah Data'
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex-1 min-w-0">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 truncate">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    
    @if($action && $actionUrl)
        <div class="flex-shrink-0">
            @if($action === 'link')
                <a href="{{ $actionUrl }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ $actionLabel }}
                </a>
            @endif
        </div>
    @endif
</div>
