@props(['label', 'value' => '—'])
<div class="flex flex-col gap-1">
    <p class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">{{ $label }}</p>
    <p class="text-[15px] font-medium text-slate-800">{{ $value ?: '—' }}</p>
</div>