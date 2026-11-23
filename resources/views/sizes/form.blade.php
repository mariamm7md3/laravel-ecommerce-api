@php
    $isEdit = isset($size);
@endphp

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <x-forms.field label="{{ __('sizes.name_en') }}" name="name[en]" required>
                    <x-forms.input
                        name="name[en]"
                        :value="old('name.en', $size->name['en'] ?? '')"
                        placeholder="{{ __('sizes.name_en_placeholder') }}"
                    />
                </x-forms.field>
            </div>

            <div class="col-md-6 mb-3">
                <x-forms.field label="{{ __('sizes.name_ar') }}" name="name[ar]" required>
                    <x-forms.input
                        name="name[ar]"
                        :value="old('name.ar', $size->name['ar'] ?? '')"
                        placeholder="{{ __('sizes.name_ar_placeholder') }}"
                    />
                </x-forms.field>
            </div>
        </div>
    </div>
</div>
