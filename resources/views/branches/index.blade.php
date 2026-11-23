<x-layouts.admin title="{{ __('branches.branches') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('branches.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-4">
                        <input type="text" name="search" class="form-control"
                               placeholder="{{ __('branches.search_placeholder') }}"
                               value="{{ request('search') }}">
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
                            <i class="ti ti-search me-1"></i>{{ __('branches.search') }}
                        </button>
                        <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">
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
            <h5 class="card-title mb-0">{{ __('branches.branches') }}</h5>
            <a href="{{ route('branches.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('branches.create_branch') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>{{ __('branches.name') }}</th>
                    <th>{{ __('branches.address') }}</th>
                    <th class="text-center">{{ __('branches.shipping_cost') }}</th>
                    <th class="text-center">{{ __('branches.orders_count') }}</th>
                    <th class="text-center">{{ __('branches.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($branches as $branch)
                    <tr>
                        <td class="fw-medium">{{ $branch->id }}</td>

                        <td>{{ $branch->name[app()->getLocale()] }}</td>

                        <td class="text-muted">{{ $branch->address[app()->getLocale()] }}</td>

                        <td class="text-center">
                            <span class="badge bg-label-primary">{{ number_format($branch->shipping_cost, 2) }}</span>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-label-info">{{ $branch->orders_count }}</span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('branches.destroy', $branch) }}"
                                      class="delete-form"
                                      data-message="{{ __('branches.confirm_delete_branch') }}">
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
                        <td colspan="6" class="text-center py-5">{{ __('branches.no_branches_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $branches->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
