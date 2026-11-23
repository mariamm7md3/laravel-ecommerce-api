{{-- resources/views/admin/products/index.blade.php --}}
<x-layouts.admin title="Products">

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row g-3 align-items-center">

                    {{-- Search --}}
                    <div class="col-lg-3">
                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="{{ __('products.search_placeholder') }}"
                            value="{{ request('search') }}">
                    </div>

                    {{-- Category --}}
                    <div class="col-lg-2">
                        <select name="category_id" class="form-select">
                            <option value="">{{ __('products.category') }}</option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name[app()->getLocale()] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Industry --}}
                    <div class="col-lg-2">
                        <select name="industry_id" class="form-select">
                            <option value="">{{ __('products.industry') }}</option>

                            @foreach($industries as $industry)
                                <option
                                    value="{{ $industry->id }}"
                                    {{ request('industry_id') == $industry->id ? 'selected' : '' }}>
                                    {{ $industry->name[app()->getLocale()] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-lg-2">
                        <select name="is_active" class="form-select">
                            <option value="">{{ __('products.status') }}</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>
                                {{ __('products.active') }}
                            </option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>
                                {{ __('products.inactive') }}
                            </option>
                        </select>
                    </div>

                    {{-- Show --}}
                    <div class="col-lg-1">
                        <select name="per_page" class="form-select">
                            @foreach([7,10,25,50] as $number)
                                <option
                                    value="{{ $number }}"
                                    {{ request('per_page',7) == $number ? 'selected' : '' }}>
                                    {{ $number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-lg-2 d-flex gap-2">

                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i>{{ __('products.search') }}
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>

                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- / Filter -->

    <!-- Product List Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ __('products.products') }}</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('products.add_product') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>{{ __('products.product') }}</th>
                    <th>{{ __('products.industry') }}</th>
                    <th>{{ __('products.category') }}</th>
                    <th>{{ __('products.price') }}</th>
                    <th>{{ __('products.stock') }}</th>
                    <th>{{ __('products.rate') }}</th>
                    <th class="text-center">{{ __('products.active') }}</th>
                    <th class="text-center">{{ __('products.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>

                        <td>
                            <div class="d-flex align-items-center">
                                @if($product->photo)
                                    <img src="{{ $product->photo_url }}" alt=""
                                         class="rounded-2 me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                         style="width: 40px; height: 40px; font-size: 16px;">
                                        {{ strtoupper(substr($product->name['en'], 0, 1)) }}
                                    </div>
                                @endif

                                <h6 class="mb-0">{{ $product->name[app()->getLocale()] }}</h6>
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-label-primary">
                                {{ $product->industry->name[app()->getLocale()] }}
                            </span>
                        </td>

                        <td>
                            @foreach($product->categories as $category)
                                <span class="badge bg-label-info me-1 mb-1">{{ $category->name[app()->getLocale()] }}</span>
                            @endforeach
                        </td>

                        <td>
                            <span>{{ $product->min_price ? number_format($product->min_price, 2) : '-' }}</span>
                        </td>

                        <td>
                            @if($product->total_stock > 0)
                                <span class="badge bg-label-success">{{ __('products.in_stock') }} ({{ $product->total_stock }})</span>
                            @else
                                <span class="badge bg-label-danger">{{ __('products.out_of_stock') }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold d-flex align-items-center">
                                {{ $product->rate }}
                                <i class="ti ti-star-filled text-warning ms-1"></i>
                            </span>
                        </td>

                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('products.toggle-status', $product) }}"
                                    {{ $product->is_active ? 'checked' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                {{-- View --}}
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-icon text-info">
                                    <i class="ti ti-eye"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('products.destroy', $product) }}"
                                      class="delete-form"
                                      data-message="{{ __('products.confirm_delete_product') }}">
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
                        <td colspan="8" class="text-center py-5">
                            {{ __('products.no_products_found') }}
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>

    </div>
    <!-- / Product List Table -->

</x-layouts.admin>
