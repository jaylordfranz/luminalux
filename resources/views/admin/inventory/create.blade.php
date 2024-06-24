@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <h2>Add Inventory</h2>
        <form method="POST" action="{{ route('inventory.store') }}">
            @csrf
            <div class="form-group">
                <label for="product_id">Product</label>
                <select class="form-control" id="product_id" name="product_id">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
