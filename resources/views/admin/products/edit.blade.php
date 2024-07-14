@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Edit Product</h2>
        <form id="editProductForm" action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $product->price }}" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="{{ $product->stock_quantity }}" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Add fields for image upload if necessary -->

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    @include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editProductForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                description: {
                    required: true
                },
                price: {
                    required: true,
                    number: true,
                    min: 0
                },
                stock_quantity: {
                    required: true,
                    number: true,
                    min: 0
                },
                category_id: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a product name",
                    maxlength: "The name cannot be more than 255 characters"
                },
                description: {
                    required: "Please enter a description"
                },
                price: {
                    required: "Please enter a price",
                    number: "Please enter a valid price",
                    min: "Price cannot be negative"
                },
                stock_quantity: {
                    required: "Please enter the stock quantity",
                    number: "Please enter a valid quantity",
                    min: "Stock quantity cannot be negative"
                },
                category_id: {
                    required: "Please select a category"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
@endsection
