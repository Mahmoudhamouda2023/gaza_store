@extends('admin.master')

@section('title', 'All Notifications')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">All Notifications</h1>

    <div class="list-group">
        @forelse ($notifications as $item)
            <a href="{{ $item->data['url'] }}?id={{ $item->id }}"
                class="list-group-item list-group-item-action {{ $item->read_at ? '' : 'list-group-item-warning' }}">
                <div class="d-flex justify-content-between">
                    <span>{{ $item->data['msg'] }}</span>
                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                </div>
            </a>
        @empty
            <div class="list-group-item text-center text-muted">
                No notifications found.
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
@endsection
