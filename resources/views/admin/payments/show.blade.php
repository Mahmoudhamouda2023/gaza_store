@extends('admin.master')

@section('title', __('admin.payment') . ' #' . $payment->id)

@section('content')

    <h1 class="h3 mb-4 text-gray-800">
        {{ __('admin.payment_details') }} #{{ $payment->id }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            {{ __('admin.payment_information') }}
        </div>

        <div class="card-body">
            <p><strong>{{ __('admin.payment_id') }}:</strong> #{{ $payment->id }}</p>

            <p><strong>{{ __('admin.order_id') }}:</strong> #{{ $payment->order_id }}</p>

            <p>
                <strong>{{ __('admin.customer') }}:</strong>
                {{ $payment->user->name ?? ($payment->order->user->name ?? __('admin.guest')) }}
            </p>

            <p>
                <strong>{{ __('admin.email') }}:</strong>
                {{ $payment->user->email ?? ($payment->order->user->email ?? '-') }}
            </p>

            <p>
                <strong>{{ __('admin.total') }}:</strong>
                ${{ number_format((float) ($payment->total ?? 0), 3) }}
            </p>

            <p>
                <strong>{{ __('admin.payment_method') }}:</strong>
                @php
                    $paymentMethod = strtolower($payment->payment_method ?? '');
                @endphp

                {{ $paymentMethod ? __('admin.' . $paymentMethod) : '-' }}
            </p>

            <p>
                <strong>{{ __('admin.status') }}:</strong>

                @if ($payment->status === 'paid')
                    <span class="badge badge-success">{{ __('admin.paid') }}</span>
                @elseif ($payment->status === 'pending')
                    <span class="badge badge-warning">{{ __('admin.pending') }}</span>
                @elseif ($payment->status === 'unpaid')
                    <span class="badge badge-secondary">{{ __('admin.unpaid') }}</span>
                @else
                    <span class="badge badge-danger">{{ __('admin.unknown') }}</span>
                @endif
            </p>

            <p>
                <strong>{{ __('admin.transaction_number') }}:</strong>
                {{ $payment->transaction_number ?? '-' }}
            </p>

            <p>
                <strong>{{ __('admin.stripe_session_id') }}:</strong>
                {{ $payment->stripe_session_id ?? '-' }}
            </p>

            <p>
                <strong>{{ __('admin.stripe_payment_intent') }}:</strong>
                {{ $payment->stripe_payment_intent_id ?? '-' }}
            </p>

            <p>
                <strong>{{ __('admin.paid_at') }}:</strong>
                {{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '-' }}
            </p>

            <p>
                <strong>{{ __('admin.date') }}:</strong>
                {{ $payment->created_at?->format('Y-m-d H:i') }}
            </p>

            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">
                {{ __('admin.back') }}
            </a>

            <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="btn btn-primary mt-3">
                {{ __('admin.view_order') }}
            </a>
        </div>
    </div>

@endsection
