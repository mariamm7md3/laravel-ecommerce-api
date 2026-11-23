@props([
    'name',
    'value' => ''
])

<textarea

    id="{{ $name }}"
    name="{{ $name }}"

    rows="4"

    {{ $attributes->merge([
        'class' => 'form-control'
    ]) }}

>{{ old($name,$value) }}</textarea>
