@extends('layouts.admin')

@section('content')
@include('partials.header')
<div class="container">
    <h1>{{ isset($supplier) ? 'Edit Supplier' : 'Add Supplier' }}</h1>
    <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($supplier))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($supplier) ? $supplier->name : old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="contact_info">Contact Info:</label>
            <input type="text" class="form-control" id="contact_info" name="contact_info" value="{{ isset($supplier) ? $supplier->contact_info : old('contact_info') }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ isset($supplier) ? $supplier->address : old('address') }}" required>
        </div>
        <div class="form-group">
            <label for="images">Images:</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($supplier) ? 'Update' : 'Add' }}</button>
    </form>
</div>
@include('partials.footer')
@endsection
