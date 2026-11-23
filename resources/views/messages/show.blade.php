<x-layouts.admin title="{{ __('usermsg.message_details') }}">

    {{-- Toast Notification --}}
    @if(session('success'))
        <div id="app-toast" class="alert alert-success app-toast" role="alert">
            <i class="ti ti-check me-2"></i>
            {{ session('success') }}
        </div>

        <style>
            .app-toast {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 280px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                opacity: 0;
                transform: translateY(-10px);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .app-toast.show {
                opacity: 1;
                transform: translateY(0);
            }

            .app-toast.hide {
                opacity: 0;
                transform: translateY(-10px);
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toast = document.getElementById('app-toast');
                if (!toast) return;

                requestAnimationFrame(() => toast.classList.add('show'));

                setTimeout(() => {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            });
        </script>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ __('usermsg.message_details') }}</h4>
            <p class="text-muted mb-0">{{ __('usermsg.view_reply_subtitle') }}</p>
        </div>
        <a href="{{ route('messages.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            {{ __('usermsg.back') }}
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $message->title }}</h5>
            @if($message->status->value === 'replied')
                <span class="badge bg-label-success">{{ __('usermsg.replied') }}</span>
            @elseif($message->status->value === 'unread')
                <span class="badge bg-label-danger">{{ __('usermsg.unread') }}</span>
            @elseif($message->status->value === 'archived')
                <span class="badge bg-label-secondary">{{ __('usermsg.archived') }}</span>
            @else
                <span class="badge bg-label-warning">{{ __('usermsg.read') }}</span>
            @endif
        </div>

        <div class="card-body">
            <div class="row py-3 border-bottom">
                <div class="col-md-3 fw-semibold text-muted">{{ __('usermsg.from') }}</div>
                <div class="col-md-9">
                    {{ $message->user->first_name }} {{ $message->user->last_name }}
                    <small class="text-muted d-block">{{ $message->user->email }}</small>
                </div>
            </div>

            <div class="row py-3">
                <div class="col-md-3 fw-semibold text-muted">{{ __('usermsg.message') }}</div>
                <div class="col-md-9">{{ $message->body }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('usermsg.send_reply') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('messages.reply', $message) }}">
                @csrf
                <div class="mb-3">
                    <textarea name="reply_body" class="form-control" rows="5"
                              placeholder="{{ __('usermsg.reply_placeholder') }}">{{ old('reply_body') }}</textarea>
                    @error('reply_body')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-send me-1"></i>
                    {{ __('usermsg.send_reply') }}
                </button>
            </form>
        </div>
    </div>

</x-layouts.admin>
