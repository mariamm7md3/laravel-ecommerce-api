<x-layouts.admin title="Add Address">

    <form method="POST" action="{{ route('address.store', $user) }}">
        @csrf


        <div class="d-flex justify-content-between align-items-center mb-4">

            {{-- Left: User info --}}
            <div class="d-flex align-items-center gap-3">
                @if($user->photo)
                    <img src="{{ $user->photo_url }}" alt="{{ $user->first_name }}"
                         class="rounded-circle" style="width: 56px; height: 56px; object-fit: cover;">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                         style="width: 56px; height: 56px; font-size: 20px;">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <h4 class="mb-0">Add Address</h4>
                    <p class="text-muted mb-0">for <strong>{{ $user->first_name }} {{ $user->last_name }}</strong></p>
                </div>
            </div>

            {{-- Right: Buttons --}}
            <div class="d-flex gap-2">
                <a href="{{ route('users.show', $user) }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    Save Address
                </button>
            </div>

        </div>


        <div class="row gx-5">

            {{-- Required Info --}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Required Information</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <x-forms.field label="Nickname" name="nickname" required>
                                <x-forms.input
                                    name="nickname"
                                    :value="old('nickname')"
                                    placeholder="e.g. Home, Work"
                                />
                            </x-forms.field>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Governate</label>
                            <select name="governate" class="form-select">
                                <option value="">Select Governate</option>
                                @foreach(['Cairo', 'Giza', 'Alexandria', 'Dakahlia', 'Sharqia', 'Qalyubia'] as $gov)
                                    <option value="{{ $gov }}" {{ old('governate') == $gov ? 'selected' : '' }}>
                                        {{ $gov }}
                                    </option>
                                @endforeach
                            </select>
                            @error('governate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label fw-bold">Type</label>
                            <div class="list-group">
                                <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                    <input type="radio" name="type" value="home" class="form-check-input m-0"
                                        {{ old('type') == 'home' ? 'checked' : '' }}>
                                    Home
                                </label>
                                <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                    <input type="radio" name="type" value="work" class="form-check-input m-0"
                                        {{ old('type') == 'work' ? 'checked' : '' }}>
                                    Work
                                </label>
                                <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                                    <input type="radio" name="type" value="other" class="form-check-input m-0"
                                        {{ old('type') == 'other' ? 'checked' : '' }}>
                                    Other
                                </label>
                            </div>
                            @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_main" id="is_main" value="1"
                                {{ old('is_main') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_main">Set as main address</label>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Optional Info --}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Additional Details</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <x-forms.field label="Building" name="building">
                                    <x-forms.input name="building" :value="old('building')" placeholder="No." />
                                </x-forms.field>
                            </div>
                            <div class="col-md-4 mb-3">
                                <x-forms.field label="Floor" name="floor">
                                    <x-forms.input name="floor" :value="old('floor')" placeholder="No." />
                                </x-forms.field>
                            </div>
                            <div class="col-md-4 mb-3">
                                <x-forms.field label="Apartment" name="apartment">
                                    <x-forms.input name="apartment" :value="old('apartment')" placeholder="No." />
                                </x-forms.field>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-forms.field label="Neighborhood" name="neighborhood">
                                <x-forms.input name="neighborhood" :value="old('neighborhood')" placeholder="e.g. Maadi" />
                            </x-forms.field>
                        </div>

                        <div class="mb-3">
                            <x-forms.field label="Phone" name="phone">
                                <x-forms.input name="phone" :value="old('phone')" placeholder="Contact phone" />
                            </x-forms.field>
                        </div>

                        <div>
                            <x-forms.field label="Details" name="details">
                                <x-forms.textarea name="details" rows="3"
                                                  placeholder="Additional notes"
                                                  :value="old('details')"
                                />
                            </x-forms.field>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </form>

</x-layouts.admin>
