<x-layouts.admin title="{{ __('discount_codes.create_discount_code') }}">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('discount_codes.create_discount_code') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('discount-codes.store') }}">
                @csrf

                @include('discount-codes.partials.form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('discount_codes.save') }}</button>
                    <a href="{{ route('discount-codes.index') }}" class="btn btn-outline-secondary">{{ __('discount_codes.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>
