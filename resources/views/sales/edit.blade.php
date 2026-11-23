<x-layouts.admin title="{{ __('sales.edit_sale') }}">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ __('sales.edit_sale') }}</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('sales.update', $sale) }}">
                @csrf
                @method('PATCH')
                @include('sales.partials.form', ['sale' => $sale])
            </form>
        </div>
    </div>

</x-layouts.admin>
