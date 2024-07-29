@extends('layouts.admin')

@section('content')
@include('partials.header')
<form action="{{ route('users.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>
@include('partials.footer')
@endsection
