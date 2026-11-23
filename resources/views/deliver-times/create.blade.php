<x-layouts.admin title="{{ __('delivery_times.create_delivery_time') }}">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('delivery_times.create_delivery_time') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('delivery-times.store') }}">
                @csrf

                @include('deliver-times.partials.form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('delivery_times.save') }}</button>
                    <a href="{{ route('delivery-times.index') }}" class="btn btn-outline-secondary">{{ __('delivery_times.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>
