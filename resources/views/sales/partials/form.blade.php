<div class="row g-3">

    @isset($sale)
        <div class="col-12">
            <label class="form-label d-block">{{ __('sales.status') }}</label>
            @include('sales.partials.status-badge', ['sale' => $sale])
        </div>
    @endisset

    <div class="col-md-4">
        <label class="form-label">{{ __('sales.percentage') }}</label>
        <div class="input-group">
            <input
                type="number"
                name="percentage"
                step="0.01"
                min="1"
                max="100"
                class="form-control @error('percentage') is-invalid @enderror"
                value="{{ old('percentage', $sale->percentage ?? '') }}"
            />
            <span class="input-group-text">%</span>
            @error('percentage')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">{{ __('sales.start_date') }}</label>
        <input
            type="date"
            name="start_date"
            class="form-control @error('start_date') is-invalid @enderror"
            value="{{ old('start_date', isset($sale) ? $sale->start_date->format('Y-m-d') : '') }}"
        />
        @error('start_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">{{ __('sales.end_date') }}</label>
        <input
            type="date"
            name="end_date"
            class="form-control @error('end_date') is-invalid @enderror"
            value="{{ old('end_date', isset($sale) ? $sale->end_date->format('Y-m-d') : '') }}"
        />
        @error('end_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @unless(isset($sale))
        <div class="col-12">
            <div class="form-check form-switch">
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    class="form-check-input"
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                />
                <label class="form-check-label" for="is_active">
                    {{ __('sales.active_column') }}
                </label>
            </div>
        </div>
    @endunless

</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        {{ isset($sale) ? __('sales.save_changes') : __('sales.create_sale') }}
    </button>
    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
        {{ __('sales.cancel') }}
    </a>
</div>
