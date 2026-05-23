@extends('admin.master')

@section('title', 'Dashboard')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        ${{ number_format((float) $totalRevenue, 3) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Customers</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Payments</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPayments }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paid Payments</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidPayments }}</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        {{-- Latest Orders --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Orders</h6>

                    <a href="#" class="btn btn-sm btn-primary disabled">
                        View All
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($latestOrders as $order)
                                    <tr>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                #{{ $order->id }}
                                            </span>
                                        </td>

                                        <td>{{ $order->user->name ?? 'Guest' }}</td>

                                        <td>
                                            ${{ number_format((float) ($order->total ?? 0), 3) }}
                                        </td>

                                        <td>
                                            @if ($order->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($order->status === 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif ($order->status === 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    {{ ucfirst($order->status ?? 'Unknown') }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No orders found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Latest Payments --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">Latest Payments</h6>

                    <a href="#" class="btn btn-sm btn-success disabled">
                        View All
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Payment</th>
                                    <th>Customer</th>
                                    <th>Method</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($latestPayments as $payment)
                                    <tr>
                                        <td>
                                            <span class="font-weight-bold text-success">
                                                #{{ $payment->id }}
                                            </span>
                                        </td>

                                        <td>{{ $payment->user->name ?? 'Guest' }}</td>

                                        <td>
                                            {{ ucwords(str_replace('_', ' ', $payment->payment_method ?? '-')) }}
                                        </td>

                                        <td>
                                            ${{ number_format((float) ($payment->total ?? 0), 3) }}
                                        </td>

                                        <td>
                                            @if ($payment->status === 'paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif ($payment->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($payment->status === 'failed')
                                                <span class="badge badge-danger">Failed</span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    {{ ucfirst($payment->status ?? 'Unknown') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No payments found.
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

@endsection
