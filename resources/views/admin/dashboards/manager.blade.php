@extends('admin.master')

@section('title', 'Manager Dashboard')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Manager Dashboard</h1>

    <div class="alert alert-info">
        Welcome Manager, here is your financial and customer overview.
    </div>

    <div class="row">

        @can('view payments')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($totalRevenue, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalPayments }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Paid Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $paidPayments }}
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        @can('view customers')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Customers
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalCustomers }}
                        </div>
                    </div>
                </div>
            </div>
        @endcan

    </div>

    @can('view payments')
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Latest Payments</h6>

                <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-primary">
                    View All
                </a>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestPayments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->user->name ?? '-' }}</td>
                                <td>#{{ $payment->order->id ?? '-' }}</td>
                                <td>${{ number_format($payment->total, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $payment->status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at ? $payment->created_at->format('d M Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endcan

@endsection
