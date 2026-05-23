@extends('admin.master')

@section('title', __('admin.payments'))

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.payments') }}
            </h1>

            <p class="admin-page-subtitle">
                Manage, search, sort, and track all payment transactions from one place.
            </p>
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
                    <i class="fas fa-credit-card mr-1"></i>
                    {{ __('admin.payments') }}
                </h6>

                <span>Total payments: {{ $payments->count() }}</span>
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
                            <th>{{ __('admin.payment_id') }}</th>
                            <th>{{ __('admin.order_id') }}</th>
                            <th>{{ __('admin.customer') }}</th>
                            <th>{{ __('admin.email') }}</th>
                            <th>{{ __('admin.total') }}</th>
                            <th>{{ __('admin.method') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th>{{ __('admin.transaction_number') }}</th>
                            <th>{{ __('admin.date') }}</th>
                            <th class="text-center no-sort">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($payments as $payment)
                            @php
                                $method = strtolower($payment->payment_method ?? 'unknown');
                            @endphp

                            <tr>
                                <td>
                                    <span class="admin-index">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <span class="admin-name">
                                        #{{ $payment->id }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('admin.orders.show', $payment->order_id) }}"
                                        class="admin-name text-primary">
                                        #{{ $payment->order_id }}
                                    </a>
                                </td>

                                <td>
                                    {{ $payment->user->name ?? ($payment->order->user->name ?? __('admin.guest')) }}
                                </td>

                                <td>
                                    {{ $payment->user->email ?? ($payment->order->user->email ?? '-') }}
                                </td>

                                <td>
                                    <span class="admin-price">
                                        ${{ number_format((float) ($payment->total ?? 0), 3) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="admin-badge info">
                                        <i class="fas fa-wallet"></i>
                                        {{ __('admin.' . $method) }}
                                    </span>
                                </td>

                                <td>
                                    @if ($payment->status === 'paid')
                                        <span class="admin-badge success">
                                            <i class="fas fa-check-circle"></i>
                                            {{ __('admin.paid') }}
                                        </span>
                                    @elseif ($payment->status === 'pending')
                                        <span class="admin-badge warning">
                                            <i class="fas fa-clock"></i>
                                            {{ __('admin.pending') }}
                                        </span>
                                    @elseif ($payment->status === 'unpaid')
                                        <span class="admin-badge secondary">
                                            <i class="fas fa-minus-circle"></i>
                                            {{ __('admin.unpaid') }}
                                        </span>
                                    @else
                                        <span class="admin-badge danger">
                                            <i class="fas fa-times-circle"></i>
                                            {{ ucfirst($payment->status ?? __('admin.unknown')) }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="admin-description" title="{{ $payment->transaction_number ?? '-' }}">
                                        {{ $payment->transaction_number ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $payment->created_at ? $payment->created_at->format('Y-m-d H:i') : '-' }}
                                </td>

                                <td class="text-center">
                                    <div class="admin-actions justify-content-center">
                                        <a class="btn btn-primary" href="{{ route('admin.payments.show', $payment->id) }}"
                                            title="{{ __('admin.show') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="fas fa-credit-card fa-2x mb-3 text-gray-400"></i>
                                    <div>{{ __('admin.no_payments_found') }}</div>
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
