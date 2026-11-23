<x-layouts.admin title="{{ __('sales.create_sale') }}">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('sales.create_sale') }}</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('sales.store') }}">
                @csrf
                @include('sales.partials.form')
            </form>
        </div>
    </div>

</x-layouts.admin>
