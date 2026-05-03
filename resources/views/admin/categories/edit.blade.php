@extends('admin.master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Categories</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.categories._form')

        <button class="btn btn-success">
            <i class="fas fa-save"></i> Update
        </button>
    </form>
@endsection

@section('title', 'Dashboard')

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
