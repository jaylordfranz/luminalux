@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role" class="form-control" required>
                <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                <option value="Spectator" {{ $user->role == 'Spectator' ? 'selected' : '' }}>Spectator</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

@include('partials.footer')
@endsection
