<x-layouts.admin title="{{ __('users.users') }}">

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('users.index') }}">
                @csrf
                <div class="row g-3 align-items-center">

                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="search"
                               placeholder="{{ __('users.search_placeholder') }}"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-2">
                        <select name="gender" class="form-select">
                            <option value="">{{ __('users.gender') }}</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>{{ __('users.male') }}</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>{{ __('users.female') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select name="is_active" class="form-select">
                            <option value="">{{ __('users.status') }}</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>{{ __('users.active') }}</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>{{ __('users.inactive') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select name="per_page" class="form-select">
                            @foreach([7,10,25,50] as $number)
                                <option value="{{ $number }}" {{ request('per_page', 7) == $number ? 'selected' : '' }}>
                                    {{ $number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i>{{ __('users.search') }}
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
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
            <h5 class="card-title mb-0">{{ __('users.users') }}</h5>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> {{ __('users.add_user') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>{{ __('users.user') }}</th>
                    <th>{{ __('users.email') }}</th>
                    <th>{{ __('users.phone') }}</th>
                    <th class="text-center">{{ __('users.gender') }}</th>
                    <th class="text-center">{{ __('users.orders') }}</th>
                    <th class="text-center">{{ __('users.verified') }}</th>
                    <th class="text-center">{{ __('users.active') }}</th>
                    <th>{{ __('users.joined') }}</th>
                    <th>{{ __('users.actions') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->photo)
                                    <img src="{{ $user->photo_url }}" alt=""
                                         class="rounded-2 me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                         style="width: 40px; height: 40px; font-size: 16px;">
                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                    </div>
                                @endif
                                <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                            </div>
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>{{ $user->phone ?? '-' }}</td>

                        <td class="text-center">
                            @if($user->gender->value === 'male')
                                <span class="badge bg-label-info w-100">{{ __('users.male') }}</span>
                            @else
                                <span class="badge bg-label-warning w-100">{{ __('users.female') }}</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <span class="badge bg-label-secondary">{{ $user->orders_count }}</span>
                        </td>

                        <td class="text-center">
                            @if($user->email_verified_at)
                                <i class="ti ti-circle-check text-success"></i>
                            @else
                                <i class="ti ti-circle-x text-danger"></i>
                            @endif
                        </td>

                        <td class="text-center">
                            <label class="switch switch-success">
                                <input
                                    type="checkbox"
                                    class="switch-input toggle-status"
                                    data-url="{{ route('users.toggle-status', $user) }}"
                                    {{ $user->is_active ? 'checked' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                            </label>

                        </td>

                        <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">

                                {{-- View --}}
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-icon text-info">
                                    <i class="ti ti-eye"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-icon text-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('users.destroy', $user) }}"
                                      class="delete-form"
                                      data-message="{{ __('users.delete_user_confirm') }}">
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
                        <td colspan="9" class="text-center py-5">{{ __('users.no_users_found') }}</td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>

        <div class="card-footer">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>

</x-layouts.admin>
