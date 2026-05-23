@extends('frontend.layouts.app')

@section('title', 'Cart | Gaza Store')

@section('content')

    <section class="py-12 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                    Shopping Cart
                </h1>

                <p class="text-gray-500 dark:text-gray-400 italic mt-2">
                    Review your selected products
                </p>
            </div>

            <div id="cartMessage" class="hidden mb-6 px-5 py-4 rounded-xl"></div>

            @if ($cartItems->count())
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Cart Items --}}
                    <div class="lg:col-span-2 space-y-5">
                        @foreach ($cartItems as $item)
                            <div id="cart-item-{{ $item->id }}"
                                class="border border-gray-200 dark:border-gray-700
                                       bg-white dark:bg-gray-800
                                       p-5 rounded-2xl shadow-sm
                                       flex flex-col md:flex-row gap-5
                                       transition-colors duration-300">

                                <div class="w-full md:w-36 h-36 bg-gray-100 dark:bg-gray-700 overflow-hidden rounded-xl">
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

                                    <p class="font-semibold mb-4 text-gray-900 dark:text-gray-100">
                                        Price: ${{ number_format((float) $item->price, 2) }}
                                    </p>

                                    <div class="flex flex-col sm:flex-row gap-3 sm:items-center">

                                        <div
                                            class="flex items-center border border-gray-300 dark:border-gray-700 w-fit rounded-xl overflow-hidden bg-white dark:bg-gray-900">
                                            <button type="button" id="minus-{{ $item->id }}"
                                                onclick="updateCartQuantity({{ $item->id }}, -1, {{ $item->product->quantity }}, {{ (float) $item->price }})"
                                                class="w-10 h-10 flex items-center justify-center text-xl
                                                       text-gray-900 dark:text-white
                                                       hover:bg-gray-100 dark:hover:bg-gray-700
                                                       transition disabled:opacity-40"
                                                @if ($item->quantity <= 1) disabled @endif>
                                                -
                                            </button>

                                            <span id="qty-{{ $item->id }}"
                                                class="w-12 h-10 flex items-center justify-center font-bold
                                                       border-x border-gray-300 dark:border-gray-700
                                                       text-gray-900 dark:text-white">
                                                {{ $item->quantity }}
                                            </span>

                                            <button type="button" id="plus-{{ $item->id }}"
                                                onclick="updateCartQuantity({{ $item->id }}, 1, {{ $item->product->quantity }}, {{ (float) $item->price }})"
                                                class="w-10 h-10 flex items-center justify-center text-xl
                                                       text-gray-900 dark:text-white
                                                       hover:bg-gray-100 dark:hover:bg-gray-700
                                                       transition disabled:opacity-40"
                                                @if ($item->quantity >= $item->product->quantity) disabled @endif>
                                                +
                                            </button>
                                        </div>

                                        <form action="{{ route('frontend.cart.destroy', $item->id) }}" method="POST"
                                            class="remove-cart-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Remove item"
                                                class="w-10 h-10 border border-red-600 text-red-600
                                                       rounded-xl flex items-center justify-center
                                                       hover:bg-red-600 hover:text-white transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4a1 1 0 011 1v2H9V5a1 1 0 011-1z" />
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </div>

                                <div class="md:text-right">
                                    <p class="text-gray-500 dark:text-gray-400 mb-1">
                                        Total
                                    </p>

                                    <strong id="item-total-{{ $item->id }}"
                                        class="text-xl text-gray-900 dark:text-white">
                                        ${{ number_format((float) $item->total, 2) }}
                                    </strong>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Order Summary --}}
                    <div
                        class="border border-gray-200 dark:border-gray-700
                                bg-white dark:bg-gray-800
                                p-6 h-fit rounded-2xl shadow-sm
                                transition-colors duration-300">
                        <h2 class="text-2xl font-extrabold mb-5 text-gray-900 dark:text-white">
                            Order Summary
                        </h2>

                        <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                            <span class="text-gray-500 dark:text-gray-400">
                                Subtotal
                            </span>

                            <strong id="cart-subtotal" class="text-gray-900 dark:text-white">
                                ${{ number_format((float) $cartTotal, 2) }}
                            </strong>
                        </div>

                        <div class="flex justify-between text-xl font-bold mb-6 text-gray-900 dark:text-white">
                            <span>Total</span>

                            <strong id="cart-total">
                                ${{ number_format((float) $cartTotal, 2) }}
                            </strong>
                        </div>

                        <a href="{{ route('frontend.checkout.index') }}"
                            class="block w-full text-center
                                   bg-black dark:bg-gray-700
                                   text-white py-3 font-semibold rounded-xl
                                   hover:bg-gray-800 dark:hover:bg-gray-600
                                   transition">
                            Proceed To Checkout
                        </a>
                    </div>

                </div>
            @else
                <div
                    class="bg-white dark:bg-gray-800
                            border border-gray-200 dark:border-gray-700
                            p-10 text-center rounded-2xl shadow-sm">
                    <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                        Your cart is empty
                    </h2>

                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Start adding products to your cart.
                    </p>

                    <a href="{{ route('frontend.products.index') }}"
                        class="inline-block bg-black dark:bg-gray-700 text-white
                               px-8 py-3 font-semibold rounded-xl
                               hover:bg-gray-800 dark:hover:bg-gray-600
                               transition">
                        Browse Products
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- AJAX: Update Quantity --}}
    <script>
        async function updateCartQuantity(cartId, change, maxQuantity, price) {
            const qtyElement = document.getElementById('qty-' + cartId);
            const minusButton = document.getElementById('minus-' + cartId);
            const plusButton = document.getElementById('plus-' + cartId);
            const itemTotalElement = document.getElementById('item-total-' + cartId);

            let currentQuantity = parseInt(qtyElement.innerText);
            let newQuantity = currentQuantity + change;

            if (newQuantity < 1 || newQuantity > maxQuantity) return;

            minusButton.disabled = true;
            plusButton.disabled = true;

            try {
                const response = await fetch(`/cart/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    }),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    showCartMessage(data.message || 'Unable to update cart.', 'error');
                    return;
                }

                qtyElement.innerText = newQuantity;

                itemTotalElement.innerText = '$' + parseFloat(data.item_total).toFixed(2);

                document.getElementById('cart-subtotal').innerText = '$' + parseFloat(data.cart_total).toFixed(2);
                document.getElementById('cart-total').innerText = '$' + parseFloat(data.cart_total).toFixed(2);

                const cartBadge = document.getElementById('cart-count-badge');
                if (cartBadge) {
                    cartBadge.innerText = data.cart_count;
                    cartBadge.classList.toggle('hidden', data.cart_count <= 0);
                }

            } catch (error) {
                showCartMessage('Something went wrong while updating cart.', 'error');
            } finally {
                minusButton.disabled = newQuantity <= 1;
                plusButton.disabled = newQuantity >= maxQuantity;
            }
        }

        function showCartMessage(message, type = 'error') {
            const messageBox = document.getElementById('cartMessage');

            messageBox.className = type === 'error' ?
                'mb-6 px-5 py-4 rounded-xl bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300' :
                'mb-6 px-5 py-4 rounded-xl bg-green-100 dark:bg-green-950 text-green-700 dark:text-green-300';

            messageBox.innerText = message;
            messageBox.classList.remove('hidden');

            setTimeout(() => {
                messageBox.classList.add('hidden');
            }, 2500);
        }
    </script>

    {{-- AJAX: Remove Item With SweetAlert --}}
    <script>
        document.querySelectorAll('.remove-cart-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Remove item?',
                    text: 'Are you sure you want to remove this item from cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#111827',
                }).then(async (result) => {
                    if (!result.isConfirmed) return;

                    const action = form.action;
                    const cartId = action.split('/').pop();
                    const csrfToken = form.querySelector('input[name="_token"]').value;

                    try {
                        const response = await fetch(action, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            showCartMessage(data.message || 'Unable to remove item.', 'error');
                            return;
                        }

                        const cartItem = document.getElementById('cart-item-' + cartId);
                        cartItem.style.transition = 'opacity 0.3s ease';
                        cartItem.style.opacity = '0';
                        setTimeout(() => cartItem.remove(), 300);

                        document.getElementById('cart-subtotal').innerText =
                            '$' + parseFloat(data.cart_total).toFixed(2);

                        document.getElementById('cart-total').innerText =
                            '$' + parseFloat(data.cart_total).toFixed(2);

                        const cartBadge = document.getElementById('cart-count-badge');
                        if (cartBadge) {
                            cartBadge.innerText = data.cart_count;
                            cartBadge.classList.toggle('hidden', data.cart_count <= 0);
                        }

                        if (data.cart_count === 0) {
                            setTimeout(() => location.reload(), 400);
                        }

                    } catch (error) {
                        showCartMessage('Something went wrong while removing item.', 'error');
                    }
                });
            });
        });
    </script>

@endsection
