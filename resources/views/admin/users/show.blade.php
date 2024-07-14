@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>User Details</h2>

    <div class="user-details">
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
        <p><strong>Status:</strong> {{ $user->active ? 'Active' : 'Inactive' }}</p>
    </div>

    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('users.deactivate', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-danger">Deactivate</button>
    </form>
</div>

@include('partials.footer')
@endsection
