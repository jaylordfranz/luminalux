@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Category Product Chart</h2>
        <canvas id="categoryProductChart" width="400" height="200"></canvas>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/category_product_chart.js') }}"></script> <!-- Include your custom JavaScript file here -->
@endsection
