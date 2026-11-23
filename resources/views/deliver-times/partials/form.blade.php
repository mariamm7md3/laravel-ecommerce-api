@php
    $deliveryTime = $deliveryTime ?? null;
@endphp

<div class="row g-4">

    <div class="col-lg-6">
        <label class="form-label">{{ __('delivery_times.branch') }}</label>
        <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
            <option value="">{{ __('delivery_times.select_branch') }}</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ old('branch_id', $deliveryTime->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name[app()->getLocale()] }}
                </option>
            @endforeach
        </select>
        @error('branch_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ __('delivery_times.day') }}</label>
        <select name="day_of_week" class="form-select @error('day_of_week') is-invalid @enderror">
            <option value="">{{ __('delivery_times.select_day') }}</option>
            @foreach($days as $day)
                <option value="{{ $day }}"
                    {{ old('day_of_week', $deliveryTime->day_of_week ?? '') == $day ? 'selected' : '' }}>
                    {{ __('general.days.' . $day) }}
                </option>
            @endforeach
        </select>
        @error('day_of_week')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('delivery_times.start_time') }}</label>
        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
               value="{{ old('start_time', $deliveryTime->start_time ?? '') }}">
        @error('start_time')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ __('delivery_times.end_time') }}</label>
        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
               value="{{ old('end_time', $deliveryTime->end_time ?? '') }}">
        @error('end_time')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-4 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $deliveryTime->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ __('delivery_times.active') }}</label>
        </div>
    </div>

</div>
