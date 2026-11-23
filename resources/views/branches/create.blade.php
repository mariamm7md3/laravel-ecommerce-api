<x-layouts.admin title="{{ __('branches.create_branch') }}">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('branches.create_branch') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('branches.store') }}">
                @csrf

                @include('branches.partials.form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('branches.save') }}</button>
                    <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">{{ __('branches.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>
