@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white shadow-sm ' . $class]) }}>
    {{ $slot }}
</div>