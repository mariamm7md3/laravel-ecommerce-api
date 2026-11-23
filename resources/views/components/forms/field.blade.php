@props([
    'label',
    'name',
    'required' => false
])

<div class="mb-4">

    <label
        for="{{ $name }}"
        class="form-label fw-semibold"
    >
        {{ $label }}

        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    {{ $slot }}

    <x-forms.error :name="$name"/>
</div>
