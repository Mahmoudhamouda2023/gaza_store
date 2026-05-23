@extends('admin.master')

@section('title', __('admin.order_details'))

@section('css')
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.order') }} #{{ $order->id }}
            </h1>

            <p class="admin-page-subtitle">
                View customer information, order items, payment details, and update order status.
            </p>
        </div>

        <a href="{{ route('admin.orders') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i>
            {{ __('admin.back_to_orders') }}
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card admin-card mb-4">
                <div class="admin-card-header">
                    <div>
                        <h6>
                            <i class="fas fa-box-open mr-1"></i>
                            {{ __('admin.order_items') }}
                        </h6>

                        <span>
                            Total items: {{ $order->order_details->count() }}
                        </span>
                    </div>
                </div>

                <div class="admin-table-wrapper">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover admin-data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.image') }}</th>
                                    <th>{{ __('admin.product') }}</th>
                                    <th>{{ __('admin.category') }}</th>
                                    <th>{{ __('admin.price') }}</th>
                                    <th>{{ __('admin.quantity') }}</th>
                                    <th>{{ __('admin.total') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($order->order_details as $detail)
                                    <tr>
                                        <td>
                                            <img src="{{ $detail->product->image_url }}"
                                                alt="{{ $detail->product->name }}" class="admin-img">
                                        </td>

                                        <td>
                                            <div class="admin-name" title="{{ $detail->product->name }}">
                                                {{ $detail->product->name ?: __('admin.unnamed_product') }}
                                            </div>
                                        </td>

                                        <td>
                                            <span class="admin-category">
                                                {{ $detail->product->category->name ?? __('admin.no_category') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="admin-price">
                                                ${{ number_format((float) $detail->price, 2) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="admin-category">
                                                {{ $detail->quantity }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="admin-price">
                                                ${{ number_format((float) $detail->total, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-box-open fa-2x mb-3 text-gray-400"></i>
                                            <div>{{ __('admin.no_order_details_found') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card admin-card mb-4">
                <div class="admin-card-header">
                    <div>
                        <h6>
                            <i class="fas fa-user mr-1"></i>
                            {{ __('admin.customer_information') }}
                        </h6>
                    </div>
                </div>

                <div class="card-body">
                    <div class="order-info-list">
                        <div class="order-info-item">
                            <span>{{ __('admin.name') }}</span>
                            <strong>{{ $order->user->name ?? '-' }}</strong>
                        </div>

                        <div class="order-info-item">
                            <span>{{ __('admin.email') }}</span>
                            <strong>{{ $order->user->email ?? '-' }}</strong>
                        </div>

                        <div class="order-info-item">
                            <span>{{ __('admin.phone') }}</span>
                            <strong>{{ $order->phone ?? '-' }}</strong>
                        </div>

                        <div class="order-info-item">
                            <span>{{ __('admin.address') }}</span>
                            <strong>{{ $order->address ?? '-' }}</strong>
                        </div>

                        @if ($order->notes)
                            <div class="order-info-item">
                                <span>{{ __('admin.notes') }}</span>
                                <strong>{{ $order->notes }}</strong>
                            </div>
                        @endif

                        <div class="order-info-item">
                            <span>{{ __('admin.order_date') }}</span>
                            <strong>{{ $order->created_at->format('Y-m-d H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card admin-card mb-4">
                <div class="admin-card-header">
                    <div>
                        <h6>
                            <i class="fas fa-receipt mr-1"></i>
                            {{ __('admin.order_summary') }}
                        </h6>
                    </div>
                </div>

                <div class="card-body">
                    <div class="order-summary-total">
                        <span>{{ __('admin.total') }}</span>
                        <strong>${{ number_format((float) $order->total, 2) }}</strong>
                    </div>

                    <hr>

                    <div class="order-info-item">
                        <span>{{ __('admin.order_status') }}</span>

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
                    </div>

                    @if ($order->payment)
                        <div class="order-info-item">
                            <span>{{ __('admin.payment_status') }}</span>

                            @if ($order->payment->status === 'paid')
                                <span class="admin-badge success">
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('admin.paid') }}
                                </span>
                            @elseif ($order->payment->status === 'cancelled')
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
                        </div>

                        <div class="order-info-item">
                            <span>{{ __('admin.payment_method') }}</span>

                            @php
                                $paymentMethod = strtolower($order->payment->payment_method ?? '');
                            @endphp

                            <strong>{{ $paymentMethod ? __('admin.' . $paymentMethod) : '-' }}</strong>
                        </div>

                        <div class="order-info-item">
                            <span>{{ __('admin.transaction_number') }}</span>
                            <strong>{{ $order->payment->transaction_number ?? '-' }}</strong>
                        </div>

                        @if ($order->payment->paid_at)
                            <div class="order-info-item">
                                <span>{{ __('admin.paid_at') }}</span>
                                <strong>{{ $order->payment->paid_at->format('Y-m-d H:i') }}</strong>
                            </div>
                        @endif
                    @else
                        <p class="text-muted mb-0">
                            {{ __('admin.no_payment_record_found') }}
                        </p>
                    @endif

                    <hr>

                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label>
                                <strong>{{ __('admin.update_order_status') }}</strong>
                            </label>

                            <select name="status" class="form-control">
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected($order->status === $value)>
                                        {{ __('admin.' . $value) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save mr-1"></i>
                            {{ __('admin.update_status') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
