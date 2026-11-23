<div class="row gx-5">

    {{-- Left: Size & Unit --}}
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('variants.size') }}</h5>
            </div>
            <div class="card-body">
                <div class="list-group" style="max-height: 220px; overflow-y: auto;">
                    @foreach($productSize as $size)
                        <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input
                                type="radio"
                                name="product_size_id"
                                value="{{ $size->id }}"
                                class="form-check-input m-0"
                                {{ old('product_size_id', $variant->product_size_id ?? null) == $size->id ? 'checked' : '' }}
                            >
                            {{ $size->name[app()->getLocale()] }}
                        </label>
                    @endforeach
                </div>
                @error('product_size_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('variants.unit') }}</h5>
            </div>
            <div class="card-body">
                <div class="list-group" style="max-height: 220px; overflow-y: auto;">
                    @foreach($productUnit as $unit)
                        <label class="list-group-item d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input
                                type="radio"
                                name="unit_id"
                                value="{{ $unit->id }}"
                                class="form-check-input m-0"
                                {{ old('unit_id', $variant->unit_id ?? null) == $unit->id ? 'checked' : '' }}
                            >
                            {{ $unit->name[app()->getLocale()] }}
                        </label>
                    @endforeach
                </div>
                @error('unit_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

</div>

{{-- Pricing & Stock --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">{{ __('variants.pricing_stock') }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <x-forms.field label="{{ __('variants.price') }}" name="price" required>
                    <x-forms.input
                        type="number"
                        name="price"
                        :value="old('price', $variant->price ?? '')"
                        placeholder="{{ __('variants.price_placeholder') }}"
                        step="0.01"
                    />
                </x-forms.field>
            </div>

            <div class="col-md-4 mb-3">
                <x-forms.field label="{{ __('variants.stock_quantity') }}" name="stock_quantity" required>
                    <x-forms.input
                        type="number"
                        name="stock_quantity"
                        :value="old('stock_quantity', $variant->stock_quantity ?? '')"
                        placeholder="{{ __('variants.stock_quantity_placeholder') }}"
                    />
                </x-forms.field>
            </div>

            <div class="col-md-4 mb-3">
                <x-forms.field label="{{ __('variants.product_limit') }}" name="product_limit">
                    <x-forms.input
                        type="number"
                        name="product_limit"
                        :value="old('product_limit', $variant->product_limit ?? '')"
                        placeholder="{{ __('variants.product_limit_placeholder') }}"
                    />
                </x-forms.field>
            </div>
        </div>
    </div>
</div>

{{-- Active Sales --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">{{ __('variants.sales') }}</h5>
    </div>
    <div class="card-body">
        @if($activeSales->isEmpty())
            <p class="text-muted mb-0">{{ __('variants.no_active_sales') }}</p>
        @else
            <div class="list-group" style="max-height: 220px; overflow-y: auto;">
                @php
                    $selectedSaleIds = old('sale_ids', isset($variant) ? $variant->sales->pluck('id')->toArray() : []);
                @endphp
                @foreach($activeSales as $sale)
                    <label class="list-group-item d-flex align-items-center justify-content-between gap-2" style="cursor: pointer;">
                        <span class="d-flex align-items-center gap-2">
                            <input
                                type="checkbox"
                                name="sale_ids[]"
                                value="{{ $sale->id }}"
                                class="form-check-input m-0"
                                {{ in_array($sale->id, $selectedSaleIds) ? 'checked' : '' }}
                            >
                            {{ __('sales.percentage') }}: {{ $sale->percentage }}%
                        </span>
                        <span class="text-muted small">
                            {{ $sale->start_date->format('M d, Y') }} - {{ $sale->end_date->format('M d, Y') }}
                        </span>
                    </label>
                @endforeach
            </div>
        @endif
        @error('sale_ids')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('products.show', $product) }}" class="btn btn-label-secondary">
        <i class="ti ti-arrow-left me-1"></i>
        {{ __('variants.cancel') }}
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="ti ti-device-floppy me-1"></i>
        {{ isset($variant) ? __('variants.save_changes') : __('variants.save_variant') }}
    </button>
</div>
