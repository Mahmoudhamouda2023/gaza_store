@extends('admin.master')

@section('title', __('admin.add_new_category'))

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        {{ __('admin.add_new_category') }}
    </h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.categories._form')

        <button class="btn btn-success">
            <i class="fas fa-save"></i>
            {{ __('admin.add') }}
        </button>
    </form>
@endsection

@section('js')
    <script>
        function showImg(e) {
            const [file] = e.target.files;

            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection
