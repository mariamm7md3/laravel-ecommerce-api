<x-layouts.admin title="{{ __('industries.industries') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('industries.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-4">
                        <input type="text" name="search" class="form-control"
                               placeholder="{{ __('industries.search_placeholder') }}"
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
                            <i class="ti ti-search me-1"></i>{{ __('industries.search') }}
                        </button>
                        <a href="{{ route('industries.index') }}" class="btn btn-outline-secondary">
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
            <h5 class="card-title mb-0">{{ __('industries.industries') }}</h5>
            <a href="{{ route('industries.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('industries.create_industry') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>{{ __('industries.name') }}</th>
                    <th class="text-center">{{ __('industries.products_count') }}</th>
                    <th class="text-center">{{ __('industries.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($industries as $industry)
                    <tr>
                        <td class="fw-medium">{{ $industry->id }}</td>

                        <td>{{ $industry->name[app()->getLocale()] }}</td>

                        <td class="text-center">
                            <a href="{{ route('products.index' , ['industry_id' => $industry->id]) }}"
                               class="badge bg-label-info text-decoration-none" >
                                {{ $industry->products_count }}
                            </a>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                <a href="{{ route('industries.edit', $industry) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                <form method="POST" action="{{ route('industries.destroy', $industry) }}"
                                      class="delete-form"
                                      data-message="{{ __('industries.confirm_delete_industry') }}">
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
                        <td colspan="4" class="text-center py-5">{{ __('industries.no_industries_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $industries->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
