<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #111;
        }

        .wrapper {
            max-width: 640px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #e5e5e5;
        }

        /* Header */
        .header {
            background: #111;
            color: #fff;
            padding: 32px 40px;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .header .sub {
            font-size: 0.8rem;
            color: #aaa;
            margin-top: 4px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta .label {
            font-size: 0.75rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .invoice-meta .value {
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 2px;
        }

        /* Body */
        .body {
            padding: 32px 40px;
        }

        .greeting {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .greeting strong {
            color: #111;
        }

        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 16px;
        }

        .info-col h3 {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #999;
            margin-bottom: 8px;
        }

        .info-col p {
            font-size: 0.88rem;
            color: #333;
            line-height: 1.7;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 3px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-completed {
            background: #dcfce7;
            color: #166534;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Items Table */
        .section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #999;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        thead tr {
            background: #f9f9f9;
        }

        th {
            text-align: left;
            padding: 10px 12px;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #888;
            border-bottom: 1px solid #eee;
        }

        td {
            padding: 12px 12px;
            font-size: 0.88rem;
            border-bottom: 1px solid #f3f3f3;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        /* Totals */
        .totals {
            border-top: 2px solid #111;
            padding-top: 16px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 0.88rem;
            color: #555;
        }

        .totals-row.grand {
            font-size: 1rem;
            font-weight: 700;
            color: #111;
            padding-top: 10px;
            border-top: 1px solid #eee;
            margin-top: 6px;
        }

        /* Payment */
        .payment-box {
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 16px 20px;
            margin-top: 24px;
            border-radius: 4px;
        }

        .payment-box h3 {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #999;
            margin-bottom: 10px;
        }

        .payment-box p {
            font-size: 0.88rem;
            color: #333;
            line-height: 1.7;
        }

        /* Footer */
        .footer {
            background: #f9f9f9;
            border-top: 1px solid #eee;
            padding: 20px 40px;
            text-align: center;
        }

        .footer p {
            font-size: 0.8rem;
            color: #aaa;
            line-height: 1.8;
        }

        .footer strong {
            color: #111;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <div class="header-inner">
                <div>
                    <h1>GAZA STORE</h1>
                    <p class="sub">Online Shopping</p>
                </div>
                <div class="invoice-meta">
                    <div class="label">Invoice</div>
                    <div class="value">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="label" style="margin-top:6px;">{{ $order->created_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="body">

            {{-- Greeting --}}
            <div class="greeting">
                Hello, <strong>{{ $order->user->name ?? 'Customer' }}</strong> 👋<br>
                Thank you for your order! Here is your invoice summary.
            </div>

            {{-- Order Info + Customer Info --}}
            <div class="info-grid">
                <div class="info-col">
                    <h3>Order Details</h3>
                    <p>
                        <strong>Order #:</strong> {{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
                        <strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}<br>
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </p>
                </div>
                <div class="info-col">
                    <h3>Customer Details</h3>
                    <p>
                        {{ $order->user->name ?? 'N/A' }}<br>
                        {{ $order->user->email ?? 'N/A' }}<br>
                        {{ $order->phone }}<br>
                        {{ $order->address }}
                    </p>
                </div>
            </div>

            {{-- Items --}}
            <p class="section-title">Order Items</p>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_details as $i => $detail)
                        <tr>
                            <td style="color:#aaa;">{{ $i + 1 }}</td>
                            <td>{{ $detail->product->name ?? 'Product' }}</td>
                            <td class="text-right">${{ number_format((float) $detail->price, 2) }}</td>
                            <td class="text-right">{{ $detail->quantity }}</td>
                            <td class="text-right"><strong>${{ number_format((float) $detail->total, 2) }}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="totals">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span>${{ number_format((float) $order->total, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="totals-row grand">
                    <span>Total</span>
                    <span>${{ number_format((float) $order->total, 2) }}</span>
                </div>
            </div>

            {{-- Payment Info --}}
            @if ($order->payment)
                <div class="payment-box">
                    <h3>Payment Information</h3>
                    <p>
                        <strong>Method:</strong>
                        {{ ucwords(str_replace('_', ' ', $order->payment->payment_method)) }}<br>
                        <strong>Status:</strong> {{ ucfirst($order->payment->status) }}<br>
                        @if ($order->payment->transaction_number)
                            <strong>Transaction #:</strong> {{ $order->payment->transaction_number }}<br>
                        @endif
                        @if ($order->payment->paid_at)
                            <strong>Paid At:</strong>
                            {{ \Carbon\Carbon::parse($order->payment->paid_at)->format('M d, Y h:i A') }}
                        @endif
                    </p>
                </div>
            @endif

            @if ($order->notes)
                <div class="payment-box" style="margin-top:16px;">
                    <h3>Order Notes</h3>
                    <p>{{ $order->notes }}</p>
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>
                This invoice was generated automatically by <strong>Gaza Store</strong>.<br>
                If you have any questions, please contact our support team.<br>
                <strong>© {{ date('Y') }} Gaza Store. All rights reserved.</strong>
            </p>
        </div>

    </div>
</body>

</html>
