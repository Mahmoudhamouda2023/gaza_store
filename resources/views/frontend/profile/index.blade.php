@extends('frontend.layouts.app')

@section('title', 'Profile | Gaza Store')

@section('content')

    <section class="bg-[#17182b] min-h-screen py-10 text-white">
        <div class="max-w-7xl mx-auto px-6">

            <h1 class="text-4xl font-light text-gray-400 mb-10">
                Profile Page
            </h1>

            @if (session('success'))
                <div class="mb-6 bg-green-600 text-white px-5 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-600 text-white px-5 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 items-start">

                {{-- Profile Image --}}
                <div class="lg:col-span-1 flex justify-center lg:justify-start">
                    <form id="profileImageForm" action="{{ route('frontend.profile.image.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input id="profileImageInput" type="file" name="image" accept="image/*" class="hidden"
                            onchange="document.getElementById('profileImageForm').submit();">

                        <label for="profileImageInput"
                            class="relative block w-60 h-60 rounded-full border border-dashed border-gray-400 p-2 cursor-pointer group">

                            <div
                                class="w-full h-full rounded-full bg-[#f4d89b] flex items-center justify-center overflow-hidden">
                                @if (!empty($user->image))
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-7xl font-extrabold text-[#8b5e1c]">
                                        {{ mb_substr($user->name, 0, 1, 'UTF-8') }}
                                    </span>
                                @endif
                            </div>

                            <div
                                class="absolute inset-2 rounded-full bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                Change Image
                            </div>
                        </label>
                    </form>
                </div>

                {{-- Profile Data --}}
                <div class="lg:col-span-3">

                    <form action="{{ route('frontend.profile.info.update') }}" method="POST" class="space-y-6 mb-10">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block mb-3 text-xl">Name</label>
                            <div class="w-full bg-[#123f70] rounded px-5 py-3 text-lg">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div>
                            <label class="block mb-3 text-xl">Email</label>
                            <div class="w-full bg-[#123f70] rounded px-5 py-3 text-lg">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div>
                            <label class="block mb-3 text-xl">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="Enter your phone number"
                                class="w-full bg-[#123f70] rounded px-5 py-3 text-lg text-white outline-none border border-transparent focus:border-blue-300 placeholder:text-gray-300">
                        </div>

                        <div>
                            <label class="block mb-3 text-xl">Joined At</label>
                            <div class="w-full bg-[#123f70] rounded px-5 py-3 text-lg">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-emerald-500 text-white px-6 py-3 rounded font-semibold hover:bg-emerald-600 transition">
                            Save Profile
                        </button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
                        <div>
                            <label class="block mb-3 text-xl">Orders</label>
                            <div class="w-full bg-[#123f70] rounded px-5 py-3 text-lg">
                                {{ $ordersCount }}
                            </div>
                        </div>

                        <div>
                            <label class="block mb-3 text-xl">Payments</label>
                            <div class="w-full bg-[#123f70] rounded px-5 py-3 text-lg">
                                {{ $paymentsCount }}
                            </div>
                        </div>
                    </div>

                    <h2 class="text-3xl mb-5">
                        Update Your password
                    </h2>

                    <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block mb-3 text-xl">Current password</label>
                            <input type="password" name="current_password"
                                class="w-full bg-[#123f70] rounded px-5 py-3 text-white outline-none border border-transparent focus:border-blue-300">
                        </div>

                        <div>
                            <label class="block mb-3 text-xl">New password</label>
                            <input type="password" name="password"
                                class="w-full bg-[#123f70] rounded px-5 py-3 text-white outline-none border border-transparent focus:border-blue-300">
                        </div>

                        <div>
                            <label class="block mb-3 text-xl">Confirm password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full bg-[#123f70] rounded px-5 py-3 text-white outline-none border border-transparent focus:border-blue-300">
                        </div>

                        <button type="submit"
                            class="bg-emerald-500 text-white px-6 py-3 rounded font-semibold hover:bg-emerald-600 transition">
                            Update Password
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </section>

@endsection
