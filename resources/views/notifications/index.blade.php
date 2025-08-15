<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your Notifications
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="card-header d-flex justify-content-between align-items-center p-4 border-b">
                    <h5 class="mb-0">Your Notifications</h5>
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            Mark All as Read
                        </button>
                    </form>
                </div>

                <div class="card-body p-4">
                    @if($notifications->isEmpty())
                        <div class="alert alert-info">You have no notifications.</div>
                    @else
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                   class="list-group-item list-group-item-action flex-column align-items-start
                                          @if($notification->unread()) list-group-item-primary @endif">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $notification->data['message'] ?? 'Notification' }}</h6>
                                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if(isset($notification->data['type']))
                                        <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $notification->data['type'])) }}</small>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
