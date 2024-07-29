<!-- resources/views/admin/users/show.blade.php -->

@extends('layouts.admin')

@section('content')
@include('partials.header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Details</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Name</th>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $customer->email }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>{{ ($customer->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back</a>

                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection


