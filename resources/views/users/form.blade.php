@php
    $isEdit = isset($user);
@endphp

<div class="row gx-5">

    {{-- Left --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('users.user_information') }}</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('users.first_name') }}" name="first_name" required>
                            <x-forms.input
                                name="first_name"
                                :value="old('first_name', $user->first_name ?? '')"
                                placeholder="{{ __('users.first_name_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('users.last_name') }}" name="last_name" required>
                            <x-forms.input
                                name="last_name"
                                :value="old('last_name', $user->last_name ?? '')"
                                placeholder="{{ __('users.last_name_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('users.email') }}" name="email" required>
                            <x-forms.input
                                type="email"
                                name="email"
                                :value="old('email', $user->email ?? '')"
                                placeholder="{{ __('users.email_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('users.phone') }}" name="phone">
                            <x-forms.input
                                name="phone"
                                :value="old('phone', $user->phone ?? '')"
                                placeholder="{{ __('users.phone_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('users.date_of_birth') }}" name="date_of_birth">
                            <x-forms.input
                                type="date"
                                name="date_of_birth"
                                :value="old('date_of_birth', $user->date_of_birth ?? '')"
                            />
                        </x-forms.field>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('users.gender') }}</label>
                        @php
                            $selectedGender = old('gender', $isEdit ? $user->gender->value : '');
                        @endphp
                        <div class="list-group">
                            <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                <input
                                    type="radio"
                                    name="gender"
                                    value="male"
                                    class="form-check-input m-0"
                                    {{ $selectedGender == 'male' ? 'checked' : '' }}
                                >
                                {{ __('users.male') }}
                            </label>
                            <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                <input
                                    type="radio"
                                    name="gender"
                                    value="female"
                                    class="form-check-input m-0"
                                    {{ $selectedGender == 'female' ? 'checked' : '' }}
                                >
                                {{ __('users.female') }}
                            </label>
                        </div>
                        @error('gender')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $isEdit ? __('users.change_password') : __('users.password') }}</h5>
            </div>
            <div class="card-body">
                @if($isEdit)
                    <p class="text-muted small mb-3">{{ __('users.leave_empty_password') }}</p>
                @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ $isEdit ? __('users.new_password') : __('users.password') }}" name="password" :required="!$isEdit">
                            <x-forms.input
                                type="password"
                                name="password"
                                placeholder="{{ $isEdit ? __('users.new_password_placeholder') : __('users.password_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-forms.field label="{{ __('users.confirm_password') }}" name="password_confirmation" :required="!$isEdit">
                            <x-forms.input
                                type="password"
                                name="password_confirmation"
                                placeholder="{{ $isEdit ? __('users.confirm_new_password_placeholder') : __('users.confirm_password_placeholder') }}"
                            />
                        </x-forms.field>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('users.photo') }}</h5>
            </div>

            <div class="card-body">
                <div class="text-center">
                    <div
                        id="image-preview-photo"
                        class="border border-2 border-dashed rounded d-flex flex-column justify-content-center align-items-center overflow-hidden mb-3"
                        style="height:250px; cursor:pointer;"
                    >
                        <div id="placeholder-photo" class="text-center {{ ($isEdit && $user->photo) ? 'd-none' : '' }}">
                            <i class="ti ti-photo fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">{{ __('users.click_upload_photo') }}</p>
                        </div>

                        <img
                            id="preview-image-photo"
                            src="{{ $isEdit ? $user->photo_url : '' }}"
                            class="w-100 h-100 {{ ($isEdit && $user->photo) ? '' : 'd-none' }}"
                            style="object-fit: cover;"
                            alt="Preview"
                        >
                    </div>

                    <input type="file" name="photo" id="photo" class="d-none" accept="image/*">

                    @if($isEdit)
                        <small class="text-muted d-block">{{ __('users.click_change_photo') }}</small>
                    @endif

                    @error('photo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

</div>
