@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-bell me-2"></i> Your Notifications
    </h2>
    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-check me-1"></i> Mark All as Read
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if($notifications->isEmpty())
                    <div class="alert alert-info m-4 text-center">
                        <i class="fa-solid fa-info-circle me-2"></i> You have no notifications.
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-start
                                      @if($notification->unread()) list-group-item-primary @endif"
                               aria-label="{{ $notification->data['message'] ?? 'Notification' }}">
                                <div class="ms-2 me-auto">
                                    <div class="fw-semibold">{{ $notification->data['message'] ?? 'Notification' }}</div>
                                    @if(isset($notification->data['type']))
                                        <small class="text-muted">
                                            {{ ucfirst(str_replace('_', ' ', $notification->data['type'])) }}
                                        </small>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-3 px-4">
                        {{ $notifications->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Optional: highlight unread notifications on hover
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('mouseenter', () => item.classList.add('shadow-sm'));
        item.addEventListener('mouseleave', () => item.classList.remove('shadow-sm'));
    });
</script>
@endpush
@endsection
