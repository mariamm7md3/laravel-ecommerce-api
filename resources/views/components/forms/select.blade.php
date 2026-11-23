@props([
    'name'
])

<select

    id="{{ $name }}"
    name="{{ $name }}"

    {{ $attributes->merge([
        'class' => 'form-select'
    ]) }}

>

    {{ $slot }}

</select>
