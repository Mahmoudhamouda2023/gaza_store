@extends('frontend.layouts.app')

@section('title', ($category->name ?: 'Category') . ' | Gaza Store')

@section('content')

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Breadcrumb --}}
            <div class="mb-8 text-sm text-gray-500">
                <a href="{{ route('frontend.home') }}" class="hover:text-black">Home</a>
                <span class="mx-2">/</span>
                <span class="text-black">{{ $category->name ?: 'Category' }}</span>
            </div>

            {{-- Category Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-extrabold">
                    {{ $category->name ?: 'Category' }}
                </h1>

                <p class="text-gray-500 italic mt-2">
                    {{ $category->description ?: 'Browse products in this category' }}
                </p>
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                @forelse($products as $product)
                    <div
                        class="border border-gray-200 bg-white group hover:shadow-xl transition duration-300 flex flex-col">

                        <a href="{{ route('frontend.products.show', $product->id) }}"
                            class="block overflow-hidden bg-gray-100">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name ?: 'Product Image' }}"
                                class="w-full h-[260px] object-cover group-hover:scale-105 transition duration-500">
                        </a>

                        <div class="p-5 flex flex-col flex-1">
                            <h5 class="font-bold text-lg mb-1 line-clamp-1">
                                <a href="{{ route('frontend.products.show', $product->id) }}"
                                    class="hover:text-gray-500 transition">
                                    {{ $product->name ?: 'Unnamed Product' }}
                                </a>
                            </h5>

                            <p class="text-gray-500 text-sm mb-4 line-clamp-1">
                                {{ $product->category->name ?? 'No Category' }}
                            </p>

                            <div class="flex items-center justify-between mb-5 mt-auto">
                                <strong class="text-lg">
                                    ${{ $product->formatted_price }}
                                </strong>

                                @if ($product->is_available)
                                    <span class="text-green-600 text-sm font-semibold">
                                        Available
                                    </span>
                                @else
                                    <span class="text-red-600 text-sm font-semibold">
                                        Out of stock
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('frontend.products.show', $product->id) }}"
                                class="block w-full text-center bg-black text-white py-3 font-semibold hover:bg-gray-800 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-4 bg-blue-50 text-blue-700 p-5">
                        No products found in this category.
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>

        </div>
    </section>

@endsection
