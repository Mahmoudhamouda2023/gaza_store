@extends('frontend.layouts.app')

@section('title', 'Home | Gaza Store')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-black h-[520px] overflow-hidden">
        <img src="{{ asset('frontend/assets/images/hero.jpg') }}" alt="Gaza Store"
            class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
            <h1 class="text-white text-5xl font-extrabold text-center">
                Welcome to Gaza Store
            </h1>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-white dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                Shop by Categories
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    <a href="{{ route('frontend.categories.show', $category->id) }}"
                        class="relative overflow-hidden group rounded-lg shadow hover:shadow-xl transition bg-white dark:bg-gray-900">

                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                            class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">

                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <h3 class="text-white text-2xl font-bold">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-full bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 p-5 text-center rounded-lg">
                        No categories found.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Latest Products Section -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                Latest Products
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($latestProducts as $product)
                    <div
                        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden shadow hover:shadow-xl transition group">

                        <a href="{{ route('frontend.products.show', $product->id) }}"
                            class="block bg-gray-100 dark:bg-gray-800 overflow-hidden">

                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-64 object-cover group-hover:scale-105 transition duration-500">
                        </a>

                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1 text-gray-900 dark:text-white">
                                <a href="{{ route('frontend.products.show', $product->id) }}"
                                    class="hover:text-gray-600 dark:hover:text-gray-300 transition">
                                    {{ $product->name ?: 'Unnamed Product' }}
                                </a>
                            </h3>

                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                                {{ $product->category->name ?? 'No Category' }}
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                    ${{ $product->formatted_price }}
                                </span>

                                @if ($product->is_available)
                                    <span class="text-green-600 dark:text-green-400 text-sm font-semibold">
                                        Available
                                    </span>
                                @else
                                    <span class="text-red-600 dark:text-red-400 text-sm font-semibold">
                                        Out of stock
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 p-5 text-center rounded-lg">
                        No products found.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
