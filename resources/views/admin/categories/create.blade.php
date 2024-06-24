@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Add Category</h2>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    @include('partials.footer')
@endsection
