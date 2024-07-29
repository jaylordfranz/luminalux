@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Discount Details</h2>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 200px;">Code</th>
                        <td>{{ $discount->code }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $discount->description }}</td>
                    </tr>
                    <tr>
                        <th>Discount Percentage</th>
                        <td>{{ $discount->discount_percentage }}%</td>
                    </tr>
                    <tr>
                        <th>Valid From</th>
                        <td>{{ $discount->valid_from->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>Valid To</th>
                        <td>{{ $discount->valid_to->format('Y-m-d') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('discounts.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @include('partials.footer')
@endsection
