@extends('frontend.layouts.app')

@section('title', 'All Products | Gaza Store')

@section('content')

    <section class="bg-gray-50 dark:bg-gray-900 py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="text-4xl font-extrabold mb-2 text-gray-900 dark:text-white">
                    All Products
                </h1>

                <p class="text-gray-500 dark:text-gray-400">
                    Browse all available products in Gaza Store
                </p>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('frontend.products.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-3 w-full md:w-auto mb-8">

                <div class="relative md:col-span-2">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                        class="w-full pl-11 pr-4 py-3
                                  bg-white dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  border border-gray-200 dark:border-gray-700
                                  rounded-2xl shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500">
                </div>

                <select name="category"
                    class="px-4 py-3
                               bg-white dark:bg-gray-800
                               text-gray-900 dark:text-white
                               border border-gray-200 dark:border-gray-700
                               rounded-2xl shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500">
                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort"
                    class="px-4 py-3
                               bg-white dark:bg-gray-800
                               text-gray-900 dark:text-white
                               border border-gray-200 dark:border-gray-700
                               rounded-2xl shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-gray-500">
                    <option value="">Newest</option>
                    <option value="price_low" @selected(request('sort') == 'price_low')>
                        Price: Low to High
                    </option>
                    <option value="price_high" @selected(request('sort') == 'price_high')>
                        Price: High to Low
                    </option>
                </select>

                <button type="submit"
                    class="md:col-span-4
                               bg-black dark:bg-gray-700
                               text-white py-3 rounded-2xl font-bold
                               hover:bg-gray-800 dark:hover:bg-gray-600
                               transition">
                    Apply Filters
                </button>

                @if (request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('frontend.products.index') }}"
                        class="md:col-span-4 text-center
                              bg-gray-100 dark:bg-gray-800
                              text-gray-700 dark:text-gray-200
                              py-3 rounded-2xl font-bold
                              hover:bg-gray-200 dark:hover:bg-gray-700
                              transition">
                        Clear Filters
                    </a>
                @endif
            </form>

            {{-- Products Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">
                @forelse($products as $product)
                    <div
                        class="bg-white dark:bg-gray-800
                                rounded-3xl overflow-hidden shadow-sm
                                border border-gray-100 dark:border-gray-700
                                hover:shadow-xl hover:-translate-y-1
                                transition duration-300 group">

                        {{-- Product Image --}}
                        <a href="{{ route('frontend.products.show', $product->id) }}"
                            class="relative block bg-gray-100 dark:bg-gray-700 overflow-hidden">

                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-[250px] object-cover group-hover:scale-105 transition duration-500">

                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/90 dark:bg-gray-900/90
                                             backdrop-blur px-3 py-1 rounded-full
                                             text-xs font-bold
                                             text-gray-800 dark:text-gray-100
                                             shadow">
                                    {{ $product->category->name ?? 'No Category' }}
                                </span>
                            </div>
                        </a>

                        <div class="p-5">
                            <h3 class="font-extrabold text-lg text-gray-900 dark:text-white line-clamp-1 mb-2">
                                <a href="{{ route('frontend.products.show', $product->id) }}"
                                    class="hover:text-gray-600 dark:hover:text-gray-300 transition">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        Price
                                    </p>

                                    <strong class="text-2xl text-gray-950 dark:text-white">
                                        ${{ $product->formatted_price }}
                                    </strong>
                                </div>
                            </div>

                            @if ($product->is_available)
                                <a href="{{ route('frontend.products.show', $product->id) }}"
                                    class="flex items-center justify-center gap-2 w-full
                                          bg-black dark:bg-gray-700
                                          text-white py-3 rounded-2xl font-bold
                                          hover:bg-gray-800 dark:hover:bg-gray-600
                                          transition">
                                    <i class="fas fa-eye text-sm"></i>
                                    View Product
                                </a>
                            @else
                                <span
                                    class="inline-block text-center
                                             bg-red-100 dark:bg-red-950
                                             text-red-700 dark:text-red-300
                                             py-3 rounded-2xl w-full font-bold">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>

                @empty
                    <div class="lg:col-span-4">
                        <div
                            class="bg-white dark:bg-gray-800
                                    border border-gray-100 dark:border-gray-700
                                    rounded-3xl p-12 text-center shadow-sm">

                            <div
                                class="w-20 h-20
                                        bg-gray-100 dark:bg-gray-700
                                        rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-box-open text-3xl text-gray-400 dark:text-gray-300"></i>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                No products found
                            </h3>

                            <p class="text-gray-500 dark:text-gray-400 mt-2">
                                Products will appear here once added from admin panel.
                            </p>
                        </div>
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
