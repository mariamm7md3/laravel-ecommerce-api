<x-layouts.admin title="{{ __('variants.add_variant') }}">

    <div class="d-flex align-items-center gap-3 mb-4">
        <img src="{{ $product->photo_url }}"
             alt="{{ $product->name[app()->getLocale()] }}"
             class="rounded"
             style="width: 56px; height: 56px; object-fit: cover;">

        <div>
            <h4 class="mb-0">{{ __('variants.add_variant') }}</h4>
            <p class="text-muted mb-0">{{ __('variants.for') }} <strong>{{ $product->name[app()->getLocale()] }}</strong></p>
        </div>
    </div>

    <form method="POST" action="{{ route('variants.store', $product) }}">
        @csrf
        @include('variants.partials.form')
    </form>

</x-layouts.admin>
