@php
    $cartCount = 0;

    if (auth()->check()) {
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
    }
@endphp

<header
    class="bg-white dark:bg-gray-900 border-b border-dashed border-gray-300 dark:border-gray-700 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <nav class="flex items-center justify-between py-6">

            {{-- Logo --}}
            <a href="{{ route('frontend.home') }}" class="flex items-center gap-3">
                <div
                    class="w-12 h-12 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold text-xl">
                    G
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold tracking-wide text-gray-900 dark:text-white">
                        GAZA STORE
                    </h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400 tracking-[0.25em]">
                        ONLINE SHOPPING
                    </p>
                </div>
            </a>

            {{-- Right Menu --}}
            <ul class="hidden md:flex items-center gap-8 font-semibold text-gray-900 dark:text-gray-100">

                {{-- Home --}}
                <li>
                    <a href="{{ route('frontend.home') }}"
                        class="inline-flex items-center justify-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Home">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955a1.125 1.125 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-6.75h4.5V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                        </svg>
                    </a>
                </li>

                {{-- Products --}}
                <li>
                    <a href="{{ route('frontend.products.index') }}"
                        class="inline-flex items-center justify-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Products">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12A1.125 1.125 0 0119.75 21H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 6.75h12.974a1.125 1.125 0 011.119 1.007z" />
                        </svg>
                    </a>
                </li>

                {{-- Cart --}}
                <li>
                    <a href="{{ route('frontend.cart.index') }}"
                        class="relative inline-flex items-center justify-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>

                        <span id="cart-count-badge"
                            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold min-w-[22px] h-[22px] px-1 flex items-center justify-center rounded-full {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>
                </li>

                {{-- Theme Toggle --}}
                <li>
                    <button type="button" onclick="toggleTheme()"
                        class="w-10 h-10 rounded-full flex items-center justify-center
                                   bg-gray-100 text-gray-900 hover:bg-gray-200
                                   dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700
                                   transition"
                        title="Toggle Theme">
                        <span class="dark:hidden">🌙</span>
                        <span class="hidden dark:inline">☀️</span>
                    </button>
                </li>

                @auth
                    @if (auth()->user()->role && in_array(auth()->user()->role->name, ['admin', 'manager']))
                        <li>
                            <a href="{{ url(app()->getLocale() . '/admin') }}"
                                class="bg-black dark:bg-white text-white dark:text-black px-4 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition">
                                Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- User Menu --}}
                    <li class="relative group">
                        <button type="button"
                            class="flex items-center gap-2 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">

                            <div
                                class="w-10 h-10 rounded-full bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold uppercase overflow-hidden">
                                @if (auth()->user()->image)
                                    <img src="{{ asset('storage/' . auth()->user()->image) }}"
                                        alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ mb_substr(auth()->user()->name, 0, 1, 'UTF-8') }}
                                @endif
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            class="absolute right-0 top-full w-56 pt-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition z-50">
                            <div
                                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-xl rounded-lg overflow-hidden">

                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>

                                <a href="{{ route('frontend.profile.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <span>👤</span>
                                    <span>Profile</span>
                                </a>

                                <a href="{{ route('frontend.orders.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <span>📦</span>
                                    <span>My Orders</span>
                                </a>

                                <a href="#"
                                    class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <span>⚙️</span>
                                    <span>Settings</span>
                                </a>

                                <form action="{{ route('logout') }}" method="POST"
                                    class="border-t border-gray-100 dark:border-gray-700">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-left hover:bg-gray-100 dark:hover:bg-gray-800">
                                        <span>↪</span>
                                        <span>Logout</span>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="hover:text-gray-500 dark:hover:text-gray-300 transition">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>

        </nav>
    </div>
</header>
