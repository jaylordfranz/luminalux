@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Add Product</h2>

        {{-- Display validation errors summary --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="addProductForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="images">Product Images:</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    @include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addProductForm').validate({
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
                    number: "Please enter a valid number",
                    min: "The price must be at least 0"
                },
                stock_quantity: {
                    required: "Please enter the stock quantity",
                    number: "Please enter a valid number",
                    min: "The stock quantity must be at least 0"
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
