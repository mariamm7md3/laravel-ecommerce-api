<x-layouts.admin title="{{ __('delivery_times.delivery_times') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('delivery-times.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-3">
                        <select name="branch_id" class="form-select">
                            <option value="">{{ __('delivery_times.filter_branch') }}</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name[app()->getLocale()] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <select name="day_of_week" class="form-select">
                            <option value="">{{ __('delivery_times.filter_day') }}</option>
                            @foreach($days as $day)
                                <option value="{{ $day }}" {{ request('day_of_week') == $day ? 'selected' : '' }}>
                                    {{ __('general.days.' . $day) }}
                                </option>
                            @endforeach
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
                            <i class="ti ti-search me-1"></i>{{ __('delivery_times.search') }}
                        </button>
                        <a href="{{ route('delivery-times.index') }}" class="btn btn-outline-secondary">
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
            <h5 class="card-title mb-0">{{ __('delivery_times.delivery_times') }}</h5>
            <a href="{{ route('delivery-times.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('delivery_times.create_delivery_time') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>{{ __('delivery_times.branch') }}</th>
                    <th>{{ __('delivery_times.day') }}</th>
                    <th>{{ __('delivery_times.time_range') }}</th>
                    <th class="text-center">{{ __('delivery_times.active_column') }}</th>
                    <th class="text-center">{{ __('delivery_times.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($deliveryTimes as $deliveryTime)
                    <tr>
                        <td class="fw-medium">{{ $deliveryTime->id }}</td>

                        <td>{{ $deliveryTime->branch->name[app()->getLocale()] }}</td>

                        <td>
                            <span class="badge bg-label-secondary">
                                {{ __('general.days.' . $deliveryTime->day_of_week) }}
                            </span>
                        </td>

                        <td class="text-muted">
                            {{ \Carbon\Carbon::parse($deliveryTime->start_time)->format('h:i A') }}
                            -
                            {{ \Carbon\Carbon::parse($deliveryTime->end_time)->format('h:i A') }}
                        </td>

                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('delivery-times.toggle-status', $deliveryTime) }}"
                                    {{ $deliveryTime->is_active ? 'checked' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                <a href="{{ route('delivery-times.edit', $deliveryTime) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                <form method="POST" action="{{ route('delivery-times.destroy', $deliveryTime) }}"
                                      class="delete-form"
                                      data-message="{{ __('delivery_times.confirm_delete') }}">
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
                        <td colspan="6" class="text-center py-5">{{ __('delivery_times.no_delivery_times_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $deliveryTimes->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
