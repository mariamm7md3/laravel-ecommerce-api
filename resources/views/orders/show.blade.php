<x-layouts.admin title="{{ __('orders.order_number', ['id' => $order->id]) }}">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-arrow-right me-1"></i>{{ __('orders.back_to_orders') }}
            </a>
            <h4 class="mb-0 mt-1">{{ __('orders.order_number', ['id' => $order->id]) }}</h4>
            <span class="text-muted small">{{ $order->date->format('M d, Y h:i A') }}</span>
        </div>


        <div style="min-width: 220px;">
            @include('orders.partials.status-dropdown', ['order' => $order])
        </div>
    </div>

    @include('orders.partials.order-timeline', ['order' => $order])

    <div class="row">
        {{-- Main column --}}
        <div class="col-lg-8">

            {{-- Items --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('orders.items') }}</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="border-top">
                        <tr>
                            <th>{{ __('orders.product') }}</th>
                            <th class="text-center">{{ __('orders.quantity') }}</th>
                            <th class="text-center">{{ __('orders.unit_price') }}</th>
                            <th class="text-end">{{ __('orders.item_total') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            @php $product = $item->variant->product; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->getImageUrl($product->photo) }}"
                                             alt=""
                                             class="rounded-2 me-2"
                                             style="width: 48px; height: 48px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $product->name[app()->getLocale()] }}</h6>
                                            <span class="text-muted small">
                                                {{ $item->variant->productSize->name[app()->getLocale()] }}
                                                &middot;
                                                {{ $item->variant->productUnit->name[app()->getLocale()] }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-medium">{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($order->additional_info)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('orders.additional_info') }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->additional_info }}</p>
                    </div>
                </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Customer --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('orders.customer') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        @if($order->user->photo)
                            <img src="{{ $order->user->photo_url }}" alt=""
                                 class="rounded-2 me-2" style="width: 44px; height: 44px; object-fit: cover;">
                        @else
                            <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                 style="width: 44px; height: 44px; font-size: 16px;">
                                {{ strtoupper(substr($order->user->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $order->user->first_name }} {{ $order->user->last_name }}</h6>
                            <span class="text-muted small">{{ $order->user->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Delivery --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('orders.delivery_details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="text-muted small d-block">{{ __('orders.branch') }}</span>
                        <span class="fw-medium">{{ $order->branch->name[app()->getLocale()] }}</span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">{{ __('orders.delivery_time') }}</span>
                        <span class="fw-medium">
                            {{ __('general.days.' . $order->deliveryTime->day_of_week) }},
                            {{ $order->deliveryTime->start_time->format('h:i A') }}
                            -
                            {{ $order->deliveryTime->end_time->format('h:i A') }}
                        </span>
                    </div>

                    <div>
                        <span class="text-muted small d-block">{{ __('orders.address') }}</span>
                        <span class="fw-medium">
                            {{ $order->address->governate }}, {{ $order->address->neighborhood }}
                        </span>
                        <div class="text-muted small">
                            {{ __('orders.building') }} {{ $order->address->building }},
                            {{ __('orders.floor') }} {{ $order->address->floor }},
                            {{ __('orders.apartment') }} {{ $order->address->apartment }}
                        </div>
                        @if($order->address->details)
                            <div class="text-muted small">{{ $order->address->details }}</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('orders.summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('orders.sub_total') }}</span>
                        <span>{{ number_format($order->sub_total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('orders.shipping') }}</span>
                        <span>{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>{{ __('orders.discount') }}</span>
                            <span>-{{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>{{ __('orders.total') }}</span>
                        <span>{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($order->rate)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('orders.customer_rating') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="ti ti-star-filled {{ $i <= $order->rate->stars ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                            @endfor
                        </div>

                        @if($order->rate->message)
                            <p class="mb-0 text-muted">{{ $order->rate->message }}</p>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-layouts.admin>
