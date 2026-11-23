@php
    use App\Enums\OrderStatus;

    $isOnlinePayment = $order->payment
        && in_array($order->payment->paymentMethod->name, ['online_payment', 'pay_from_link']);

    if ($isOnlinePayment) {
        $flow = [OrderStatus::Pending, OrderStatus::Paid, OrderStatus::Requested, OrderStatus::OnDelivery, OrderStatus::Delivered];
    } else {
        $flow = [OrderStatus::Pending, OrderStatus::Requested, OrderStatus::OnDelivery, OrderStatus::Delivered];
    }

    $currentIndex = array_search($order->status, $flow, true);
    $isCancelled = $order->status === OrderStatus::Cancelled;
@endphp

@if($isCancelled)
    <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="ti ti-circle-x fs-4 me-2"></i>
        <div>
            <strong>{{ __('orders.order_cancelled_title') }}</strong>
            <div class="small">{{ __('orders.order_cancelled_desc') }}</div>
        </div>
    </div>
@endif

<div class="order-timeline {{ $isCancelled ? 'order-timeline-muted' : '' }} mb-4">
    @foreach($flow as $index => $step)
        <div class="order-timeline-step {{ $index <= $currentIndex && !$isCancelled ? 'is-done' : '' }} {{ $index === $currentIndex && !$isCancelled ? 'is-current' : '' }}">
            <div class="order-timeline-dot">
                @if($index < $currentIndex && !$isCancelled)
                    <i class="ti ti-check"></i>
                @else
                    {{ $index + 1 }}
                @endif
            </div>
            <div class="order-timeline-label">{{ $step->label() }}</div>
        </div>
        @if(!$loop->last)
            <div class="order-timeline-line {{ $index < $currentIndex && !$isCancelled ? 'is-done' : '' }}"></div>
        @endif
    @endforeach
</div>

<style>
    .order-timeline {
        display: flex;
        align-items: flex-start;
    }
    .order-timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 90px;
    }
    .order-timeline-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f1f2;
        color: #8a8d93;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        border: 2px solid #f1f1f2;
        transition: all .2s ease;
    }
    .order-timeline-step.is-done .order-timeline-dot {
        background: #71dd37;
        border-color: #71dd37;
        color: #fff;
    }
    .order-timeline-step.is-current .order-timeline-dot {
        background: #fff;
        border-color: #696cff;
        color: #696cff;
        box-shadow: 0 0 0 4px rgba(105,108,255,.15);
    }
    .order-timeline-label {
        margin-top: 6px;
        font-size: 12px;
        color: #8a8d93;
        text-align: center;
    }
    .order-timeline-step.is-done .order-timeline-label,
    .order-timeline-step.is-current .order-timeline-label {
        color: #566a7f;
        font-weight: 600;
    }
    .order-timeline-line {
        flex: 1;
        height: 2px;
        background: #f1f1f2;
        margin-top: 15px;
    }
    .order-timeline-line.is-done {
        background: #71dd37;
    }
    .order-timeline-muted .order-timeline-dot {
        opacity: .5;
    }
</style>
