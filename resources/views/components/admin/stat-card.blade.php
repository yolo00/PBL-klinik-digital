@props([
    'label',
    'value',
    'icon' => null,
    'color' => 'blue',
    'trend' => null
])

@php
    $colorMap = [
        'blue' => 'bg-blue-50 border-blue-200',
        'emerald' => 'bg-emerald-50 border-emerald-200',
        'amber' => 'bg-amber-50 border-amber-200',
        'rose' => 'bg-rose-50 border-rose-200',
        'slate' => 'bg-slate-50 border-slate-200'
    ];
    $bgClass = $colorMap[$color] ?? $colorMap['slate'];
@endphp

<div class="bg-white rounded-xl border border-slate-200 p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <p class="text-sm text-slate-500 font-medium mb-1">{{ $label }}</p>
            <p class="text-3xl md:text-4xl font-bold text-slate-800">{{ $value }}</p>
            @if($trend)
                <p class="text-xs {{ strpos($trend, '+') === 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-2">{{ $trend }}</p>
            @endif
        </div>
        @if($icon)
            <div class="flex-shrink-0">
                <div class="{{ $bgClass }} w-12 h-12 rounded-xl flex items-center justify-center">
                    {!! $icon !!}
                </div>
            </div>
        @endif
    </div>
</div>
