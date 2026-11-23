<x-layouts.admin title="{{ __('sizes.add_size') }}">

    <form method="POST" action="{{ route('sizes.store') }}">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('sizes.add_size') }}</h4>
                <p class="text-muted mb-0">{{ __('sizes.create_size_subtitle') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('sizes.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('sizes.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('sizes.save_size') }}
                </button>
            </div>
        </div>

        @include('sizes.form')

    </form>

</x-layouts.admin>
