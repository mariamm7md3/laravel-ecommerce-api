<x-layouts.admin title="{{ __('sizes.edit_size') }}">

    <form method="POST" action="{{ route('sizes.update', $size) }}">
        @csrf
        @method('PATCH')

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('sizes.edit_size') }}</h4>
                <p class="text-muted mb-0">{{ __('sizes.update_size_subtitle') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('sizes.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('sizes.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('sizes.save_changes') }}
                </button>
            </div>
        </div>

        @include('sizes.form', ['size' => $size])

    </form>

</x-layouts.admin>
