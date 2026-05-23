@extends('admin.master')

@section('title', __('admin.orders'))

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.orders') }}
            </h1>


        </div>
    </div>

    @if (session()->has('msg'))
        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
            {{ session('msg') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card admin-card">
        <div class="admin-card-header">
            <div>
                <h6>
                    <i class="fas fa-shopping-cart mr-1"></i>
                    {{ __('admin.orders') }}
                </h6>

                <span>Total orders: {{ $orders->count() }}</span>
            </div>

            <span>
                <i class="fas fa-table mr-1"></i>
                DataTable View
            </span>
        </div>

        <div class="admin-table-wrapper">
            <div class="table-responsive">
                <table class="table table-bordered table-hover admin-data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.order_id') }}</th>
                            <th>{{ __('admin.customer') }}</th>
                            <th>{{ __('admin.email') }}</th>
                            <th>{{ __('admin.total') }}</th>
                            <th>{{ __('admin.items') }}</th>
                            <th>{{ __('admin.order_status') }}</th>
                            <th>{{ __('admin.payment') }}</th>
                            <th>{{ __('admin.payment_status') }}</th>
                            <th>{{ __('admin.date') }}</th>
                            <th class="text-center no-sort">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $paymentMethod = strtolower($order->payment->payment_method ?? '');
                                $paymentStatus = $order->payment->status ?? null;
                            @endphp

                            <tr>
                                <td>
                                    <span class="admin-index">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <span class="admin-name">
                                        #{{ $order->id }}
                                    </span>
                                </td>

                                <td>
                                    {{ $order->user->name ?? __('admin.guest') }}
                                </td>

                                <td>
                                    {{ $order->user->email ?? '-' }}
                                </td>

                                <td>
                                    <span class="admin-price">
                                        ${{ number_format((float) ($order->total ?? 0), 2) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="admin-category">
                                        {{ $order->order_details_count ?? $order->order_details->count() }}
                                    </span>
                                </td>

                                <td>
                                    @if ($order->status === 'pending')
                                        <span class="admin-badge warning">
                                            <i class="fas fa-clock"></i>
                                            {{ __('admin.pending_review') }}
                                        </span>
                                    @elseif ($order->status === 'processing')
                                        <span class="admin-badge info">
                                            <i class="fas fa-spinner"></i>
                                            {{ __('admin.processing') }}
                                        </span>
                                    @elseif ($order->status === 'shipped')
                                        <span class="admin-badge primary">
                                            <i class="fas fa-shipping-fast"></i>
                                            {{ __('admin.shipped') }}
                                        </span>
                                    @elseif ($order->status === 'delivered')
                                        <span class="admin-badge success">
                                            <i class="fas fa-check-circle"></i>
                                            {{ __('admin.delivered') }}
                                        </span>
                                    @elseif ($order->status === 'cancelled')
                                        <span class="admin-badge danger">
                                            <i class="fas fa-times-circle"></i>
                                            {{ __('admin.cancelled') }}
                                        </span>
                                    @else
                                        <span class="admin-badge secondary">
                                            <i class="fas fa-question-circle"></i>
                                            {{ __('admin.unknown') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $paymentMethod ? __('admin.' . $paymentMethod) : '-' }}
                                </td>

                                <td>
                                    @if ($paymentStatus === 'paid')
                                        <span class="admin-badge success">
                                            <i class="fas fa-check-circle"></i>
                                            {{ __('admin.paid') }}
                                        </span>
                                    @elseif ($paymentStatus === 'cancelled')
                                        <span class="admin-badge danger">
                                            <i class="fas fa-times-circle"></i>
                                            {{ __('admin.cancelled') }}
                                        </span>
                                    @else
                                        <span class="admin-badge warning">
                                            <i class="fas fa-clock"></i>
                                            {{ __('admin.pending') }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '-' }}
                                </td>

                                <td class="text-center">
                                    <div class="admin-actions justify-content-center">
                                        <a class="btn btn-primary" href="{{ route('admin.orders.show', $order->id) }}"
                                            title="{{ __('admin.show') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="fas fa-shopping-cart fa-2x mb-3 text-gray-400"></i>
                                    <div>{{ __('admin.no_orders_found') }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('back/js/admin-datatables.js') }}"></script>
@endsection
