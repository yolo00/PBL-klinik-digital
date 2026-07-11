@props([
    'name' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Pilih...',
    'hasError' => false
])

<select 
    name="{{ $name }}"
    class="w-full px-4 py-3 rounded-lg border {{ $hasError ? 'border-rose-400 focus:ring-rose-500/20' : 'border-slate-200 focus:ring-blue-500/20' }} focus:outline-none focus:ring-2 focus:border-transparent transition text-sm text-slate-700 appearance-none bg-white cursor-pointer"
    {{ $attributes }}
>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    
    @if(is_array($options))
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    @else
        {{ $slot }}
    @endif
</select>
