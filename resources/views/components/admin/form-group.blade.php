@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'helpText' => null,
    'error' => false,
    'fullWidth' => false
])

@php
    $containerClass = $fullWidth ? 'md:col-span-2' : '';
@endphp

<div class="space-y-2 {{ $containerClass }}">
    @if($label)
        <label class="text-sm font-medium text-slate-700 block">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
            @if($helpText)
                <span class="text-slate-400 text-xs ml-1">({{ $helpText }})</span>
            @endif
        </label>
    @endif
    
    {{ $slot }}
    
    @if($error && $errors->has($name))
        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 14.586l-6.687-6.687a1 1 0 00-1.414 1.414l8.1 8.1a1 1 0 001.414 0l10.1-10.1z" clip-rule="evenodd"/></path></svg>
            {{ $errors->first($name) }}
        </p>
    @endif
</div>
