<x-layouts.admin title="{{ __('industries.edit_industry') }}">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('industries.edit_industry') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('industries.update', $industry) }}">
                @csrf
                @method('PUT')

                @include('industries.partials.form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('industries.save') }}</button>
                    <a href="{{ route('industries.index') }}" class="btn btn-outline-secondary">{{ __('industries.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>
