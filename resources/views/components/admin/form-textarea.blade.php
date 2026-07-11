@props([
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'hasError' => false
])

<textarea 
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    rows="{{ $rows }}"
    class="w-full px-4 py-3 rounded-lg border {{ $hasError ? 'border-rose-400 focus:ring-rose-500/20' : 'border-slate-200 focus:ring-blue-500/20' }} focus:outline-none focus:ring-2 focus:border-transparent transition text-sm text-slate-700 resize-vertical"
    {{ $attributes }}
>{{ $value ?? old($name) }}</textarea>
