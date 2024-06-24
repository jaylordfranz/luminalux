<!-- resources/views/customer/makeup.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Makeup Products</h2>
    <div class="row">
        @for ($i = 1; $i <= 5; $i++)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <img src="https://via.placeholder.com/200" alt="Product Image">
                    <div class="product-name">Makeup Product {{ $i }}</div>
                    <div class="product-price">$XX.XX</div>
                    <button class="btn btn-primary product-btn">Add to Cart</button>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection
