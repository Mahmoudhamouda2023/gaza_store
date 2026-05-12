@extends('admin.master')

@section('title', 'All Products')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">All Products</h1>

    <table class="table table-bordered table-hover">
        <tr class="bg-dark text-white">
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>

        @forelse ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img width="100" height="100" src="{{ $product->img_path }}" alt="">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 0) }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', $product->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">لا يوجد منتجات</td>
            </tr>
        @endforelse
    </table>

    {{ $products->links() }}
@endsection
