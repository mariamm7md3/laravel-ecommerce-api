@php
    $branch = $branch ?? null;
@endphp

<div class="row g-4">

    <div class="col-lg-6">
        <label class="form-label">{{ __('branches.name_ar') }}</label>
        <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
               value="{{ old('name.ar', $branch->name['ar'] ?? '') }}">
        @error('name.ar')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ __('branches.name_en') }}</label>
        <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
               value="{{ old('name.en', $branch->name['en'] ?? '') }}">
        @error('name.en')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ __('branches.address_ar') }}</label>
        <input type="text" name="address[ar]" class="form-control @error('address.ar') is-invalid @enderror"
               value="{{ old('address.ar', $branch->address['ar'] ?? '') }}">
        @error('address.ar')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ __('branches.address_en') }}</label>
        <input type="text" name="address[en]" class="form-control @error('address.en') is-invalid @enderror"
               value="{{ old('address.en', $branch->address['en'] ?? '') }}">
        @error('address.en')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('branches.shipping_cost') }}</label>
        <input type="number" step="0.01" min="0" name="shipping_cost"
               class="form-control @error('shipping_cost') is-invalid @enderror"
               value="{{ old('shipping_cost', $branch->shipping_cost ?? '') }}">
        @error('shipping_cost')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
