<x-layouts.admin title="Create Product">

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ __('products.create_product') }}</h4>
                <p class="text-muted mb-0">{{ __('products.create_product_subtitle') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    {{ __('products.cancel') }}
                </a>
                <button class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    {{ __('products.save_product') }}
                </button>
            </div>
        </div>

        @include('products.form')

    </form>


    @include('products.form-script')

</x-layouts.admin>
