@extends('admin.master')

@section('title', __('admin.customers'))

@section('content')

    <h1 class="h3 mb-4 text-gray-800">
        {{ __('admin.customers') }}
    </h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr class="bg-dark text-white">
                    <th>#</th>
                    <th>{{ __('admin.customer_id') }}</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.email') }}</th>
                    <th>{{ __('admin.orders') }}</th>
                    <th>{{ __('admin.joined_at') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customers->firstItem() + $loop->index }}</td>

                        <td>#{{ $customer->id }}</td>

                        <td>{{ $customer->name ?? '-' }}</td>

                        <td>{{ $customer->email ?? '-' }}</td>

                        <td>
                            <span class="badge badge-info px-3 py-2">
                                {{ $customer->orders_count }}
                            </span>
                        </td>

                        <td>{{ $customer->created_at?->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            {{ __('admin.no_customers_found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $customers->links() }}
    </div>

@endsection
