@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'overflow-x-auto ' . $class]) }}>
    {{ $slot }}
</div>