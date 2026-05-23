@extends('frontend.layouts.app')

@section('title', 'My Orders | Gaza Store')

@section('content')
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8">
                <h1 class="text-4xl font-extrabold text-gray-900">My Orders</h1>
                <p class="text-gray-500 mt-2">View and track your previous orders.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                @if ($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700">Order ID</th>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700">Date</th>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700">Total</th>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700">Order Status</th>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700">Payment</th>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700">Payment Status</th>
                                    <th class="px-6 py-4 text-sm font-bold text-gray-700 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    @php
                                        $status = $order->status ?? 'pending';
                                        $paymentStatus = $order->payment->status ?? 'pending';

                                        $statusClass = match ($status) {
                                            'delivered' => 'bg-green-100 text-green-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-indigo-100 text-indigo-700',
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };

                                        $statusLabel = match ($status) {
                                            'pending' => 'Pending Review',
                                            'processing' => 'Processing',
                                            'shipped' => 'Shipped',
                                            'delivered' => 'Delivered',
                                            'cancelled' => 'Cancelled',
                                            default => ucfirst($status),
                                        };

                                        $paymentClass = match ($paymentStatus) {
                                            'paid' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };

                                        $paymentLabel = match ($paymentStatus) {
                                            'paid' => 'Paid',
                                            'cancelled' => 'Cancelled',
                                            default => 'Pending',
                                        };
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-5 font-semibold text-gray-900">
                                            #{{ $order->id }}
                                        </td>

                                        <td class="px-6 py-5 text-gray-600">
                                            {{ $order->created_at?->format('Y-m-d H:i') }}
                                        </td>

                                        <td class="px-6 py-5 font-bold text-gray-900">
                                            ${{ number_format($order->total ?? 0, 2) }}
                                        </td>

                                        <td class="px-6 py-5">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5 text-gray-700">
                                            {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method ?? '-')) }}
                                        </td>

                                        <td class="px-6 py-5">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $paymentClass }}">
                                                {{ $paymentLabel }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5 text-right">
                                            <a href="{{ route('frontend.orders.show', $order->id) }}"
                                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-black text-white text-sm font-semibold hover:bg-gray-800 transition">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">No orders yet</h2>
                        <p class="text-gray-500 mb-6">Your orders will appear here after checkout.</p>

                        <a href="{{ route('frontend.products.index') }}"
                            class="inline-flex px-6 py-3 rounded-lg bg-black text-white font-semibold hover:bg-gray-800 transition">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
