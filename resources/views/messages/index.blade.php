<x-layouts.admin title="{{ __('usermsg.messages') }}">

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('messages.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-3">
                        <select name="status" class="form-select">
                            <option value="">{{ __('usermsg.all_status') }}</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>{{ __('usermsg.unread') }}</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>{{ __('usermsg.read') }}</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>{{ __('usermsg.replied') }}</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>{{ __('usermsg.archived') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <select name="per_page" class="form-select">
                            @foreach([7, 10, 25, 50] as $number)
                                <option value="{{ $number }}" {{ request('per_page', 7) == $number ? 'selected' : '' }}>
                                    {{ $number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1">
                            <i class="ti ti-search me-1"></i> {{ __('usermsg.filter') }}
                        </button>
                        <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('usermsg.messages') }}</h5>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="border-top">
                <tr>
                    <th>{{ __('usermsg.from') }}</th>
                    <th>{{ __('usermsg.title') }}</th>
                    <th class="text-center">{{ __('usermsg.status') }}</th>
                    <th>{{ __('usermsg.date') }}</th>
                    <th class="text-center">{{ __('usermsg.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($message->user->photo)
                                    <img src="{{ $message->user->photo_url }}" alt=""
                                         class="rounded-2 me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                         style="width: 40px; height: 40px; font-size: 16px;">
                                        {{ strtoupper(substr($message->user->first_name, 0, 1)) }}
                                    </div>
                                @endif
                                <h6 class="mb-0">{{ $message->user->first_name }} {{ $message->user->last_name }}</h6>
                            </div>
                        </td>
                        <td>{{ Str::limit($message->title, 40) }}</td>
                        <td class="text-center">
                            @if($message->status->value === 'replied')
                                <span class="badge bg-label-success">{{ __('usermsg.replied') }}</span>
                            @elseif($message->status->value === 'unread')
                                <span class="badge bg-label-danger">{{ __('usermsg.unread') }}</span>
                            @elseif($message->status->value === 'archived')
                                <span class="badge bg-label-secondary">{{ __('usermsg.archived') }}</span>
                            @else
                                <span class="badge bg-label-warning">{{ __('usermsg.read') }}</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $message->created_at->format('M d, Y') }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-icon text-info">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('messages.destroy', $message) }}"
                                      class="delete-form"
                                      data-message="{{ __('usermsg.delete_message_confirm') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon text-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">{{ __('usermsg.no_messages_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $messages->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-layouts.admin>
