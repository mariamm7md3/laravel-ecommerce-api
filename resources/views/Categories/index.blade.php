{{-- resources/views/admin/categories/index.blade.php --}}
<x-layouts.admin title="Categories">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('categories.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="search"
                               placeholder="{{ __('categories.search_placeholder') }}"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-3">
                        <select name="is_active" class="form-select">
                            <option value="">{{ __('categories.status') }}</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>{{ __('categories.active') }}</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>{{ __('categories.inactive') }}</option>
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
                            <i class="ti ti-search me-1"></i>{{ __('categories.search') }}
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <!-- Category List Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ __('categories.categories') }}</h5>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('categories.add_category') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>{{ __('categories.category') }}</th>
                    <th>{{ __('categories.description') }}</th>
                    <th class="text-center">{{ __('categories.number_of_products') }}</th>
                    <th class="text-center">{{ __('categories.active') }}</th>
                    <th class="text-center">{{ __('categories.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>

                        <td>
                            <div class="d-flex align-items-center">
                                @if($category->icon)
                                    <img src="{{ $category->icon_url }}" alt=""
                                         class="rounded-2 me-2 category-thumb"
                                         style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;"
                                         onclick="showImageModal('{{ $category->icon_url }}', '{{ $category->name[app()->getLocale()] }}')">
                                @else
                                    <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                         style="width: 40px; height: 40px; font-size: 16px;">
                                        {{ strtoupper(substr($category->name[app()->getLocale()], 0, 1)) }}
                                    </div>
                                @endif

                                <h6 class="mb-0">{{ $category->name[app()->getLocale()] }}</h6>
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-label-primary" title="{{ $category->description[app()->getLocale()] }}">
                                {{ Str::limit($category->description[app()->getLocale()], 50) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-label-info">{{ $category->products_count }}</span>
                        </td>


                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('categories.toggle-status', $category) }}"
                                    {{ $category->is_active ? 'checked' : '' }}
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
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                      class="delete-form"
                                      data-message="{{ __('categories.confirm_delete_category') }}">
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
                        <td colspan="5" class="text-center py-5">
                            {{ __('categories.no_categories_found') }}
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>

    </div>
    <!-- / Category List Table -->


    {{-- Image Preview Modal --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="imagePreviewLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <img id="imagePreviewSrc" src="" alt="" class="img-fluid rounded" style="max-height: 70vh;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImageModal(url, title) {
            document.getElementById('imagePreviewSrc').src = url;
            document.getElementById('imagePreviewLabel').textContent = title;

            const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            modal.show();
        }
    </script>

</x-layouts.admin>
