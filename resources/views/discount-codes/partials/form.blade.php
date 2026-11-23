@php
    $discountCode = $discountCode ?? null;
@endphp

<div class="row g-4">

    <div class="col-lg-4">
        <label class="form-label">{{ __('discount_codes.code') }}</label>
        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
               value="{{ old('code', $discountCode->code ?? '') }}">
        @error('code')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('discount_codes.percentage') }}</label>
        <div class="input-group">
            <input type="number" step="0.01" min="1" max="100" name="percentage"
                   class="form-control @error('percentage') is-invalid @enderror"
                   value="{{ old('percentage', $discountCode->percentage ?? '') }}">
            <span class="input-group-text">%</span>
        </div>
        @error('percentage')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('discount_codes.max_discount_limit') }}</label>
        <input type="number" step="0.01" min="0" name="max_discount_limit"
               class="form-control @error('max_discount_limit') is-invalid @enderror"
               value="{{ old('max_discount_limit', $discountCode->max_discount_limit ?? '') }}">
        @error('max_discount_limit')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('discount_codes.usage_limit') }}</label>
        <input type="number" min="1" name="usage_limit"
               class="form-control @error('usage_limit') is-invalid @enderror"
               value="{{ old('usage_limit', $discountCode->usage_limit ?? '') }}">
        @error('usage_limit')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('discount_codes.start_date') }}</label>
        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
               value="{{ old('start_date', optional($discountCode?->start_date)->format('Y-m-d')) }}">
        @error('start_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('discount_codes.end_date') }}</label>
        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
               value="{{ old('end_date', optional($discountCode?->end_date)->format('Y-m-d')) }}">
        @error('end_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-6 d-flex align-items-center">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_once" name="is_once" value="1"
                {{ old('is_once', $discountCode->is_once ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_once">{{ __('discount_codes.is_once_hint') }}</label>
        </div>
    </div>

    <div class="col-lg-6 d-flex align-items-center">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $discountCode->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ __('discount_codes.active') }}</label>
        </div>
    </div>

</div>
