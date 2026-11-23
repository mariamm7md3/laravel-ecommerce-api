<x-layouts.admin title="{{ __('units.add_unit') }}">

    <form method="POST" action="{{ route('units.store') }}">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('units.add_unit') }}</h4>
                <p class="text-muted mb-0">{{ __('units.create_unit_subtitle') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('units.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('units.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('units.save_unit') }}
                </button>
            </div>
        </div>

        @include('units.form')

    </form>

</x-layouts.admin>
