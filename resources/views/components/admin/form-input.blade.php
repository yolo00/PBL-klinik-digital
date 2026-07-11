@props([
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'hasError' => false
])

<input 
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value ?? old($name) }}"
    placeholder="{{ $placeholder }}"
    class="w-full px-4 py-3 rounded-lg border {{ $hasError ? 'border-rose-400 focus:ring-rose-500/20' : 'border-slate-200 focus:ring-blue-500/20' }} focus:outline-none focus:ring-2 focus:border-transparent transition text-sm text-slate-700"
    {{ $attributes }}
/>
