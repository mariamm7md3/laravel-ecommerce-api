@php
    $isEdit = isset($category);
@endphp

<div class="row gx-5">

    {{-- Left --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('categories.category_information') }}</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Name EN --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('categories.name_en') }}" name="name[en]" required>
                            <x-forms.input
                                name="name[en]"
                                :value="old('name.en', $category->name['en'] ?? '')"
                                placeholder="{{ __('categories.name_en_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>

                    {{-- Name AR --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('categories.name_ar') }}" name="name[ar]" required>
                            <x-forms.input
                                name="name[ar]"
                                :value="old('name.ar', $category->name['ar'] ?? '')"
                                placeholder="{{ __('categories.name_ar_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>
                </div>

                <div class="row">
                    {{-- Description EN --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('categories.description_en') }}" name="description[en]" required>
                            <x-forms.textarea
                                name="description[en]"
                                rows="5"
                                placeholder="{{ __('categories.description_en_placeholder') }}"
                                :value="old('description.en', $category->description['en'] ?? '')"
                            />
                        </x-forms.field>
                    </div>

                    {{-- Description AR --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('categories.description_ar') }}" name="description[ar]" required>
                            <x-forms.textarea
                                name="description[ar]"
                                rows="5"
                                placeholder="{{ __('categories.description_ar_placeholder') }}"
                                :value="old('description.ar', $category->description['ar'] ?? '')"
                            />
                        </x-forms.field>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('categories.category_image') }}</h5>
            </div>

            <div class="card-body">
                <div class="text-center">
                    <div
                        id="image-preview"
                        class="border border-2 border-dashed rounded d-flex flex-column justify-content-center align-items-center overflow-hidden mb-3"
                        style="height:300px; cursor:pointer;"
                    >
                        <div id="placeholder" class="text-center {{ ($isEdit && $category->icon) ? 'd-none' : '' }}">
                            <i class="ti ti-photo fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">{{ __('categories.click_upload_image') }}</p>
                        </div>

                        <img
                            id="preview-image"
                            src="{{ $isEdit ? $category->icon_url : '' }}"
                            class="w-100 h-100 {{ ($isEdit && $category->icon) ? '' : 'd-none' }}"
                            style="object-fit: cover;"
                            alt="Preview"
                        >
                    </div>

                    <input type="file" name="icon" id="icon" class="d-none" accept="image/*">

                    @if($isEdit)
                        <small class="text-muted d-block">{{ __('categories.click_change_image') }}</small>
                    @endif

                    @error('icon')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

</div>
