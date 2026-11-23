<x-layouts.admin title="{{ __('sizes.sizes') }}">

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sizes.index') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="search"
                               placeholder="{{ __('sizes.search_placeholder') }}"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-2">
                        <select name="per_page" class="form-select">
                            @foreach([10, 25, 50] as $number)
                                <option value="{{ $number }}" {{ request('per_page', 10) == $number ? 'selected' : '' }}>
                                    {{ $number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i>{{ __('sizes.search') }}
                        </button>
                        <a href="{{ route('sizes.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ __('sizes.sizes') }}</h5>
            <a href="{{ route('sizes.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('sizes.add_size') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>{{ __('sizes.name') }}</th>
                    <th class="text-center">{{ __('sizes.active') }}</th>
                    <th class="text-center">{{ __('sizes.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sizes as $size)
                    <tr>
                        <td class="fw-medium">{{ $size->name[app()->getLocale()] ?? $size->name['en'] ?? '-' }}</td>

                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('sizes.toggle-status', $size) }}"
                                    {{ $size->is_active ? 'checked' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('sizes.edit', $size) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('sizes.destroy', $size) }}"
                                      class="delete-form"
                                      data-message="{{ __('sizes.delete_size_confirm') }}">
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
                        <td colspan="3" class="text-center py-5">{{ __('sizes.no_sizes_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $sizes->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
