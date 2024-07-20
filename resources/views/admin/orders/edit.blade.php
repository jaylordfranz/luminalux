@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="container">
    <h2>Edit Order #{{ $order->id }}</h2>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="checkout_status">Checkout Status</label>
            <select name="checkout_status" id="checkout_status" class="form-control">
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ $order->checkout_status === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control">
                @foreach($paymentStatuses as $paymentStatus)
                    <option value="{{ $paymentStatus }}" {{ $order->payment_status === $paymentStatus ? 'selected' : '' }}>
                        {{ $paymentStatus }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@include('partials.footer')
@endsection
