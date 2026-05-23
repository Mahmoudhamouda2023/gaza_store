@extends('admin.master')

@section('title', __('admin.all_products'))

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.all_products') }}
            </h1>
            <p class="admin-page-subtitle">
                Manage, search, sort, and control all store products from one place.
            </p>
        </div>

        @can('create products')
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
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
                    <i class="fas fa-box-open mr-1"></i>
                    {{ __('admin.all_products') }}
                </h6>
                <span>Total products: {{ $products->count() }}</span>
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
                            <th>{{ __('admin.category') }}</th>
                            <th>{{ __('admin.price') }}</th>
                            <th>{{ __('admin.stock') }}</th>
                            @canany(['edit products', 'delete products'])
                                <th class="no-sort">{{ __('admin.actions') }}</th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <span class="admin-index">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="admin-img">
                                </td>

                                <td>
                                    <div class="admin-name" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </div>
                                </td>

                                <td>
                                    <span class="admin-category">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="admin-price">
                                        {{ $product->formatted_price }}
                                    </span>
                                </td>

                                <td>
                                    @if ($product->is_available)
                                        <span class="admin-badge success">
                                            <i class="fas fa-check-circle"></i>
                                            {{ __('admin.available') }}
                                        </span>
                                    @else
                                        <span class="admin-badge danger">
                                            <i class="fas fa-times-circle"></i>
                                            {{ __('admin.unavailable') }}
                                        </span>
                                    @endif
                                </td>

                                @canany(['edit products', 'delete products'])
                                    <td>
                                        <div class="admin-actions">
                                            @can('edit products')
                                                <a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}"
                                                    title="{{ __('admin.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('delete products')
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                                    class="d-inline">
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
                                <td colspan="@canany(['edit products', 'delete products']) 7 @else 6 @endcanany"
                                    class="text-center py-5">
                                    <i class="fas fa-box-open fa-2x mb-3 text-gray-400"></i>
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
