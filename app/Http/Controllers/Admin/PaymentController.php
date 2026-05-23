<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'order.user'])
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }
    public function show(Payment $payment)
    {
        $payment->load(['user', 'order.user', 'order.order_details.product']);

        return view('admin.payments.show', compact('payment'));
    }
}
