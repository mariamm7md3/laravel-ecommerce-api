@php
    $industry = $industry ?? null;
@endphp

<div class="row g-4">

    <div class="col-lg-6">
        <label class="form-label">{{ __('industries.name_ar') }}</label>
        <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
               value="{{ old('name.ar', $industry->name['ar'] ?? '') }}">
        @error('name.ar')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ __('industries.name_en') }}</label>
        <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
               value="{{ old('name.en', $industry->name['en'] ?? '') }}">
        @error('name.en')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
