@extends('admin.master')

@section('title', __('admin.edit_category'))

@section('css')
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.edit_category') }}
            </h1>

            <p class="admin-page-subtitle">
                Update category information, image, and related display details.
            </p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i>
            {{ __('admin.back') }}
        </a>
    </div>

    <div class="card admin-card">
        <div class="admin-card-header">
            <div>
                <h6>
                    <i class="fas fa-edit mr-1"></i>
                    {{ __('admin.edit_category') }}
                </h6>

                <span>{{ $category->name }}</span>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.categories._form')

                <div class="mt-4 d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-success shadow-sm">
                        <i class="fas fa-save mr-1"></i>
                        {{ __('admin.update') }}
                    </button>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">
                        {{ __('admin.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
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
