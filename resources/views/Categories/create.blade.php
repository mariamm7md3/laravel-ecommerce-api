<x-layouts.admin title="create category">

    <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('categories.create_category') }}</h4>
                <p class="text-muted mb-0">{{ __('categories.create_category_subtitle') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('categories.cancel') }}
                </a>

                <button class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('categories.save_category') }}
                </button>
            </div>
        </div>

        @include('categories.form')
    </form>

    @include('categories.form-script')

</x-layouts.admin>
