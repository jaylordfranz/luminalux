@extends('layouts.app')

@section('title', 'Order Reviews')

@push('styles')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-5">
        <h2>Order Reviews</h2>

        @if ($order)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order ID: {{ $order->id }}</h5>
                    <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Checkout Status:</strong> {{ $order->checkout_status }}</p>
                    <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>

                    <h4 class="mt-4">Write a Review:</h4>
                    <form action="{{ route('reviews.store', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="review">Review:</label>
                            <textarea id="review" name="review" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>

                    <h4 class="mt-4">Existing Reviews:</h4>
                    @forelse ($order->reviews as $review)
                        <div class="card mb-2">
                            <div class="card-body">
                                {{ $review->content }}
                            </div>
                        </div>
                    @empty
                        <p>No reviews yet.</p>
                    @endforelse
                </div>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Order not found.
            </div>
        @endif
    </div>
@endsection
