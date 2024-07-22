@extends('layouts.admin')


@section('content')
@include('partials.header')
<div class="container">
    <h1>Supplier Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $supplier->name }}</h5>
            <p class="card-text"><strong>Contact Info:</strong> {{ $supplier->contact_info }}</p>
            <p class="card-text"><strong>Address:</strong> {{ $supplier->address }}</p>
            <p class="card-text"><strong>Images:</strong></p>
            @foreach($supplier->images as $image)
                <img src="{{ asset('storage/' . $image) }}" width="100" alt="Image">
            @endforeach
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>


@include('partials.footer')
@endsection


