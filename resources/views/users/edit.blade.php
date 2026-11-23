<x-layouts.admin title="{{ __('users.edit_user') }}">

    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('users.edit_user') }}</h4>
                <p class="text-muted mb-0">{{ __('users.update_user_subtitle') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('users.show', $user) }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('users.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('users.save_changes') }}
                </button>
            </div>
        </div>

        @include('users.form', ['user' => $user])

    </form>

    @include('users.form-script')

</x-layouts.admin>
