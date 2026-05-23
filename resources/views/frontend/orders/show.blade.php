@extends('frontend.layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                    <p class="text-gray-500 mt-1">Order details and tracking information</p>
                </div>

                <a href="{{ route('frontend.orders.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 transition">
                    Back to Orders
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $status = $order->status ?? 'pending';
                $paymentStatus = $order->payment?->status ?? 'pending';

                $statusClass = match ($status) {
                    'processing' => 'bg-blue-100 text-blue-700',
                    'shipped' => 'bg-indigo-100 text-indigo-700',
                    'delivered' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                    default => 'bg-yellow-100 text-yellow-700',
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Order Summary</h2>
                        </div>

                        <div class="p-5 space-y-3 text-sm">
                            <p><span class="font-semibold">Order ID:</span> #{{ $order->id }}</p>
                            <p><span class="font-semibold">Date:</span> {{ $order->created_at?->format('Y-m-d H:i') }}</p>

                            <p>
                                <span class="font-semibold">Order Status:</span>
                                <span class="ml-2 px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </p>

                            <p>
                                <span class="font-semibold">Payment Method:</span>
                                {{ ucfirst(str_replace('_', ' ', $order->payment?->payment_method ?? '-')) }}
                            </p>

                            <p>
                                <span class="font-semibold">Payment Status:</span>
                                <span class="ml-2 px-2 py-1 rounded-full text-xs font-semibold {{ $paymentClass }}">
                                    {{ $paymentLabel }}
                                </span>
                            </p>

                            @if ($order->payment?->transaction_number)
                                <p>
                                    <span class="font-semibold">Transaction No:</span>
                                    {{ $order->payment->transaction_number }}
                                </p>
                            @endif

                            <div class="border-t border-gray-100 pt-4 mt-4">
                                <p class="text-lg font-bold text-gray-900">
                                    Total: ${{ number_format($order->total ?? 0, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Customer Information</h2>
                        </div>

                        <div class="p-5 space-y-3 text-sm text-gray-700">
                            <p><span class="font-semibold text-gray-900">Name:</span> {{ $order->user->name ?? 'Guest' }}
                            </p>
                            <p><span class="font-semibold text-gray-900">Email:</span> {{ $order->user->email ?? '-' }}</p>
                            <p><span class="font-semibold text-gray-900">Phone:</span> {{ $order->phone ?? '-' }}</p>
                            <p><span class="font-semibold text-gray-900">Address:</span> {{ $order->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Order Items</h2>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-5 py-3 text-left font-semibold">Product</th>
                                        <th class="px-5 py-3 text-center font-semibold">Qty</th>
                                        <th class="px-5 py-3 text-right font-semibold">Price</th>
                                        <th class="px-5 py-3 text-right font-semibold">Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($order->order_details ?? [] as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-5 py-4">
                                                <div class="font-medium text-gray-900">
                                                    {{ $item->product->name ?? 'Product' }}
                                                </div>
                                            </td>

                                            <td class="px-5 py-4 text-center text-gray-700">
                                                {{ $item->quantity ?? 1 }}
                                            </td>

                                            <td class="px-5 py-4 text-right text-gray-700">
                                                ${{ number_format($item->price ?? 0, 2) }}
                                            </td>

                                            <td class="px-5 py-4 text-right font-semibold text-gray-900">
                                                ${{ number_format($item->total ?? ($item->price ?? 0) * ($item->quantity ?? 1), 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                                                No items found for this order.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
