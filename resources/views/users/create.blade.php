<x-layouts.admin title="{{ __('users.add_user') }}">

    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('users.create_user') }}</h4>
                <p class="text-muted mb-0">{{ __('users.create_user_subtitle') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('users.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('users.save_user') }}
                </button>
            </div>
        </div>

        @include('users.form')

    </form>

    @include('users.form-script')

</x-layouts.admin>
