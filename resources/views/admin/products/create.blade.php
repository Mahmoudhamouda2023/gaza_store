@extends('admin.master')

@section('title', __('admin.add_new_product'))

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        {{ __('admin.add_new_product') }}
    </h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.products._form')

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
                const previewId = e.target.name === 'image' ? 'preview' : 'galleryPreview';
                document.getElementById(previewId).src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection
