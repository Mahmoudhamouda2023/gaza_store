@extends('admin.master')

@section('title', __('admin.all_categories'))

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.all_categories') }}
            </h1>

            <p class="admin-page-subtitle">
                Manage, search, sort, and control all store categories from one place.
            </p>
        </div>

        @can('create categories')
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus mr-1"></i>
                {{ __('admin.add_new') }}
            </a>
        @endcan
    </div>

    @if (session()->has('msg'))
        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
            {{ session('msg') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card admin-card">
        <div class="admin-card-header">
            <div>
                <h6>
                    <i class="fas fa-tags mr-1"></i>
                    {{ __('admin.all_categories') }}
                </h6>

                <span>Total categories: {{ $categories->count() }}</span>
            </div>

            <span>
                <i class="fas fa-table mr-1"></i>
                DataTable View
            </span>
        </div>

        <div class="admin-table-wrapper">
            <div class="table-responsive">
                <table class="table table-bordered table-hover admin-data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="no-sort">{{ __('admin.image') }}</th>
                            <th>{{ __('admin.name') }}</th>
                            <th>{{ __('admin.products_count') }}</th>

                            @canany(['edit categories', 'delete categories'])
                                <th class="no-sort">{{ __('admin.actions') }}</th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <span class="admin-index">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <img src="{{ $category->img_path }}" alt="{{ $category->name }}" class="admin-img">
                                </td>

                                <td>
                                    <div class="admin-name" title="{{ $category->name }}">
                                        {{ $category->name }}
                                    </div>
                                </td>

                                <td>
                                    <span class="admin-category">
                                        {{ $category->products_count ?? $category->products->count() }}
                                    </span>
                                </td>

                                @canany(['edit categories', 'delete categories'])
                                    <td>
                                        <div class="admin-actions">
                                            @can('edit categories')
                                                <a class="btn btn-primary"
                                                    href="{{ route('admin.categories.edit', $category->id) }}"
                                                    title="{{ __('admin.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('delete categories')
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger delete-btn"
                                                        title="{{ __('admin.delete') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="@canany(['edit categories', 'delete categories']) 5 @else 4 @endcanany"
                                    class="text-center py-5">
                                    <i class="fas fa-tags fa-2x mb-3 text-gray-400"></i>
                                    <div>{{ __('admin.no_data_found') }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('back/js/admin-datatables.js') }}"></script>
@endsection
