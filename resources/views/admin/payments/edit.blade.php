@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>Edit Payment Status</h2>

    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <select id="payment_status" name="payment_status" class="form-control">
                <option value="Pending" {{ $payment->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Verified" {{ $payment->payment_status == 'Verified' ? 'selected' : '' }}>Verified</option>
                <option value="Failed" {{ $payment->payment_status == 'Failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>

@include('partials.footer')
@endsection