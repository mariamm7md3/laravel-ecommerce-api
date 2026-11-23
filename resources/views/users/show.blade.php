<x-layouts.admin title="{{ __('users.user_details') }}">

    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- title --}}
        <div>
            <h4 class="mb-1">{{ __('users.user_details') }}</h4>
            <p class="text-muted mb-0">
                {{ __('users.view_user_subtitle') }}
            </p>
        </div>

        {{-- buttons--}}
        <div class="d-flex gap-2">

            <a href="{{ route('users.index') }}"
               class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                {{ __('users.back') }}
            </a>

            <a href="{{ route('users.edit', $user) }}"
               class="btn btn-primary">
                <i class="ti ti-edit me-1"></i>
                {{ __('users.edit_user') }}
            </a>

        </div>

    </div>


    {{-- User Information --}}
    <div class="row gx-5">
        {{-- img --}}
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-center p-0">
                    @if($user->photo)
                        <img
                            src="{{ $user->photo_url }}"
                            class="rounded"
                            style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover;"
                            alt="{{ $user->first_name }}"
                        >
                    @else
                        <div class="rounded d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                             style="width: 100%; aspect-ratio: 1 / 1; font-size: 64px;">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Information Card --}}
        <div class="col-lg-6">
            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        {{ __('users.user_information') }}
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">
                            {{ __('users.name') }}
                        </div>

                        <div class="col-md-9">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">{{ __('users.email') }}</div>
                        <div class="col-md-9">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <i class="ti ti-circle-check text-success ms-1"></i>
                            @else
                                <i class="ti ti-circle-x text-danger ms-1"></i>
                            @endif
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">{{ __('users.phone') }}</div>
                        <div class="col-md-9">{{ $user->phone ?? '-' }}</div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">{{ __('users.gender') }}</div>
                        <div class="col-md-9">
                            @if($user->gender->value === 'male')
                                <span class="badge bg-label-info">{{ __('users.male') }}</span>
                            @else
                                <span class="badge bg-label-danger">{{ __('users.female') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row py-3 border-bottom">
                        <div class="col-md-3 fw-semibold text-muted">{{ __('users.date_of_birth_label') }}</div>
                        <div class="col-md-9">
                            {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') : '-' }}
                        </div>
                    </div>

                    <div class="row py-3">
                        <div class="col-md-3 fw-semibold text-muted">{{ __('users.status') }}</div>
                        <div class="col-md-9">
                            @if($user->is_active)
                                <span class="badge bg-label-success">{{ __('users.active') }}</span>
                            @else
                                <span class="badge bg-label-secondary">{{ __('users.inactive') }}</span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- addresses --}}
    <div class="mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    {{ __('users.addresses') }}
                    <span class="badge bg-label-primary ms-1">{{ $user->addresses->count() }}</span>
                </h5>

                <a href="{{ route('address.create', $user) }}"
                   class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    {{ __('users.add_address') }}
                </a>

            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead class="border-top">
                    <tr>
                        <th>{{ __('users.nickname') }}</th>
                        <th>{{ __('users.type') }}</th>
                        <th>{{ __('users.governate') }}</th>
                        <th>{{ __('users.neighborhood') }}</th>
                        <th>{{ __('users.building_floor_apt') }}</th>
                        <th>{{ __('users.details') }}</th>
                        <th class="text-center">{{ __('users.active') }}</th>
                        <th class="text-center">{{ __('users.main') }}</th>
                        <th class="text-center">{{ __('users.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($user->addresses as $address)
                        <tr>
                            <td class="fw-medium">{{ $address->nickname }}</td>

                            <td>
                                <span class="badge bg-label-secondary">{{ ucfirst($address->type->value) }}</span>
                            </td>

                            <td>{{ $address->governate }}</td>

                            <td>{{ $address->neighborhood }}</td>

                            <td class="text-muted text-center">
                                {{ $address->building }} / {{ $address->floor }} / {{ $address->apartment }}
                            </td>

                            <td class="text-muted" title="{{ $address->details }}">
                                {{ Str::limit($address->details, 40) }}
                            </td>

                            <td class="text-center">
                                <form method="POST" action="{{ route('address.toggle-status', $address) }}">
                                    @csrf
                                    @method('PATCH')

                                    <label class="switch switch-success">
                                        <input type="checkbox" class="switch-input" onchange="this.form.submit()"
                                            {{ $address->is_active ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                    </label>
                                </form>
                            </td>

                            <td class="text-center">
                                @if($address->is_main)
                                    <span class="badge bg-label-success">{{ __('users.main') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Edit --}}
                                    <a href="{{ route('address.edit', $address) }}" class="btn btn-sm btn-icon text-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('address.destroy', $address) }}"
                                          onsubmit="return confirm('{{ __('users.delete_address_confirm') }}')">
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
                            <td colspan="9" class="text-center py-5">{{ __('users.no_addresses_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin>
