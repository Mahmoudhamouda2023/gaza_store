@extends('admin.master')

@section('title', __('admin.profile'))

@section('css')
    <style>
        .prev-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            padding: 5px;
            border: 1px dashed #b8b8b8;
            cursor: pointer;
            transition: all .3s ease;
        }

        .prev-img:hover {
            opacity: .8;
        }
    </style>
@endsection

@section('content')
    @php
        $admin = $admin ?? Auth::guard('admin')->user();

        $src =
            $admin && $admin->image
                ? asset('images/' . $admin->image->path)
                : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($admin?->name ?? 'Admin');
    @endphp

    <h1 class="h3 mb-4 text-gray-800">
        {{ __('admin.profile_page') }}
    </h1>

    <form action="{{ route('admin.profile_data') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-3">
                <label for="image">
                    <img class="prev-img" id="prevImg" src="{{ $src }}" alt="{{ __('admin.profile_image') }}">
                </label>

                <input type="file" onchange="showImg(event)" name="image" id="image" style="display: none">
            </div>

            <div class="col-md-9">
                <div class="mb-3">
                    <label>{{ __('admin.name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $admin?->name) }}">
                </div>

                <div class="mb-3">
                    <label>{{ __('admin.email') }}</label>
                    <input type="email" class="form-control" name="email" disabled value="{{ $admin?->email }}">
                </div>

                <br>

                <h4>{{ __('admin.update_your_password') }}</h4>

                <div class="mb-3">
                    <label>{{ __('admin.current_password') }}</label>
                    <input type="password" class="form-control" name="current_password">
                </div>

                <div class="mb-3">
                    <label>{{ __('admin.new_password') }}</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="mb-3">
                    <label>{{ __('admin.confirm_password') }}</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>

                <button class="btn btn-success">
                    {{ __('admin.update') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function showImg(e) {
            const file = e.target.files[0];

            if (file) {
                document.getElementById('prevImg').src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection
