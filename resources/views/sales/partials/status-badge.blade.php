@switch($sale->status)
    @case('active')
        <span class="badge bg-label-success">{{ __('sales.active') }}</span>
        @break
    @case('upcoming')
        <span class="badge bg-label-warning">{{ __('sales.upcoming') }}</span>
        @break
    @case('expired')
        <span class="badge bg-label-danger">{{ __('sales.expired') }}</span>
        @break
    @default
        <span class="badge bg-label-secondary">{{ __('sales.inactive') }}</span>
@endswitch
