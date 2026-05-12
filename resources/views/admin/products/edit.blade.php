@extends('admin.master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.products._form')

        <button class="btn btn-success">
            <i class="fas fa-save"></i> Update
        </button>
    </form>
@endsection

@section('title', 'Edit Product')

@section('js')
    <script>
        function showImg(e) {
            const [file] = e.target.files;
            if (file) {
                const previewId = e.target.name === 'gallery[]' ? 'preview-gallery' : 'preview';
                document.getElementById(previewId).src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection
