<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoiceEmail;
use Barryvdh\DomPDF\Facade\Pdf;

class WebhookController extends Controller
{
    public function stripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $order = Order::where('stripe_session_id', $session->id)->first();
            if ($order && $order->status !== 'paid') {
                $order->update(['status' => 'paid']);
                $pdf = Pdf::loadView('pdf.invoice', compact('order'));
                Mail::to($order->user->email)->send(new SendInvoiceEmail($order, $pdf));
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function fawateri(Request $request)
    {
        $data = $request->all();
        $order = Order::where('fawateri_payment_id', $data['payment_id'])->first();

        if ($order && $data['status'] === 'paid' && $order->status !== 'paid') {
            $order->update(['status' => 'paid']);
            $pdf = Pdf::loadView('pdf.invoice', compact('order'));
            Mail::to($order->user->email)->send(new SendInvoiceEmail($order, $pdf));
        }

        return response()->json(['status' => 'success']);
    }
}
