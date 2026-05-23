<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderInvoiceMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['product.image', 'product.category'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('frontend.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $cartTotal = $cartItems->sum('total');

        return view('frontend.checkout.index', compact('cartItems', 'cartTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone'              => ['required', 'string', 'max:30'],
            'email'              => ['required', 'email', 'max:255'],   // ✅ جديد
            'address'            => ['required', 'string', 'max:1000'],
            'notes'              => ['nullable', 'string', 'max:1000'],
            'payment_method'     => ['required', 'in:cash_on_delivery,bank_transfer,stripe,myfatoorah'],
            'transaction_number' => ['required_if:payment_method,bank_transfer', 'nullable', 'string', 'max:255'],
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('frontend.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $cartTotal = $cartItems->sum('total');

            $order = Order::create([
                'user_id' => Auth::id(),
                'total'   => $cartTotal,
                'status'  => 'pending',
                'phone'   => $request->phone,
                'email'   => $request->email,           // ✅ جديد
                'address' => $request->address,
                'notes'   => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->quantity) {
                    DB::rollBack();

                    return redirect()
                        ->route('frontend.cart.index')
                        ->with('error', 'Some products do not have enough quantity.');
                }

                OrderDetail::create([
                    'user_id'    => Auth::id(),
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                    'total'      => $item->total,
                ]);

                $item->product->update([
                    'quantity' => $item->product->quantity - $item->quantity,
                ]);
            }

            $payment = Payment::create([
                'user_id'            => Auth::id(),
                'order_id'           => $order->id,
                'total'              => $cartTotal,
                'payment_method'     => $request->payment_method,
                'transaction_number' => $request->transaction_number,
                'status'             => 'pending',
            ]);

            // ===== Stripe =====
            if ($request->payment_method === 'stripe') {
                Stripe::setApiKey(config('services.stripe.secret'));

                $lineItems = $cartItems->map(function ($item) {
                    return [
                        'price_data' => [
                            'currency'     => 'usd',
                            'product_data' => ['name' => $item->product->name ?? 'Product'],
                            'unit_amount'  => (int) round(((float) $item->price) * 100),
                        ],
                        'quantity' => (int) $item->quantity,
                    ];
                })->values()->toArray();

                if (empty($lineItems)) {
                    throw new \Exception('Cart items are empty for Stripe.');
                }

                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'mode'                 => 'payment',
                    'line_items'           => $lineItems,
                    'client_reference_id'  => (string) $order->id,
                    'metadata'             => [
                        'order_id'   => (string) $order->id,
                        'payment_id' => (string) $payment->id,
                        'user_id'    => (string) Auth::id(),
                    ],
                    'success_url' => route('frontend.checkout.success', $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url'  => route('frontend.checkout.cancel', $order->id),
                ]);

                $payment->update(['stripe_session_id' => $session->id]);

                DB::commit();

                return redirect()->away($session->url);
            }

            // ===== MyFatoorah =====
            if ($request->payment_method === 'myfatoorah') {
                $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.myfatoorah.token'),
                    'Accept'        => 'application/json',
                ])->post(config('services.myfatoorah.base_url') . '/v2/SendPayment', [
                    'NotificationOption' => 'Lnk',
                    'InvoiceValue'       => (float) $cartTotal,
                    'CustomerName'       => Auth::user()->name ?? 'Customer',
                    'CustomerEmail'      => $request->email,
                    'CustomerMobile'     => $cleanPhone,
                    'CallBackUrl'        => route('frontend.checkout.success', $order->id),
                    'ErrorUrl'           => route('frontend.checkout.cancel', $order->id),
                    'Language'           => 'en',
                    'DisplayCurrencyIso' => 'USD',
                ]);

                $result = $response->json();

                if (!$response->successful() || empty($result['IsSuccess']) || empty($result['Data']['InvoiceURL'])) {
                    $errorMessage = $result['Message']
                        ?? ($result['ValidationErrors'][0]['Error'] ?? null)
                        ?? 'Unable to create MyFatoorah payment link.';

                    throw new \Exception($errorMessage);
                }

                $payment->update([
                    'transaction_number' => $result['Data']['InvoiceId'] ?? null,
                    'status'             => 'pending',
                ]);

                DB::commit();

                return redirect()->away($result['Data']['InvoiceURL']);
            }

            // ===== Cash / Bank Transfer =====
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // ✅ إرسال الفاتورة على الإيميل
            $this->sendInvoice($order, $request->email);

            return redirect()
                ->route('frontend.orders.show', $order->id)
                ->with('success', 'Order placed successfully. Your order is pending review.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('frontend.cart.index')
                ->with('error', $e->getMessage());
        }
    }

    public function success(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        if ($request->query('session_id')) {
            return $this->stripeSuccess($request, $order);
        }

        if ($request->query('paymentId')) {
            return $this->myFatoorahSuccess($request, $order);
        }

        return redirect()
            ->route('frontend.orders.show', $order->id)
            ->with('error', 'Payment reference was not found.');
    }

    private function stripeSuccess(Request $request, Order $order)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::retrieve($request->query('session_id'));

            if ($session->payment_status === 'paid') {
                $order->update(['status' => 'processing']);

                $order->payment()->update([
                    'status'                   => 'paid',
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'paid_at'                  => now(),
                ]);

                Cart::where('user_id', Auth::id())->delete();

                // ✅ إرسال الفاتورة — Stripe
                $email = $order->email ?? Auth::user()->email;
                $this->sendInvoice($order, $email);

                return redirect()
                    ->route('frontend.orders.show', $order->id)
                    ->with('success', 'Payment completed successfully. Your order is now being processed.');
            }

            return redirect()
                ->route('frontend.orders.show', $order->id)
                ->with('error', 'Payment was not completed.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('frontend.orders.show', $order->id)
                ->with('error', 'Unable to verify Stripe payment.');
        }
    }

    private function myFatoorahSuccess(Request $request, Order $order)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.myfatoorah.token'),
                'Accept'        => 'application/json',
            ])->post(config('services.myfatoorah.base_url') . '/v2/GetPaymentStatus', [
                'Key'     => $request->query('paymentId'),
                'KeyType' => 'PaymentId',
            ]);

            $result = $response->json();

            if (!$response->successful() || empty($result['IsSuccess'])) {
                return redirect()
                    ->route('frontend.orders.show', $order->id)
                    ->with('error', 'Unable to verify MyFatoorah payment.');
            }

            $invoiceStatus = $result['Data']['InvoiceStatus'] ?? null;

            if ($invoiceStatus === 'Paid') {
                $order->update(['status' => 'processing']);

                $order->payment()->update([
                    'status'             => 'paid',
                    'transaction_number' => $result['Data']['InvoiceId'] ?? $request->query('paymentId'),
                    'paid_at'            => now(),
                ]);

                Cart::where('user_id', Auth::id())->delete();

                // ✅ إرسال الفاتورة — MyFatoorah
                $email = $order->email ?? Auth::user()->email;
                $this->sendInvoice($order, $email);

                return redirect()
                    ->route('frontend.orders.show', $order->id)
                    ->with('success', 'Payment completed successfully. Your order is now being processed.');
            }

            return redirect()
                ->route('frontend.orders.show', $order->id)
                ->with('error', 'Payment was not completed.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('frontend.orders.show', $order->id)
                ->with('error', 'Unable to verify MyFatoorah payment.');
        }
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        $order->payment()->update(['status' => 'cancelled']);

        return redirect()
            ->route('frontend.orders.show', $order->id)
            ->with('error', 'Payment was cancelled.');
    }

    // ===== Helper: إرسال الفاتورة =====
    private function sendInvoice(Order $order, string $email): void
    {
        try {
            Mail::to($email)->send(new OrderInvoiceMail($order));
        } catch (\Throwable $e) {
            // لا توقف العملية لو فشل الإيميل
            \Log::error('Invoice mail failed for order #' . $order->id . ': ' . $e->getMessage());
        }
    }
}
