@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Edit Discount Code</h2>
        <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="code">Discount Code:</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ $discount->code }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $discount->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="discount_percentage">Discount Percentage:</label>
                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" value="{{ $discount->discount_percentage }}" required>
            </div>
            <div class="form-group">
                <label for="valid_from">Valid From:</label>
                <input type="date" class="form-control" id="valid_from" name="valid_from" value="{{ $discount->valid_from }}" required>
            </div>
            <div class="form-group">
                <label for="valid_to">Valid To:</label>
                <input type="date" class="form-control" id="valid_to" name="valid_to" value="{{ $discount->valid_to }}" required>
            </div>

            <!-- Add fields for any additional details -->

            <button type="submit" class="btn btn-primary">Update Discount</button>
        </form>
    </div>

    @include('partials.footer')
@endsection
