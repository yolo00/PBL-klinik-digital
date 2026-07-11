@props([
    'type' => 'slate',
    'text' => ''
])

@php
    $typeMap = [
        'success' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
        'danger' => 'bg-rose-100 text-rose-700 border border-rose-200',
        'warning' => 'bg-amber-100 text-amber-700 border border-amber-200',
        'info' => 'bg-blue-100 text-blue-700 border border-blue-200',
        'slate' => 'bg-slate-100 text-slate-700 border border-slate-200',
    ];
    $badgeClass = $typeMap[$type] ?? $typeMap['slate'];
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
    {{ $text ?: $slot }}
</span>
