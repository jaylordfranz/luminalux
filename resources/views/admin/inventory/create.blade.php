@extends('layouts.admin')


@section('content')
    @include('partials.header')


    <div class="main-content">
        <h2>Add Inventory</h2>


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


        <form id="addInventoryForm" action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="product_id">Product:</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Inventory</button>
        </form>
    </div>


    @include('partials.footer')
@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addInventoryForm').validate({
            rules: {
                product_id: {
                    required: true
                },
                quantity: {
                    required: true,
                    number: true,
                    min: 1 // Adjust as per your validation rules
                }
            },
            messages: {
                product_id: {
                    required: "Please select a product"
                },
                quantity: {
                    required: "Please enter the quantity",
                    number: "Please enter a valid number",
                    min: "The quantity must be at least 1" // Adjust message as per your validation rules
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
@endsection


