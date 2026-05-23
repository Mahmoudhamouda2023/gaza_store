@extends('frontend.layouts.app')

@section('title', ($product->name ?: 'Product Details') . ' | Gaza Store')

@section('content')

    <section class="py-12 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Breadcrumb --}}
            <div class="mb-8 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('frontend.home') }}" class="hover:text-black dark:hover:text-white transition">
                    Home
                </a>

                <span class="mx-2">/</span>

                <a href="{{ route('frontend.products.index') }}" class="hover:text-black dark:hover:text-white transition">
                    Products
                </a>

                <span class="mx-2">/</span>

                <span class="text-black dark:text-white">
                    {{ $product->name ?: 'Product Details' }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- Product Image --}}
                <div class="lg:col-span-1">
                    <div
                        class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 mb-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-[500px] object-cover">
                    </div>

                    {{-- Gallery --}}
                    @if ($product->gallery && $product->gallery->count())
                        <div class="grid grid-cols-4 gap-4 mt-2">
                            @foreach ($product->gallery as $image)
                                <div
                                    class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800">
                                    <img src="{{ asset('images/' . $image->path) }}" alt="Gallery Image"
                                        class="w-full h-24 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="lg:col-span-1">
                    <p class="text-gray-500 dark:text-gray-400 mb-1">
                        {{ $product->category->name ?? 'No Category' }}
                    </p>

                    <h1 class="text-4xl font-extrabold mb-4 text-gray-900 dark:text-white">
                        {{ $product->name }}
                    </h1>

                    <div class="text-3xl font-bold mb-4 text-gray-950 dark:text-white">
                        ${{ $product->formatted_price }}
                    </div>

                    {{-- Stock --}}
                    @if ($product->is_available)
                        <span
                            class="inline-block bg-green-100 dark:bg-green-950 text-green-700 dark:text-green-300 px-4 py-2 font-semibold rounded mb-4">
                            متوفر
                        </span>
                    @else
                        <span
                            class="inline-block bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300 px-4 py-2 font-semibold rounded mb-4">
                            غير متوفر
                        </span>
                    @endif

                    {{-- Description --}}
                    <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4 mb-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">
                            الوصف
                        </h3>

                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $product->description ?: 'No description available.' }}
                        </p>
                    </div>

                    @auth
                        @if ($product->is_available)
                            <div class="flex items-center gap-4 mb-4">

                                {{-- Quantity controls --}}
                                <div
                                    class="flex items-center border border-gray-300 dark:border-gray-700 w-fit rounded-xl overflow-hidden bg-white dark:bg-gray-800">
                                    <button type="button" id="minusBtn" onclick="updateProductCart(-1)"
                                        class="w-10 h-10 flex items-center justify-center text-xl text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition disabled:opacity-40"
                                        disabled>
                                        -
                                    </button>

                                    <span id="qtyDisplay"
                                        class="w-12 h-10 flex items-center justify-center font-bold border-x border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                                        0
                                    </span>

                                    <button type="button" id="plusBtn" onclick="updateProductCart(1)"
                                        class="w-10 h-10 flex items-center justify-center text-xl text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition disabled:opacity-40"
                                        @if (($product->quantity ?? 0) <= 0) disabled @endif>
                                        +
                                    </button>
                                </div>

                                {{-- Go To Cart --}}
                                <a href="{{ route('frontend.cart.index') }}"
                                    class="border border-black dark:border-gray-600 text-gray-900 dark:text-white px-6 py-3 font-bold rounded-xl hover:bg-black hover:text-white dark:hover:bg-gray-700 transition">
                                    انتقل إلى السلة
                                </a>
                            </div>

                            {{-- Feedback message --}}
                            <div id="productCartMsg" class="hidden text-sm font-semibold mt-1"></div>
                        @endif
                    @endauth
                </div>

                {{-- Order Summary --}}
                @auth
                    @if ($product->is_available)
                        <div class="lg:col-span-1">
                            <div
                                class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 h-fit sticky top-28 rounded-2xl shadow-sm">
                                <h2 class="text-2xl font-extrabold mb-5 text-gray-900 dark:text-white">
                                    Order Summary
                                </h2>

                                <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">
                                    <span class="text-gray-500 dark:text-gray-400">
                                        Unit Price
                                    </span>

                                    <strong class="text-gray-900 dark:text-white">
                                        ${{ $product->formatted_price }}
                                    </strong>
                                </div>

                                <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">
                                    <span class="text-gray-500 dark:text-gray-400">
                                        Quantity
                                    </span>

                                    <strong id="summaryQty" class="text-gray-900 dark:text-white">
                                        0
                                    </strong>
                                </div>

                                <div class="flex justify-between text-xl font-bold mb-6 text-gray-900 dark:text-white">
                                    <span>Total</span>
                                    <strong id="summaryTotal">$0.00</strong>
                                </div>

                                <a href="{{ route('frontend.cart.index') }}"
                                    class="block w-full text-center bg-black dark:bg-gray-700 text-white py-3 font-semibold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-600 transition">
                                    Proceed To Cart
                                </a>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>
        </div>
    </section>

    <script>
        const productId = {{ $product->id }};
        const maxStock = {{ $product->quantity ?? 9999 }};
        const unitPrice = {{ (float) $product->price }};
        const csrfToken = '{{ csrf_token() }}';
        const addUrl = '{{ route('frontend.cart.add') }}';

        let quantity = 0;

        async function updateProductCart(change) {
            const minusBtn = document.getElementById('minusBtn');
            const plusBtn = document.getElementById('plusBtn');
            const qtyDisplay = document.getElementById('qtyDisplay');

            let newQty = quantity + change;
            if (newQty < 0 || newQty > maxStock) return;

            minusBtn.disabled = true;
            plusBtn.disabled = true;

            try {
                const response = await fetch(addUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: newQty
                    }),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    showMsg(data.message || 'حدث خطأ أثناء التحديث', 'text-red-600 dark:text-red-400');
                    return;
                }

                quantity = newQty;

                qtyDisplay.innerText = quantity;

                const summaryQty = document.getElementById('summaryQty');
                const summaryTotal = document.getElementById('summaryTotal');

                if (summaryQty) summaryQty.innerText = quantity;
                if (summaryTotal) summaryTotal.innerText = '$' + (unitPrice * quantity).toFixed(2);

                const badge = document.getElementById('cart-count-badge');
                if (badge) {
                    badge.innerText = data.cart_count;
                    badge.classList.toggle('hidden', data.cart_count <= 0);
                }

                showMsg('✔ تم تحديث السلة', 'text-green-600 dark:text-green-400');

            } catch (err) {
                showMsg('تعذّر الاتصال بالخادم', 'text-red-600 dark:text-red-400');
            } finally {
                minusBtn.disabled = quantity <= 0;
                plusBtn.disabled = quantity >= maxStock;
            }
        }

        function showMsg(text, colorClass) {
            const msgBox = document.getElementById('productCartMsg');
            msgBox.textContent = text;
            msgBox.className = 'text-sm font-semibold mt-1 ' + colorClass;
            msgBox.classList.remove('hidden');
            setTimeout(() => msgBox.classList.add('hidden'), 2500);
        }
    </script>

@endsection
