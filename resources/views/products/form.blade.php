@php
    $isEdit = isset($product);
@endphp

<div class="row gx-5">

    {{-- Left --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('products.product_information') }}</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Name EN --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('products.name_en') }}" name="name[en]" required>
                            <x-forms.input
                                name="name[en]"
                                :value="old('name.en', $product->name['en'] ?? '')"
                                placeholder="{{ __('products.name_en_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>

                    {{-- Name AR --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('products.name_ar') }}" name="name[ar]" required>
                            <x-forms.input
                                name="name[ar]"
                                :value="old('name.ar', $product->name['ar'] ?? '')"
                                placeholder="{{ __('products.name_ar_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>
                </div>

                <div class="row">
                    {{-- Description EN --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('products.description_en') }}" name="description[en]" required>
                            <x-forms.textarea
                                name="description[en]"
                                rows="5"
                                placeholder="{{ __('products.description_en_placeholder') }}"
                                :value="old('description.en', $product->description['en'] ?? '')"
                            />
                        </x-forms.field>
                    </div>

                    {{-- Description AR --}}
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('products.description_ar') }}" name="description[ar]" required>
                            <x-forms.textarea
                                name="description[ar]"
                                rows="5"
                                placeholder="{{ __('products.description_ar_placeholder') }}"
                                :value="old('description.ar', $product->description['ar'] ?? '')"
                            />
                        </x-forms.field>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('products.organization') }}</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Industry --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('products.industry') }}</label>

                        <div class="list-group" style="max-height: 220px; overflow-y: auto;">
                            @foreach($industries as $industry)
                                <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                    <input
                                        type="radio"
                                        name="industry_id"
                                        value="{{ $industry->id }}"
                                        class="form-check-input m-0"
                                        {{ old('industry_id', $product->industry_id ?? '') == $industry->id ? 'checked' : '' }}
                                    >
                                    {{ $industry->name[app()->getLocale()] }}
                                </label>
                            @endforeach
                        </div>

                        @error('industry_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Categories --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('products.categories') }}</label>

                        @php
                            $selectedCategories = old('categories', $isEdit ? $product->categories->pluck('id')->toArray() : []);
                        @endphp

                        <div class="list-group" style="max-height: 220px; overflow-y: auto;">
                            @foreach($categories as $category)
                                <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                    <input
                                        type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->id }}"
                                        class="form-check-input m-0"
                                        {{ collect($selectedCategories)->contains($category->id) ? 'checked' : '' }}
                                    >
                                    {{ $category->name[app()->getLocale()] }}
                                </label>
                            @endforeach
                        </div>

                        @error('categories')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('products.product_image') }}</h5>
            </div>

            <div class="card-body">
                <div class="text-center">
                    <div
                        id="image-preview"
                        class="border border-2 border-dashed rounded d-flex flex-column justify-content-center align-items-center overflow-hidden mb-3"
                        style="height:300px; cursor:pointer;"
                    >
                        <div id="placeholder" class="text-center {{ ($isEdit && $product->photo) ? 'd-none' : '' }}">
                            <i class="ti ti-photo fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">{{ __('products.click_upload_image') }}</p>
                        </div>

                        <img
                            id="preview-image"
                            src="{{ $isEdit ? $product->photo_url : '' }}"
                            class="w-100 h-100 {{ ($isEdit && $product->photo) ? '' : 'd-none' }}"
                            style="object-fit: cover;"
                            alt="Preview"
                        >
                    </div>

                    <input type="file" name="photo" id="photo" class="d-none" accept="image/*">

                    @if($isEdit)
                        <small class="text-muted d-block">{{ __('products.click_change_image') }}</small>
                    @endif

                    @error('photo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Price --}}
        <div class="card">
            <div class="card-body">
                <x-forms.field label="{{ __('products.price_optional') }}" name="price">
                    <x-forms.input
                        type="number"
                        name="price"
                        :value="old('price', $product->price ?? '')"
                        placeholder="{{ __('products.price_placeholder') }}"
                        step="0.01"
                    />
                </x-forms.field>
                <small class="text-muted d-block mt-1">
                    {{ __('products.price_hint') }}
                </small>
                @error('price')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
