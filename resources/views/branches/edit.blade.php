<x-layouts.admin title="{{ __('branches.edit_branch') }}">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('branches.edit_branch') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('branches.update', $branch) }}">
                @csrf
                @method('PUT')

                @include('branches.partials.form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('branches.save') }}</button>
                    <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">{{ __('branches.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>
