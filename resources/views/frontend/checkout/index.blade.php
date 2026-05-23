@extends('frontend.layouts.app')

@section('title', 'Checkout | Gaza Store')

@section('content')

    {{-- Loading Overlay --}}
    <div id="loading-overlay"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; flex-direction:column;">
        <svg style="width:64px; height:64px; color:white; animation:spin 1s linear infinite;"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <p style="color:white; font-size:1.1rem; font-weight:600; margin-top:16px; letter-spacing:0.05em;">
            Processing your order...
        </p>
    </div>

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <section class="py-12 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                    Checkout
                </h1>

                <p class="text-gray-500 dark:text-gray-400 italic mt-2">
                    Confirm your order before placing it
                </p>
            </div>

            @if (session('error'))
                <div class="mb-6 bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300 px-5 py-4 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300 px-5 py-4 rounded-xl">
                    <strong>Please fix the following errors:</strong>
                    <ul class="list-disc ml-6 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('frontend.checkout.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-8">

                        {{-- Customer Information --}}
                        <div
                            class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm transition-colors duration-300">
                            <h2 class="text-2xl font-extrabold mb-5 text-gray-900 dark:text-white">
                                Customer Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="block font-semibold mb-2 text-gray-900 dark:text-white">
                                        Phone
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500"
                                        placeholder="Enter your phone number" required>
                                </div>

                                <div>
                                    <label class="block font-semibold mb-2 text-gray-900 dark:text-white">
                                        Email
                                        <span class="text-gray-400 dark:text-gray-500 font-normal text-sm">
                                            (Invoice will be sent here)
                                        </span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                        class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500"
                                        placeholder="Enter your email address" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-semibold mb-2 text-gray-900 dark:text-white">
                                        Payment Method
                                    </label>

                                    <select name="payment_method"
                                        class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500"
                                        required>
                                        <option value="">Select payment method</option>
                                        <option value="cash_on_delivery" @selected(old('payment_method') === 'cash_on_delivery')>
                                            Cash on Delivery
                                        </option>
                                        <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>
                                            Bank Transfer
                                        </option>
                                        <option value="stripe" @selected(old('payment_method') === 'stripe')>
                                            Pay Online By Card
                                        </option>
                                        <option value="myfatoorah" @selected(old('payment_method') === 'myfatoorah')>
                                            MyFatoorah (Online Payment)
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="mt-5">
                                <label class="block font-semibold mb-2 text-gray-900 dark:text-white">
                                    Address
                                </label>
                                <textarea name="address" rows="3"
                                    class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500"
                                    placeholder="Enter your delivery address" required>{{ old('address') }}</textarea>
                            </div>

                            <div class="mt-5">
                                <label class="block font-semibold mb-2 text-gray-900 dark:text-white">
                                    Transaction Number
                                </label>
                                <input type="text" name="transaction_number" value="{{ old('transaction_number') }}"
                                    class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500"
                                    placeholder="Required only for bank transfer">

                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    Leave this empty if you choose Cash on Delivery or Pay Online By Card.
                                </p>
                            </div>

                            <div class="mt-5">
                                <label class="block font-semibold mb-2 text-gray-900 dark:text-white">
                                    Notes
                                </label>
                                <textarea name="notes" rows="3"
                                    class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500"
                                    placeholder="Optional notes">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        {{-- Cart Items --}}
                        <div class="space-y-5">
                            @foreach ($cartItems as $item)
                                <div
                                    class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm flex flex-col md:flex-row gap-5 transition-colors duration-300">
                                    <div
                                        class="w-full md:w-32 h-32 bg-gray-100 dark:bg-gray-700 overflow-hidden rounded-xl">
                                        <img src="{{ $item->product->image_url }}"
                                            alt="{{ $item->product->name ?: 'Product Image' }}"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold mb-1 text-gray-900 dark:text-white">
                                            {{ $item->product->name ?: 'Unnamed Product' }}
                                        </h3>

                                        <p class="text-gray-500 dark:text-gray-400 mb-3">
                                            {{ $item->product->category->name ?? 'No Category' }}
                                        </p>

                                        <p class="text-gray-900 dark:text-gray-100">
                                            Price:
                                            <strong>${{ number_format((float) $item->price, 2) }}</strong>
                                        </p>

                                        <p class="text-gray-900 dark:text-gray-100">
                                            Quantity:
                                            <strong>{{ $item->quantity }}</strong>
                                        </p>
                                    </div>

                                    <div class="md:text-right">
                                        <p class="text-gray-500 dark:text-gray-400 mb-1">
                                            Total
                                        </p>

                                        <strong class="text-xl text-gray-900 dark:text-white">
                                            ${{ number_format((float) $item->total, 2) }}
                                        </strong>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    {{-- Summary --}}
                    <div
                        class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 h-fit rounded-2xl shadow-sm transition-colors duration-300">
                        <h2 class="text-2xl font-extrabold mb-5 text-gray-900 dark:text-white">
                            Checkout Summary
                        </h2>

                        <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Subtotal
                            </span>

                            <strong class="text-gray-900 dark:text-white">
                                ${{ number_format((float) $cartTotal, 2) }}
                            </strong>
                        </div>

                        <div class="flex justify-between text-xl font-bold mb-6 text-gray-900 dark:text-white">
                            <span>Total</span>
                            <strong>${{ number_format((float) $cartTotal, 2) }}</strong>
                        </div>

                        <button type="submit"
                            class="block w-full text-center bg-black dark:bg-gray-700 text-white py-3 font-semibold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-600 transition">
                            Place Order
                        </button>

                        <a href="{{ route('frontend.cart.index') }}"
                            class="block w-full text-center border border-black dark:border-gray-600 text-gray-900 dark:text-white mt-4 py-3 font-semibold rounded-xl hover:bg-black hover:text-white dark:hover:bg-gray-700 transition">
                            Back To Cart
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </section>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'flex';
        });
    </script>

@endsection
