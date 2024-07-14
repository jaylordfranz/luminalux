<!-- resources/views/admin/products/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product Details</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>${{ number_format($product->price, 2) }}</td>
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

                    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
