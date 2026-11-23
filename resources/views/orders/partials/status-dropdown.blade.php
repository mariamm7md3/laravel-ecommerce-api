<select
    class="form-select form-select-sm toggle-status"
    data-url="{{ route('orders.update-status', $order) }}"
    {{ empty($order->status->allowedTransitions($order)) ? 'disabled' : '' }}
>
    <option value="{{ $order->status->value }}" selected>
        {{ $order->status->label() }}
    </option>

    @foreach($order->status->allowedTransitions($order) as $transition)
        <option value="{{ $transition->value }}">
            {{ $transition->label() }}
        </option>
    @endforeach
</select>
