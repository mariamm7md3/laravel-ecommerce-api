<x-layouts.admin title="{{ __('sales.sales') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sales.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-3">
                        <select name="status" class="form-select">
                            <option value="">{{ __('sales.filter_status') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('sales.active') }}</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>{{ __('sales.upcoming') }}</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('sales.expired') }}</option>
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

                    <div class="col-lg-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i>{{ __('sales.search') }}
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
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
            <h5 class="card-title mb-0">{{ __('sales.sales') }}</h5>
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('sales.create_sale') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>{{ __('sales.percentage') }}</th>
                    <th>{{ __('sales.start_date') }}</th>
                    <th>{{ __('sales.end_date') }}</th>
                    <th class="text-center">{{ __('sales.variants_count') }}</th>
                    <th class="text-center">{{ __('sales.status') }}</th>
                    <th class="text-center">{{ __('sales.active_column') }}</th>
                    <th class="text-center">{{ __('sales.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td class="fw-medium">{{ $sale->id }}</td>

                        <td>
                            <span class="badge bg-label-primary">{{ $sale->percentage }}%</span>
                        </td>

                        <td class="text-muted">{{ $sale->start_date->format('M d, Y') }}</td>
                        <td class="text-muted">{{ $sale->end_date->format('M d, Y') }}</td>

                        <td class="text-center">
                            <span class="badge bg-label-info">{{ $sale->variants_count }}</span>
                        </td>

                        <td class="text-center" id="status-badge-{{ $sale->id }}">
                            @include('sales.partials.status-badge', ['sale' => $sale])
                        </td>

                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('sales.toggle-status', $sale) }}"
                                    {{ $sale->is_active ? 'checked' : '' }}
                                    {{ $sale->status === 'expired' ? 'disabled' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                {{-- Edit --}}
                                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('sales.destroy', $sale) }}"
                                      class="delete-form"
                                      data-message="{{ __('sales.confirm_delete_sale') }}">
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
                        <td colspan="7" class="text-center py-5">{{ __('sales.no_sales_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $sales->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
