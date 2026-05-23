@component('mail::message')
    # الفاتورة الخاصة بك

    مرحبًا {{ $order->user->name }},

    تم تأكيد الدفع للطلب #{{ $order->id }} بمجموع ${{ number_format($order->total, 2) }}.

    @component('mail::table')
        | المنتج | السعر | الكمية | الإجمالي |
        |-------------|---------|-------|---------|
        @foreach ($order->items as $item)
            | {{ $item->product->name }} | ${{ number_format($item->price, 2) }} | {{ $item->quantity }} |
            ${{ number_format($item->price * $item->quantity, 2) }} |
        @endforeach
    @endcomponent

    **إجمالي الفاتورة:** ${{ number_format($order->total, 2) }}

    شكراً لتعاملك معنا!
@endcomponent
