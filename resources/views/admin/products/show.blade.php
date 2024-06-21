@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Product Details</h2>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 200px;">Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>${{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th>Stock Quantity</th>
                        <td>{{ $product->stock_quantity }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $product->category->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @include('partials.footer')
@endsection
