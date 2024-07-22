@extends('layouts.admin')


@section('content')
@include('partials.header')
<div class="container">
    <h1>Edit Supplier</h1>
    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
        </div>


        <div class="form-group">
            <label for="contact_info">Contact Info:</label>
            <input type="text" class="form-control" id="contact_info" name="contact_info" value="{{ old('contact_info', $supplier->contact_info) }}" required>
        </div>


        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $supplier->address) }}" required>
        </div>


        <div class="form-group">
            <label for="images">Images:</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
        </div>


        <div class="form-group">
            <label for="current_images">Current Images:</label>
            @foreach($supplier->images as $index => $image)
                <img src="{{ asset('storage/' . $image) }}" width="100" alt="Current Image">
                <!-- Add a hidden input field for each old image to keep track of which images to delete -->
                <input type="hidden" name="delete_images[]" value="{{ $image }}">
            @endforeach
        </div>


        <button type="submit" class="btn btn-primary">Update Supplier</button>
    </form>
</div>


@include('partials.footer')
@endsection
