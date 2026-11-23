<x-layouts.admin title="Product Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- title --}}
        <div>
            <h4 class="mb-1">{{ __('products.product_details') }}</h4>
            <p class="text-muted mb-0">
                {{ __('products.product_details_subtitle') }}
            </p>
        </div>

        {{-- buttons--}}
        <div class="d-flex gap-2">

            <a href="{{ route('products.index') }}"
               class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                {{ __('products.back') }}
            </a>

            <a href="{{ route('products.edit' , $product) }}"
               class="btn btn-primary">
                <i class="ti ti-edit me-1"></i>
                {{ __('products.edit_product') }}
            </a>

        </div>

    </div>


    {{-- Product Information --}}
    <div class="row gx-5">
        {{-- img --}}
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-center p-0">
                    <img
                        src="{{ $product->photo_url }}"
                        class="rounded"
                        style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover;"
                        alt="No image for product"
                    >
                </div>
            </div>
        </div>
        {{-- Information Card --}}
        <div class="col-lg-6">
            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        {{ __('products.product_information') }}
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('products.name') }}
                        </div>

                        <div class="col-md-9">
                            {{ $product->name[app()->getLocale()] }}
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('products.description') }}
                        </div>

                        <div class="col-md-9">
                            {{ $product->description[app()->getLocale()] }}
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('products.industry') }}
                        </div>

                        <div class="col-md-9">
                            {{ $product->industry->name[app()->getLocale()] }}
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('products.category') }}
                        </div>

                        <div class="col-md-9">
                            @foreach($product->categories as $category)
                                <span class="badge bg-label-info me-1 mb-1">{{$category->name[app()->getLocale()]}} </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('products.status') }}
                        </div>

                        <div class="col-md-9">
                            @if($product->is_active)
                                <span class="badge bg-label-success">{{ __('products.active') }}</span>
                            @else
                                <span class="badge bg-label-secondary">{{ __('products.inactive') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row py-3">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('products.rate') }}
                        </div>

                        <div class="col-md-9">
                            <span class="d-flex align-items-center">
                                 {{ $product->rate }}
                                <i class="ti ti-star-filled text-warning ms-1"></i>
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>


    {{-- Variants --}}
    <div class="mt-4">

        <!-- Variant List Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    {{ __('products.variants') }}
                    <span class="badge bg-label-primary ms-1">
                        {{ $product->variants->count() }}
                    </span>
                </h5>

                <a href="{{ route('variants.create' , $product) }}"
                   class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    {{ __('products.add_variant') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead class="border-top">
                    <tr>
                        <th>{{ __('products.size') }}</th>
                        <th>{{ __('products.unit') }}</th>
                        <th>{{ __('products.price') }}</th>
                        <th>{{ __('products.stock') }}</th>
                        <th>{{ __('products.sale') }}</th>
                        <th>{{ __('products.final_price') }}</th>
                        <th>{{ __('products.sale_ends') }}</th>
                        <th class="text-center">{{ __('products.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($product->variants as $variant)
                        @php $sale = $variant->sales->first(); @endphp
                        <tr>

                            <td>
                            <span class="badge bg-label-secondary">
                                {{ $variant->productSize->name[app()->getLocale()] }}
                            </span>
                            </td>

                            <td>
                            <span class="badge bg-label-secondary">
                                {{ $variant->productUnit->name[app()->getLocale()] ??'-' }}
                            </span>
                            </td>

                            <td class="fw-medium">
                                {{ number_format($variant->price ,2) }}
                            </td>


                            <td>
                                @if($variant->stock_quantity == 0)
                                    <span class="badge bg-label-danger">{{ __('products.out_of_stock') }}</span>
                                @elseif($variant->stock_quantity < 10)
                                    <span class="badge bg-label-warning">{{ __('products.stock_left', ['count' => $variant->stock_quantity]) }}</span>
                                @else
                                    <span class="badge bg-label-success">{{ $variant->stock_quantity }}</span>
                                @endif
                            </td>


                            <td>
                                @if($sale)
                                    <span class="badge bg-label-success">-{{ $sale->percentage }}%</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if($sale)
                                    <span class="fw-semibold text-success">{{ number_format($variant->final_price, 2) }}</span>
                                    <small class="text-muted text-decoration-line-through d-block">{{ number_format($variant->price, 2) }}</small>
                                @else
                                    <span class="fw-medium">{{ number_format($variant->final_price, 2) }}</span>
                                @endif
                            </td>

                            <td class="text-muted">
                                {{ $sale?->end_date ? \Carbon\Carbon::parse($sale->end_date)->format('M d, Y') : '-' }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-1">

                                    <a href="{{ route('variants.edit', $variant) }}" class="btn btn-sm btn-icon text-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('variants.destroy', $variant) }}"
                                          onsubmit="return confirm('{{ __('products.confirm_delete_variant') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon text-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                {{ __('products.no_variants_found') }}
                            </td>
                        </tr>

                    @endforelse

                    </tbody>
                </table>
            </div>

        </div>
        <!-- / Variant List Table -->

    </div>

</x-layouts.admin>
