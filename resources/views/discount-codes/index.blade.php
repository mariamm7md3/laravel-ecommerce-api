<x-layouts.admin title="{{ __('discount_codes.discount_codes') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('discount-codes.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-4">
                        <input type="text" name="search" class="form-control"
                               placeholder="{{ __('discount_codes.search_placeholder') }}"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">{{ __('discount_codes.filter_status') }}</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('discount_codes.active') }}</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('discount_codes.inactive') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select name="per_page" class="form-select">
                            @foreach([7, 10, 25, 50] as $number)
                                <option value="{{ $number }}" {{ request('per_page', 7) == $number ? 'selected' : '' }}>
                                    {{ $number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i>{{ __('discount_codes.search') }}
                        </button>
                        <a href="{{ route('discount-codes.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ __('discount_codes.discount_codes') }}</h5>
            <a href="{{ route('discount-codes.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('discount_codes.create_discount_code') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>{{ __('discount_codes.code') }}</th>
                    <th>{{ __('discount_codes.percentage') }}</th>
                    <th>{{ __('discount_codes.max_discount_limit') }}</th>
                    <th class="text-center">{{ __('discount_codes.usage') }}</th>
                    <th class="text-center">{{ __('discount_codes.is_once') }}</th>
                    <th>{{ __('discount_codes.start_date') }}</th>
                    <th>{{ __('discount_codes.end_date') }}</th>
                    <th class="text-center">{{ __('discount_codes.active_column') }}</th>
                    <th class="text-center">{{ __('discount_codes.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($discountCodes as $discountCode)
                    <tr>
                        <td class="fw-medium">{{ $discountCode->id }}</td>

                        <td><span class="badge bg-label-dark">{{ $discountCode->code }}</span></td>

                        <td>{{ $discountCode->percentage }}%</td>

                        <td class="text-muted">{{ number_format($discountCode->max_discount_limit, 2) }}</td>

                        <td class="text-center">
                            <span class="badge bg-label-info">{{ $discountCode->orders_count }} / {{ $discountCode->usage_limit }}</span>
                        </td>

                        <td class="text-center">
                            @if($discountCode->is_once)
                                <i class="ti ti-check text-success"></i>
                            @else
                                <i class="ti ti-x text-muted"></i>
                            @endif
                        </td>

                        <td class="text-muted">{{ $discountCode->start_date->format('M d, Y') }}</td>
                        <td class="text-muted">{{ $discountCode->end_date->format('M d, Y') }}</td>

                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('discount-codes.toggle-status', $discountCode) }}"
                                    {{ $discountCode->is_active ? 'checked' : '' }}
                                    {{ $discountCode->end_date->isPast() ? 'disabled' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                <a href="{{ route('discount-codes.edit', $discountCode) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                <form method="POST" action="{{ route('discount-codes.destroy', $discountCode) }}"
                                      class="delete-form"
                                      data-message="{{ __('discount_codes.confirm_delete') }}">
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
                        <td colspan="10" class="text-center py-5">{{ __('discount_codes.no_discount_codes_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $discountCodes->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
