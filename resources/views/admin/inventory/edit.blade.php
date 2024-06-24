@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <h2>Edit Inventory</h2>
        <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="product_id">Product</label>
                <select class="form-control" id="product_id" name="product_id">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $inventory->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $inventory->quantity) }}">
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
