@props([
    'title' => null,
    'subtitle' => null,
    'badge' => null,
    'badgeType' => 'slate'
])

<div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
    @if($title)
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-6 border-b border-slate-100">
            <div class="flex-1 min-w-0">
                <h2 class="text-lg md:text-xl font-bold text-slate-800 truncate">{{ $title }}</h2>
                @if($subtitle)
                    <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p>
                @endif
            </div>
            @if($badge)
                <div class="flex-shrink-0">
                    <x-admin.badge :type="$badgeType" :text="$badge" />
                </div>
            @endif
        </div>
    @endif
    
    {{ $slot }}
</div>
