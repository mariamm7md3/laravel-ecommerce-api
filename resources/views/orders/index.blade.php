<x-layouts.admin title="{{ __('orders.orders') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('orders.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-2">
                        <input type="text" name="user_name" class="form-control"
                               placeholder="{{ __('orders.search_by_customer') }}"
                               value="{{ request('user_name') }}">
                    </div>

                    <div class="col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">{{ __('orders.filter_status') }}</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <input type="date" name="start_date" class="form-control"
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="col-lg-2">
                        <input type="date" name="end_date" class="form-control"
                               value="{{ request('end_date') }}">
                    </div>

                    <div class="col-lg-1">
                        <select name="per_page" class="form-select">
                            @foreach([7, 10, 25, 50] as $number)
                                <option value="{{ $number }}" {{ request('per_page', 7) == $number ? 'selected' : '' }}>
                                    {{ $number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-1 d-flex align-items-center">
                        <label class="filter-chip w-100" for="show_deleted">
                            <input type="checkbox" class="filter-chip-input" id="show_deleted"
                                   name="show_deleted" value="1"
                                {{ request()->boolean('show_deleted') ? 'checked' : '' }}>
                            <span class="filter-chip-box">
                                <i class="ti ti-trash me-1"></i>
                                {{ __('orders.show_deleted') }}
                            </span>
                        </label>
                    </div>

                    <style>
                        .filter-chip {
                            display: block;
                            cursor: pointer;
                        }
                        .filter-chip-input {
                            display: none;
                        }
                        .filter-chip-box {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 38px;
                            border: 1px solid var(--bs-border-color, #d9dee3);
                            border-radius: 6px;
                            font-size: 13px;
                            color: #6c757d;
                            transition: all .15s ease;
                            white-space: nowrap;
                        }
                        .filter-chip-box:hover {
                            border-color: #dc3545;
                            color: #dc3545;
                        }
                        .filter-chip-input:checked + .filter-chip-box {
                            background-color: rgba(220, 53, 69, .08);
                            border-color: #dc3545;
                            color: #dc3545;
                            font-weight: 500;
                        }
                    </style>
                    <div class="col-lg-2 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i>{{ __('orders.search') }}
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
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
            <h5 class="card-title mb-0">{{ __('orders.orders') }}</h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>{{ __('orders.customer') }}</th>
                    <th>{{ __('orders.branch') }}</th>
                    <th class="text-center">{{ __('orders.items_count') }}</th>
                    <th>{{ __('orders.total') }}</th>
                    <th class="text-center">{{ __('orders.payment_status') }}</th>
                    <th class="text-center">{{ __('orders.status_column') }}</th>
                    <th class="text-center">{{ __('orders.date') }}</th>
                    <th class="text-center">{{ __('orders.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="fw-medium">{{ $order->id }}</td>

                        <td>
                            <a href="{{ route('users.show' , $order->user) }}" class="d-flex align-items-center text-decoration-none">
                                    @if($order->user->photo)
                                        <img src="{{ $order->user->photo_url }}" alt=""
                                             class="rounded-2 me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                             style="width: 40px; height: 40px; font-size: 16px;">
                                            {{ strtoupper(substr($order->user->first_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <h6 class="mb-0">{{ $order->user->first_name }} {{ $order->user->last_name }}</h6>
                            </a>
                        </td>

                        <td class="text-muted">{{ $order->branch->name[app()->getLocale()] }}</td>

                        <td class="text-center">
                            <span class="badge bg-label-info">{{ $order->items_count }}</span>
                        </td>

                        <td class="fw-medium">
                            <span class="badge bg-label-success">
                                {{ number_format($order->total, 2) }}
                            </span>
                            </td>

                        <td class="text-center">
                            @if($order->payment)
                                <span class="badge bg-label-{{ $order->payment->status->badgeColor() }}">
                                    {{ $order->payment->status->label() }}
                                </span>
                            @else
                                <span class="badge bg-label-secondary">{{ __('orders.no_payment') }}</span>
                            @endif
                        </td>

                        <td class="text-center" id="status-badge-{{ $order->id }}">
                            @include('orders.partials.status-dropdown', ['order' => $order])
                        </td>

                        <td class="text-muted">{{ $order->date->format('M d, Y h:i A') }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                {{-- Show --}}
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-eye"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('orders.destroy', $order) }}"
                                      class="delete-form"
                                      data-message="{{ __('orders.confirm_delete_order') }}">
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
                        <td colspan="9" class="text-center py-5">{{ __('orders.no_orders_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
