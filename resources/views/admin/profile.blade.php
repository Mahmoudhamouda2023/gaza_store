@extends('admin.master')

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
    <h1 class="h3 mb-4 text-gray-800">Profile Page</h1>
    <form action="{{ route('admin.profile_data') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-3">
                @php
                    if ($admin->image) {
                        $src = asset('images/' . $admin->image->path);
                    } else {
                        $src = 'https://ui-avatars.com/api/?background=random&name=' . $admin->name;
                    }
                @endphp
                <label for="image">
                    <img class="prev-img" id="prevImg" src="{{ $src }}" alt="">
                </label>
                <input type="file" onchange="showImg(event)" name="image" id="image" style="display: none">
            </div>
            <div class="col-md-9">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $admin->name) }}">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" disabled value="{{ $admin->email }}">
                </div>
                <br>
                <h4>Update Your password</h4>
                <div class="mb-3">
                    <label>Current password</label>
                    <input type="password" class="form-control" name="current_password">
                </div>
                <div class="mb-3">
                    <label>New password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label>Confirm password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
@endsection

@section('title', 'Profile')

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
